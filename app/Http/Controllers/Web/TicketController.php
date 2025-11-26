<?php

namespace App\Http\Controllers\Web;

use App\Models\City;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Printer;
use App\Models\Review;
use App\Models\Department;
use App\Models\ProblemType;
use Illuminate\Http\Request;
use App\Jobs\SendNewTicketEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Services\TicketService;

class TicketController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $printers = Printer::all();
        $problemTypes = ProblemType::all();
        $cities = City::all();
        $departments = Department::all();

        return view('web.tickets.create', compact('printers', 'problemTypes', 'cities', 'departments'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, TicketService $ticketService)
    {
        $ticket_code  =  $this->generateTicketCode();
        $request->merge(['ticket_code' => $ticket_code]);
        $ticket = Ticket::create($request->all());
        $usersEmails = User::role(['super-admin', 'admin'])->pluck('email');

        $emails = $usersEmails->merge([$ticket->email, ' Sales@medadalaamal.com']);

        // send sms message for customer and super admin
        #TODO: Active this Later
        $ticketService->sendNewTicketSms($ticket);

        SendNewTicketEmail::dispatch($emails, $ticket);

        return redirect()->route('ticket.details', $ticket->id)->with('success', __('tickets.success_request_sent'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $printers = Printer::all();
        $problemTypes = ProblemType::all();
        $departments = Department::all();
        // $cities = City::all();
        // $buildings = $ticket->city ? $ticket->city->buildings : collect();

        return view('web.tickets.show', compact(['ticket', 'printers', 'problemTypes', 'departments']));
    }

    public function findTicket(Request $request)
    {
        $ticket = Ticket::where('ticket_code', $request->ticket_code)->first();

        if (!$ticket) {
            return back()->with('error', ' هذا الطلب غير موجود');
        }
        return $this->show($ticket);
    }

    public function details(Ticket $ticket)
    {
        return view('web.tickets.details', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function closeTicket(Ticket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        return redirect()->route('home')->with('success', 'تم اغلاق طلبك بنجاح');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        return back()->with('success', 'تم تعديل طلبك بنجاح');
    }

    public function generateTicketCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (Ticket::where("ticket_code", $code)->first());

        return $code;
    }

    /**
     * Review page: accepts query param 'id' for ticket, fetches technician and existing review.
     */
    public function review(Request $request)
    {
        $ticketId = $request->query('id');
        if (!$ticketId) {
            return redirect()->route('home')->with('error', 'Missing ticket id');
        }

        $ticket = Ticket::with(['user', 'review'])->findOrFail($ticketId);
        $technician = $ticket->user; // Assigned technician relation
        $existingReview = $ticket->review; // Existing review if any

        return view('web.tickets.review', compact('ticket', 'technician', 'existingReview'));
    }

    /**
     * Store a new review for a ticket.
     */
    public function storeReview(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'service_quality' => 'required|integer|min:1|max:5',
            'response_time' => 'required|integer|min:1|max:5',
            'technician_behavior' => 'required|integer|min:1|max:5',
            'technician_competence' => 'required|integer|min:1|max:5',
            'problem_solved' => 'required|in:full,partial,no,yes_certainly',
            'notes' => 'nullable|string|max:1000',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        // Check if review already exists
        if ($ticket->review) {
            return redirect()->route('tickets.review', ['id' => $ticket->id])
                ->with('error', __('tickets.review_already_exists'));
        }

        // Create the review
        $review = Review::create([
            'ticket_id' => $ticket->id,
            'technician_name' => $ticket->user?->name,
            'service_quality' => $request->service_quality,
            'response_time' => $request->response_time,
            'technician_behavior' => $request->technician_behavior,
            'technician_competence' => $request->technician_competence,
            'problem_solved' => $request->problem_solved,
            'notes' => $request->notes,
        ]);

        // Calculate average rating for this review (4 star fields)
        $reviewAverage = (
            $request->service_quality +
            $request->response_time +
            $request->technician_behavior +
            $request->technician_competence
        ) / 4;

        // Update technician's overall review rating
        if ($ticket->user) {
            $technician = $ticket->user;
            $totalReviews = $technician->total_reviews + 1;
            $currentOverallReview = $technician->overall_review ?? 0;

            // Calculate new overall review (weighted average)
            $newOverallReview = ($currentOverallReview * ($totalReviews - 1) + $reviewAverage) / $totalReviews;

            $technician->update([
                'overall_review' => $newOverallReview,
                'total_reviews' => $totalReviews,
            ]);
        }

        return redirect()->route('tickets.review', ['id' => $ticket->id])
            ->with('success', __('tickets.review_submitted_successfully'));
    }
}
