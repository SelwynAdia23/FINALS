<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Attachment;
use App\Models\TicketHistory;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            $tickets = $user->tickets()->with(['campus', 'category', 'assignee'])->latest()->paginate(10);
        } elseif ($user->isFaculty()) {
            $tickets = Ticket::whereHas('category', function ($q) use ($user) {
                $q->where('department', $user->department);
            })->orWhere('assigned_to', $user->id)
                ->with(['user', 'campus', 'category'])
                ->latest()
                ->paginate(10);
        } elseif ($user->isStaff()) {
            $tickets = Ticket::whereHas('category', function ($q) use ($user) {
                $q->where('department', $user->department);
            })->orWhere('assigned_to', $user->id)
                ->with(['user', 'campus', 'category'])
                ->latest()
                ->paginate(10);
        } elseif ($user->isMaintenance()) {
            $tickets = Ticket::whereHas('category', function ($q) {
                $q->where('department', 'Maintenance');
            })->orWhere('assigned_to', $user->id)
                ->with(['user', 'campus', 'category'])
                ->latest()
                ->paginate(10);
        } else {
            $tickets = Ticket::with(['user', 'campus', 'category', 'assignee'])->latest()->paginate(10);
        }

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $campuses = Campus::all();
        $categories = Category::all();

        return view('tickets.create', compact('campuses', 'categories'));
    }

    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['ticket_number'] = Ticket::generateTicketNumber();

        $category = Category::findOrFail($validated['category_id']);

        if (Auth::user()->hasAnyRole(['staff', 'maintenance'])) {
            $users = \App\Models\User::role($category->department)->get();
            if ($users->isNotEmpty()) {
                $validated['assigned_to'] = $users->first()->id;
            }
        }

        $ticket = Ticket::create($validated);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = $file->hashName();
                $file->storePubliclyAs('public/attachments', $filename);

                Attachment::create([
                    'ticket_id' => $ticket->id,
                    'filename' => 'attachments/' . $filename,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'comment' => 'Ticket submitted',
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket ' . $ticket->ticket_number . ' has been submitted successfully.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorizeAccess($ticket);

        $ticket->load(['user', 'campus', 'category', 'assignee', 'attachments', 'histories.user']);

        return view('tickets.show', compact('ticket'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->authorizeAccess($ticket);

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
            'action' => 'updated',
            'comment' => $validated['comment'] ?? null,
            'changes' => !empty($changes) ? $changes : null,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorizeDelete($ticket);

        foreach ($ticket->attachments as $attachment) {
            if (Storage::exists('public/' . $attachment->filename)) {
                Storage::delete('public/' . $attachment->filename);
            }
        }

        $ticketNumber = $ticket->ticket_number;
        $ticket->histories()->delete();
        $ticket->attachments()->delete();
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket ' . $ticketNumber . ' has been deleted.');
    }

    public function downloadAttachment(Attachment $attachment)
    {
        $this->authorizeAccess($attachment->ticket);

        if (!Storage::exists('public/' . $attachment->filename)) {
            abort(404);
        }

        return Storage::download('public/' . $attachment->filename, $attachment->original_filename);
    }

    protected function authorizeAccess(Ticket $ticket): void
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return;
        }

        if ($user->isFaculty() || $user->isStaff() || $user->isMaintenance()) {
            if ($ticket->category->department === $user->department || $ticket->assigned_to === $user->id) {
                return;
            }
        }

        if ($ticket->user_id !== $user->id && $ticket->assigned_to !== $user->id) {
            abort(403, 'You do not have permission to view this ticket.');
        }
    }

    protected function authorizeDelete(Ticket $ticket): void
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return;
        }

        if ($user->isFaculty() || $user->isStaff() || $user->isMaintenance()) {
            if ($ticket->category->department === $user->department || $ticket->assigned_to === $user->id) {
                return;
            }
        }

        abort(403, 'You do not have permission to delete this ticket.');
    }
}
