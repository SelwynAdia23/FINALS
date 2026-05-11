<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $ticket->ticket_number }}
            </h2>
            <div class="flex items-center gap-2">
                @if(!auth()->user()->isStudent())
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" onclick="confirmDelete('Delete ticket {{ $ticket->ticket_number }}?')">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3a4 4 0 00-4 4v0a6 6 0 0112 0z"/></svg>
                            Delete
                        </button>
                    </form>
                @endif
                <a href="{{ auth()->user()->isAdmin() ? route('admin.tickets') : route('tickets.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">&larr; Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $ticket->subject }}</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Submitted on {{ $ticket->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="flex gap-2">
                            @include('tickets.partials.priority-badge', ['priority' => $ticket->priority])
                            @include('tickets.partials.status-badge', ['status' => $ticket->status])
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Campus</span>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $ticket->campus->name }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Category</span>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $ticket->category->name }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Department</span>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $ticket->category->department }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Assigned To</span>
                            <p class="text-sm text-gray-900 dark:text-gray-100 mt-1">{{ $ticket->assignee?->name ?? 'Unassigned' }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $ticket->description }}</div>
                    </div>

                    @if($ticket->attachments->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Attachments ({{ $ticket->attachments->count() }})</h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach($ticket->attachments as $attachment)
                                    <a href="{{ route('tickets.attachments.download', $attachment) }}" class="flex items-center gap-2 px-3 py-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-700">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $attachment->original_filename }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($ticket->resolution)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Resolution</h3>
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 text-sm text-green-900 dark:text-green-300 whitespace-pre-wrap">{{ $ticket->resolution }}</div>
                            @if($ticket->resolved_at)
                                <p class="text-xs text-green-600 dark:text-green-400 mt-2">Resolved on {{ $ticket->resolved_at->format('F d, Y \a\t g:i A') }}</p>
                            @endif
                        </div>
                    @endif

                    @if(!auth()->user()->isStudent())
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Update Ticket</h3>
                            <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                                        <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                            <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                            <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="resolution" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Resolution / Notes</label>
                                    <textarea name="resolution" id="resolution" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Add resolution details...">{{ $ticket->resolution }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Internal Comment</label>
                                    <textarea name="comment" id="comment" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Add a comment about this update..."></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="btn-action btn-edit" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Update Ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Activity History</h3>
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @forelse($ticket->histories as $history)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-blue-500 dark:bg-blue-600 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-900 dark:text-gray-100">
                                                        <span class="font-medium">{{ $history->user->name }}</span>
                                                        {{ str_replace('_', ' ', $history->action) }}
                                                    </p>
                                                    @if($history->comment)
                                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $history->comment }}</p>
                                                    @endif
                                                    @if($history->changes)
                                                        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                            @foreach($history->changes as $field => $change)
                                                                <p>{{ ucfirst($field) }}: {{ is_array($change['old']) ? json_encode($change['old']) : $change['old'] ?? 'N/A' }} &rarr; {{ is_array($change['new']) ? json_encode($change['new']) : $change['new'] ?? 'N/A' }}</p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $history->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No activity yet</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
