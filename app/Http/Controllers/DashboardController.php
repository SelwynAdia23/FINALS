<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Campus;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = $this->getStats($user);
        $recentTickets = $this->getRecentTickets($user);
        $campuses = Campus::all();
        $categories = Category::all();

        return view('dashboard', compact('stats', 'recentTickets', 'campuses', 'categories'));
    }

    protected function getStats($user)
    {
        $query = Ticket::query();

        if ($user->isStudent()) {
            $query->where('user_id', $user->id);
        } elseif ($user->isFaculty() || $user->isStaff()) {
            $query->where(function ($q) use ($user) {
                $q->whereHas('category', fn($c) => $c->where('department', $user->department))
                  ->orWhere('assigned_to', $user->id);
            });
        } elseif ($user->isMaintenance()) {
            $query->where(function ($q) {
                $q->whereHas('category', fn($c) => $c->where('department', 'Maintenance'))
                  ->orWhere('assigned_to', auth()->id());
            });
        }

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'resolved' => (clone $query)->where('status', 'resolved')->count(),
            'urgent' => (clone $query)->where('priority', 'urgent')->whereNotIn('status', ['resolved', 'closed'])->count(),
        ];
    }

    protected function getRecentTickets($user)
    {
        $query = Ticket::with(['campus', 'category', 'assignee']);

        if ($user->isStudent()) {
            $query->where('user_id', $user->id);
        } elseif ($user->isFaculty() || $user->isStaff()) {
            $query->where(function ($q) use ($user) {
                $q->whereHas('category', fn($c) => $c->where('department', $user->department))
                  ->orWhere('assigned_to', $user->id);
            });
        } elseif ($user->isMaintenance()) {
            $query->where(function ($q) {
                $q->whereHas('category', fn($c) => $c->where('department', 'Maintenance'))
                  ->orWhere('assigned_to', auth()->id());
            });
        }

        return $query->latest()->take(5)->get();
    }
}
