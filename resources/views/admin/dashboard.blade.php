<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">&larr; Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                <a href="{{ route('admin.tickets') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md dark:hover:shadow-gray-800/50 transition cursor-pointer block">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tickets</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_tickets'] }}</div>
                </a>
                <a href="{{ route('admin.tickets', ['status' => 'pending']) }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md dark:hover:shadow-gray-800/50 transition cursor-pointer block">
                    <div class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Pending</div>
                    <div class="mt-1 text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</div>
                </a>
                <a href="{{ route('admin.tickets', ['status' => 'in_progress']) }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md dark:hover:shadow-gray-800/50 transition cursor-pointer block">
                    <div class="text-sm font-medium text-blue-600 dark:text-blue-400">In Progress</div>
                    <div class="mt-1 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['in_progress'] }}</div>
                </a>
                <a href="{{ route('admin.tickets', ['status' => 'resolved']) }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md dark:hover:shadow-gray-800/50 transition cursor-pointer block">
                    <div class="text-sm font-medium text-green-600 dark:text-green-400">Resolved</div>
                    <div class="mt-1 text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['resolved'] }}</div>
                </a>
                <a href="{{ route('admin.tickets', ['status' => 'closed']) }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md dark:hover:shadow-gray-800/50 transition cursor-pointer block">
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Closed</div>
                    <div class="mt-1 text-3xl font-bold text-gray-600 dark:text-gray-400">{{ $stats['closed'] }}</div>
                </a>
                <a href="{{ route('admin.users') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md dark:hover:shadow-gray-800/50 transition cursor-pointer block">
                    <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Users</div>
                    <div class="mt-1 text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['total_users'] }}</div>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">By Category</h3>
                    <div class="space-y-2">
                        @foreach($ticketsByCategory->take(8) as $cat)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $cat->name }}</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $cat->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">By Campus</h3>
                    <div class="space-y-2">
                        @foreach($ticketsByCampus as $campus)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $campus->name }}</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $campus->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Students</span>
                            <span class="text-sm font-medium">{{ $stats['students'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Faculty/Staff</span>
                            <span class="text-sm font-medium">{{ $stats['staff'] }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-3">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Avg. Resolution</span>
                            <span class="text-sm font-medium">{{ $avgResolutionTime ? number_format($avgResolutionTime, 1) . ' hrs' : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @if($urgentTickets->count() > 0)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-red-50 dark:bg-red-900/20">
                            <h3 class="font-semibold text-red-800 dark:text-red-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
                                Urgent Tickets
                            </h3>
                        </div>
                        <div class="p-4 space-y-3">
                            @foreach($urgentTickets as $ticket)
                                <div class="flex items-center justify-between p-3 border border-red-200 rounded-lg">
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-sm font-medium text-blue-600 hover:underline">{{ $ticket->ticket_number }}</a>
                                        <span class="text-sm text-gray-900 ml-2">{{ Str::limit($ticket->subject, 40) }}</span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $ticket->user->name }} | {{ $ticket->campus->name }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.tickets') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                            <div>
                                <span class="text-sm font-medium text-gray-900">Manage Tickets</span>
                                <p class="text-xs text-gray-500">View, filter, and delete tickets</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('admin.users') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                            <div>
                                <span class="text-sm font-medium text-gray-900">Manage Users</span>
                                <p class="text-xs text-gray-500">Assign and update user roles</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('admin.analytics') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                            <div>
                                <span class="text-sm font-medium text-gray-900">Analytics</span>
                                <p class="text-xs text-gray-500">View reports and trends</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('admin.categories') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                            <div>
                                <span class="text-sm font-medium text-gray-900">Categories</span>
                                <p class="text-xs text-gray-500">View concern categories</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('admin.campuses') }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                            <div>
                                <span class="text-sm font-medium text-gray-900">Campuses</span>
                                <p class="text-xs text-gray-500">View campus information</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900">Recent Tickets</h3>
                    <a href="{{ route('admin.tickets') }}" class="text-sm text-blue-600 hover:text-blue-800">View all &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campus</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentTickets as $ticket)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-l-4 {{ match($ticket->status) { 'pending' => 'border-yellow-400 dark:border-yellow-600', 'in_progress' => 'border-blue-400 dark:border-blue-600', 'resolved' => 'border-green-400 dark:border-green-600', 'closed' => 'border-gray-400 dark:border-gray-600', default => 'border-transparent' } }}">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600 dark:text-blue-400">
                                        <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->ticket_number }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($ticket->subject, 35) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $ticket->user->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $ticket->category->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $ticket->campus->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">@include('tickets.partials.priority-badge', ['priority' => $ticket->priority])</td>
                                    <td class="px-4 py-3 whitespace-nowrap">@include('tickets.partials.status-badge', ['status' => $ticket->status])</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <div class="flex gap-1">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="btn-action btn-view" title="View">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                View
                                            </a>
                                            <form action="{{ route('admin.tickets.delete', $ticket) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Delete" onclick="confirmDelete('Delete ticket {{ $ticket->ticket_number }}? This cannot be undone.')">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3a4 4 0 00-4 4v0a6 6 0 0112 0z"/></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
