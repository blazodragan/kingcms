<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Enums\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DashboardController extends Controller
{

    public function index(): \Inertia\Response
    {

        $userId = auth()->user()->id;
        $isAdmin = auth()->user()->is_admin;

        $query = DB::table('tickets')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(id) as count'));

        if (!$isAdmin) $query = $query->where('user_id', $userId);

        // $openedTickets = (clone $query)
        //     ->where('status', Status::OPEN->value)
        //     ->groupBy('month')
        //     ->get();

        // $closedTickets = (clone $query)
        //     ->where('status', Status::CLOSED->value)
        //     ->groupBy('month')
        //     ->get();

        // $tickets = Ticket::with('user:id,name')->where('user_id',auth()->id())->limit(20)->get();
        // $total_tickets = Ticket::where('user_id',auth()->id())->count();
        // $opened_ticket = Ticket::where('user_id',auth()->id())->Opened()->count();
        // $resolved_ticket = Ticket::where('user_id',auth()->id())->Resolved()->count();
        // $unresolved_ticket = Ticket::where('user_id',auth()->id())->Unresolved()->count();
        // $locked_ticket = Ticket::where('user_id',auth()->id())->Locked()->count();

        return Inertia::render('Dashboard', [
            // 'tickets' => $tickets,
            // 'total_tickets' => $total_tickets,
            // 'opened_ticket' => $opened_ticket,
            // 'resolved_ticket' => $resolved_ticket,
            // 'unresolved_ticket' => $unresolved_ticket,
            // 'locked_ticket' => $locked_ticket,
            // 'opened' => $openedTickets,
            // 'closed' => $closedTickets,
        ]);
    }
}
