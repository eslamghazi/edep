<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Ticket;
use App\Charts\DashboardHomeChart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|admin')->except('index', 'show', 'supportIndex', 'report', 'resetFilters');
    }

    public function index()
    {
        $ticketsData = Ticket::query()
            ->select('status', DB::raw('COUNT(*) as tickets_count'))
            ->groupBy('status')
            ->get()
            ->pluck('tickets_count', 'status');

        $statusCounts = Ticket::join('users', 'tickets.user_id', '=', 'users.id')
            ->select('users.name', 'users.id', 'users.overall_review')
            ->selectRaw('COUNT(tickets.id) as ticketsCount')
            ->userRole()
            ->groupBy('users.id', 'users.name', 'users.overall_review')
            ->get()->toArray();


        // Initialize an empty array to store the results
        $userStatusCounts = [];

        // Iterate over the $statusCounts collection
        foreach ($statusCounts as $statusCount) {
            // Use overall_review if available, otherwise default to 0
            $overallReview = $statusCount['overall_review'] ?? 0;
            // Convert 0-5 rating to 0-100 percentage
            $userStatusCounts[$statusCount['name']] = (float)($overallReview * 20);
        }

        $ticketsChart = new DashboardHomeChart();
        $ticketsChart->height(250);
        $ticketsChart->options([
            'chart' => [
                'style' => [
                    'justify-self' => 'left'
                ]
            ]
        ]);

        // An associative array mapping English to Arabic status names
        $statusMappings = [
            'InProgress' => 'قيد التنفيذ',
            'New' => 'طلب جديد',
            'Closed' => 'طلب مغلق',
            'Close_request' => 'تم إرسال طلب الإغلاق',
            'Waiting' => 'بانتظار اعتماد التسعيرة',
        ];

        // Assuming $ticketsData->keys() returns a collection of English status names
        $arabicStatuses = $ticketsData->keys()->map(function ($status) use ($statusMappings) {
            return $statusMappings[$status] ?? $status;
        });

        $statusColors = [
            'InProgress' => '#ffc107',
            'New' => '#28a745',
            'Closed' => '#343a40',
            'Waiting' => '#007bff',
            'Close_request' => '#dc3545',
        ];

        $ticketsChart->labels($arabicStatuses);
        $ticketsChart->dataset('طلبات الصيانة', 'pie', $ticketsData->values())
            ->backgroundColor($ticketsData->keys()->map(function ($status) use ($statusColors) {
                return $statusColors[$status];
            }));

        $usersChart = new DashboardHomeChart;

        $usersChart->height(250);
        $usersChart->labels(array_keys($userStatusCounts));
        $usersChart->dataset('تقييم الفنيين %', 'bar', array_values($userStatusCounts))->backgroundColor(['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']);


        return view('dashboard.home.index', [
            'usersCount' => User::count(),
            'ticketsChart' => $ticketsChart,
            'usersChart' => $usersChart,
            'ticketsCount' => Ticket::count(),
            'tickets' => Ticket::orderBy('created_at', 'desc')->paginate(10),
            'newTickets' => Ticket::where('status', 'new')->count(),
            'inProgressTickets' => Ticket::where('status', 'inProgress')->count(),
            'closedTickets' => Ticket::where('status', 'closed')->count(),
            'closeRequestTickets' => Ticket::where('status', 'close_request')->count(),
            'waitingTickets' => Ticket::where('status', 'waiting')->count(),
        ]);
    }
}
