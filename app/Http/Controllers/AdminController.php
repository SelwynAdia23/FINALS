<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Attachment;
use App\Models\TicketHistory;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tickets' => Ticket::count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'total_users' => User::count(),
            'students' => User::role('student')->count(),
            'staff' => User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['staff', 'faculty', 'maintenance']);
            })->count(),
        ];

        $recentTickets = Ticket::with(['user', 'category', 'campus', 'assignee'])
            ->latest()
            ->take(10)
            ->get();

        $ticketsByCategory = Category::select('categories.name', DB::raw('count(tickets.id) as count'))
            ->leftJoin('tickets', 'categories.id', '=', 'tickets.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->get();

        $ticketsByStatus = DB::table('tickets')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $ticketsByCampus = Campus::select('campuses.name', DB::raw('count(tickets.id) as count'))
            ->leftJoin('tickets', 'campuses.id', '=', 'tickets.campus_id')
            ->groupBy('campuses.id', 'campuses.name')
            ->orderByDesc('count')
            ->get();

        $urgentTickets = Ticket::where('priority', 'urgent')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->with(['user', 'category', 'campus'])
            ->latest()
            ->take(5)
            ->get();

        $avgResolutionTime = Ticket::whereNotNull('resolved_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
            ->value('avg_hours');

        return view('admin.dashboard', compact(
            'stats',
            'recentTickets',
            'ticketsByCategory',
            'ticketsByStatus',
            'ticketsByCampus',
            'urgentTickets',
            'avgResolutionTime'
        ));
    }

    public function tickets(Request $request)
    {
        $query = Ticket::with(['user', 'category', 'campus', 'assignee']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('campus')) {
            $query->where('campus_id', $request->campus);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tickets = $query->latest()->paginate(15);
        $categories = Category::all();
        $campuses = Campus::all();

        return view('admin.tickets', compact('tickets', 'categories', 'campuses'));
    }

    public function users()
    {
        $users = User::with('roles')->latest()->paginate(15);
        $roles = ['student', 'faculty', 'staff', 'maintenance', 'admin'];

        return view('admin.users', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:student,faculty,staff,maintenance,admin',
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users')
            ->with('success', 'Role updated successfully for ' . $user->name);
    }

    public function analytics()
    {
        $ticketsByMonth = Ticket::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $resolvedByMonth = Ticket::selectRaw('DATE_FORMAT(resolved_at, "%Y-%m") as month, COUNT(*) as count')
            ->whereNotNull('resolved_at')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $ticketsByCategory = Category::select('categories.name', DB::raw('count(tickets.id) as count'))
            ->leftJoin('tickets', 'categories.id', '=', 'tickets.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->get();

        $ticketsByPriority = DB::table('tickets')
            ->select('priority', DB::raw('count(*) as count'))
            ->groupBy('priority')
            ->get();

        $ticketsByCampus = Campus::select('campuses.name', DB::raw('count(tickets.id) as count'))
            ->leftJoin('tickets', 'campuses.id', '=', 'tickets.campus_id')
            ->groupBy('campuses.id', 'campuses.name')
            ->orderByDesc('count')
            ->get();

        $topIssues = Ticket::select('subject', DB::raw('count(*) as count'))
            ->groupBy('subject')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $avgResolutionByCategory = Category::selectRaw('categories.name, AVG(TIMESTAMPDIFF(HOUR, tickets.created_at, tickets.resolved_at)) as avg_hours')
            ->join('tickets', 'categories.id', '=', 'tickets.category_id')
            ->whereNotNull('tickets.resolved_at')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $dailyTrend = Ticket::selectRaw('DAYNAME(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderByRaw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")')
            ->get();

        return view('admin.analytics', compact(
            'ticketsByMonth',
            'resolvedByMonth',
            'ticketsByCategory',
            'ticketsByPriority',
            'ticketsByCampus',
            'topIssues',
            'avgResolutionByCategory',
            'dailyTrend'
        ));
    }

    public function categories()
    {
        $categories = Category::withCount('tickets')->latest()->paginate(15);

        return view('admin.categories', compact('categories'));
    }

    public function campuses()
    {
        $campuses = Campus::withCount('tickets')->latest()->paginate(15);

        return view('admin.campuses', compact('campuses'));
    }

    public function updateTicket(UpdateTicketRequest $request, Ticket $ticket)
    {
        $validated = $request->validated();
        $oldStatus = $ticket->status;
        $changes = [];

        if (isset($validated['status']) && $validated['status'] !== $oldStatus) {
            $changes['status'] = ['old' => $oldStatus, 'new' => $validated['status']];

            if ($validated['status'] === 'resolved') {
                $validated['resolved_at'] = now();
            } elseif ($oldStatus === 'resolved') {
                $validated['resolved_at'] = null;
            }
        }

        if (isset($validated['priority'])) {
            $changes['priority'] = ['old' => $ticket->priority, 'new' => $validated['priority']];
        }

        if (isset($validated['assigned_to'])) {
            $changes['assigned_to'] = ['old' => $ticket->assigned_to, 'new' => $validated['assigned_to']];
        }

        $ticket->update($validated);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'admin_updated',
            'comment' => $validated['comment'] ?? null,
            'changes' => !empty($changes) ? $changes : null,
        ]);

        return redirect()->route('admin.tickets')
            ->with('success', 'Ticket ' . $ticket->ticket_number . ' updated successfully.');
    }

    public function deleteTicket(Ticket $ticket)
    {
        foreach ($ticket->attachments as $attachment) {
            if (Storage::exists('public/' . $attachment->filename)) {
                Storage::delete('public/' . $attachment->filename);
            }
        }

        $ticketNumber = $ticket->ticket_number;
        $ticket->histories()->delete();
        $ticket->attachments()->delete();
        $ticket->delete();

        return redirect()->route('admin.tickets')
            ->with('success', 'Ticket ' . $ticketNumber . ' has been deleted.');
    }
}
