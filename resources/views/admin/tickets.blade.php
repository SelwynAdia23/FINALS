<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Tickets') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Admin Dashboard</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tickets..." class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                        </div>
                        <div>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div>
                            <select name="priority" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">All Priority</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        <div>
                            <select name="category" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="campus" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">All Campuses</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ request('campus') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campus</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600">
                                        <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->ticket_number }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($ticket->subject, 40) }}</td>
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
                                                <button type="submit" class="btn-action btn-delete" onclick="confirmDelete('Delete ticket {{ $ticket->ticket_number }}?')">
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
                <div class="p-4 border-t border-gray-200">
                    {{ $tickets->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
