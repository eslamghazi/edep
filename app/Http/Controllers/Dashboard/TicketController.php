<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Printer;
use App\Models\ProblemType;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\SendNewTicketEmail;
use App\Jobs\SendCloseTicketEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Jobs\SendNewAssignTicketEmail;

class TicketController extends Controller
{
    public function __construct(protected TicketService $ticketService)
    {
        $this->middleware('role:super-admin|admin')->except('index', 'show', 'supportIndex', 'report', 'resetFilters', 'closeTicket', 'generateAndSavePdf', 'sendTicketCloseCodeSms', 'sendCloseOtp', 'getReview');
    }

    public function index(Request $request)
    {
        $problemTypes = ProblemType::pluck('name', 'id');
        $users = User::role('user')->pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        // Add departments for filters
        $departments = Department::all();

        $tickets = Ticket::with('review')->filter($request->only('user', 'type_id', 'status', 'city_id', 'start_date', 'end_date', 'ticket_code', 'phone_number', 'requester_name', 'printer_code', 'date_range', 'department_id'))->userRole()->orderBy('created_at', 'desc')->paginate(20);

        $newTickets = Ticket::where('status', 'new')->count();
        $inProgressTickets = Ticket::where('status', 'inProgress')->count();
        $closedTickets = Ticket::where('status', 'closed')->count();
        $waitingTickets = Ticket::where('status', 'waiting')->count();
        $closeRequestTickets = Ticket::where('status', 'close_request')->count();
        $ticketsCount = Ticket::count();


        return view('dashboard.tickets.index', get_defined_vars());
    }

    public function show($id)
    {
        $ticket = $this->ticketService->getTicketById($id);
        return view('dashboard.tickets.show', compact('ticket'));
    }

    public function create()
    {
        $printers = Printer::all();
        $problemTypes = ProblemType::all();
        $cities = City::all();
        // Add departments for form
        $departments = Department::all();

        return view('dashboard.tickets.create', get_defined_vars());
    }


    public function store(StoreTicketRequest $request)
    {
        $attributes = $request->validated();

        $ticket_code  =  $this->generateTicketCode('ticket_code');
        $attributes['ticket_code'] = $ticket_code;

        $ticket = $this->ticketService->createTicket($attributes);

        // send sms message for customer and super admin
        #TODO: Active this Later
        $ticketService->sendNewTicketSms($ticket);

        SendNewTicketEmail::dispatch([$ticket->email], $ticket);

        return redirect()->route('dashboard.tickets.index')->with('success', 'تم ارسال طلبك بنجاح');
    }

    public function edit(Ticket $ticket)
    {
        $printers = Printer::all();
        $problemTypes = ProblemType::all();
        $cities = City::all();
        $users = User::role('user')->pluck('name', 'id');
        // Add departments for form
        $departments = Department::all();

        return view('dashboard.tickets.edit', get_defined_vars());
    }

    public function update(UpdateTicketRequest $request, $id)
    {
        $attributes = $request->validated();
        $this->ticketService->updateTicket($id, $attributes);
        return redirect()->route('dashboard.tickets.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $this->ticketService->deleteTicket($id);
        return redirect()->route('dashboard.tickets.index')->with('success', 'تم الحذف بنجاح');
    }

    public function assign(Request $request)
    {
        $ticket  = Ticket::findOrFail($request->ticket_id);
        $ticket->update([
            'user_id' => $request->user_id,
        ]);

        SendNewAssignTicketEmail::dispatch([$ticket->user->email], $ticket);

        return back()->with('success', 'تمت العملية بنجاح');
    }

    public function closeTicket(Request $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);

        // Check if user is a super admin
        if (auth()->user()->role('super-admin')) {
            // Super admin logic
            $ticket->update([
                'status' => 'closed',
            ]);
            return back()->with('success', 'تمت العملية بنجاح');
        } else {
            // Regular user logic
            if ($request->close_code == $ticket->close_code) {
                $ticket->update([
                    'status' => 'closed',
                ]);
                return back()->with('success', 'تمت العملية بنجاح');
            } else {
                return back()->with('error', 'هذا الرقم غير صحيح ل هذا الطلب');
            }
        }
    }

    public function sendCloseOtp(Request $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);
        $recipientTypes = $request->recipient_types;
        
        // Ensure it's an array
        if (!is_array($recipientTypes)) {
            $recipientTypes = [$recipientTypes];
        }

        // Generate close code if not already generated
        if (!$ticket->close_code) {
            $close_code = $this->generateCloseCode('close_code');
            $ticket->update(['close_code' => $close_code]);
        }

        $errors = [];

        // Send SMS to selected recipients
        if (in_array('requester', $recipientTypes)) {
            // Send to the requester's phone from ticket
            #TODO: Active this Later
            $response = $this->ticketService->sendCloseCodeSms($ticket, $ticket->phone);
            $data = $response->getData(true);
            if (isset($data['status']) && $data['status'] === 'error') {
                $errors[] = "صاحب الطلب: " . ($data['message'] ?? 'Unknown error');
            }
        }
        
        if (in_array('anas', $recipientTypes)) {
            // Send to أ/أنس phone
             #TODO: Active this Later
            $response = $this->ticketService->sendCloseCodeSms($ticket, config('services.support.anas_phone'));
            $data = $response->getData(true);
            if (isset($data['status']) && $data['status'] === 'error') {
                $errors[] = "أ/أنس: " . ($data['message'] ?? 'Unknown error');
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل إرسال الرسالة لـ: ' . implode(', ', $errors)
            ]);
        }

        // Always send email to ticket email
        SendCloseTicketEmail::dispatch([$ticket->email], $ticket);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رمز التحقق بنجاح'
        ]);
    }

    public function sendTicketCloseCodeSms(Request $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);

        // Check if the ticket is already closed
        if ($ticket->close_code) {
            return response()->json(['message' => 'SMS for this Ticket already sent'], 400);
        }

        $close_code  = $this->generateCloseCode('close_code');
        $ticket->update(['close_code' => $close_code]);

        // Send SMS and email
         #TODO: Active this Later
        $this->ticketService->sendCloseCodeSms($ticket);
        SendCloseTicketEmail::dispatch([$ticket->email], $ticket);

        return response()->json(['message' => 'Ticket closed successfully']);
    }

    public function report(Request $request)
    {
        $ticket  = Ticket::findOrFail($request->ticket_id);

        // Update the ticket with the report details
        $ticket->update([
            'report' => $request->report,
            'reported_by' => auth()->user()->id
        ]);

        return back()->with('success', 'تمت العملية بنجاح');
    }

    public function getReview($ticketId)
    {
        // Include soft-deleted tickets to allow reviews for trashed items
        $ticket = Ticket::withTrashed()->with(['review', 'user'])->findOrFail($ticketId);

        return response()->json([
            'review' => $ticket->review,
            'ticket' => $ticket,
        ]);
    }

    public function supportIndex(Request $request)
    {
        $problemTypes = ProblemType::pluck('name', 'id');
        $users = User::role('user')->pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        // Add departments for filters
        $departments = Department::all();

        $tickets = Ticket::with('review')->filter($request->only('user', 'type_id', 'status', 'city_id', 'start_date', 'end_date', 'ticket_code', 'phone_number', 'requester_name', 'printer_code', 'date_range', 'department_id'))->userRole()->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.support.index', get_defined_vars());
    }


    public function resetFilters()
    {
        request()->session()->forget(['user', 'type_id', 'status', 'city_id', 'start_date', 'end_date', 'ticket_code', 'requester_name', 'phone_number', 'printer_code', 'date_range', 'department_id']);


        if (request()->has('trash') && request('trash') == 1) {
            return redirect()->route('dashboard.tickets.trash');
        }

        if (auth()->user()->hasRole('user')) {

            return redirect()->route('dashboard.tickets.support');
        }

        return redirect()->route('dashboard.tickets.index');
    }


    public function generateTicketCode($column)
    {
        do {
            $code = random_int(100000, 999999);
        } while (Ticket::where($column, $code)->first());

        return $code;
    }

    private function generateCloseCode($column)
    {
        do {
            $code = random_int(100, 999);
        } while (Ticket::where($column, $code)->first());

        return $code;
    }

    public function trash(Request $request)
    {
        $problemTypes = ProblemType::pluck('name', 'id');
        $users = User::role('user')->pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        // Add departments for filters
        $departments = Department::all();

        $trashedTickets = Ticket::onlyTrashed()->with('review')->filter($request->only('user', 'type_id', 'status', 'city_id', 'start_date', 'end_date', 'ticket_code', 'phone_number', 'requester_name', 'printer_code', 'date_range', 'department_id'))->userRole()->orderBy('deleted_at', 'desc')->paginate(20);

        return view('dashboard.tickets.trashed', get_defined_vars());
    }

    public function restore($id)
    {
        $ticket = Ticket::withTrashed()->findOrFail($id);
        $ticket->restore();

        return redirect()->route('dashboard.tickets.trash')->with('success', 'تم استعادة الطلب بنجاح');
    }

    public function forceDelete($id)
    {
        $ticket = Ticket::withTrashed()->findOrFail($id);
        $ticket->forceDelete();

        return redirect()->route('dashboard.tickets.trash')->with('success', 'تم حذف الطلب نهائيا بنجاح');
    }

    public function generateAndSavePdf(Ticket $ticket = null)
    {
        if ($ticket) {
            // Generating a PDF for a single ticket
            $view = view('dashboard.tickets.pdfs.show', compact('ticket'))->toArabicHTML();
            $pdfName = $this->generatePdfName($ticket);
        } else {
            // Generating a PDF for all tickets
            $inProgressTickets = Ticket::where('status', 'inProgress')->count();
            $closedTickets = Ticket::where('status', 'closed')->count();
            $newTickets = Ticket::where('status', 'new')->count();
            $waitingTickets = Ticket::where('status', 'waiting')->count();
            $closeRequestTickets = Ticket::where('status', 'close_request')->count();
            $tickets = Ticket::userRole()->orderBy('created_at', 'desc')->get();

            $view = view('dashboard.tickets.pdfs.index', get_defined_vars())->toArabicHTML();
            $pdfName = 'Tickets-Summary-' . now()->format('Y-m-d-His') . '.pdf';
        }

        $pdf = PDF::loadHTML($view)->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]); // Set the paper size and orientation

        return $pdf->download($pdfName);
    }

    private function generatePdfName($ticket)
    {
        // Generate a name for the PDF file
        return 'ticket-' . $ticket->id . '-' . now()->format('Y-m-d-His') . '.pdf';
    }
}
