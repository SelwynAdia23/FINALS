<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Tickets by Category</h3>
                    <div class="space-y-3">
                        @foreach($ticketsByCategory as $cat)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $ticketsByCategory->max('count') > 0 ? ($cat->count / $ticketsByCategory->max('count')) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 w-8">{{ $cat->count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Tickets by Priority</h3>
                    <div class="space-y-3">
                        @foreach($ticketsByPriority as $p)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">{{ ucfirst($p->priority) }}</span>
                                <span class="text-sm font-medium text-gray-900">{{ $p->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Tickets by Campus</h3>
                    <div class="space-y-3">
                        @foreach($ticketsByCampus as $campus)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">{{ $campus->name }}</span>
                                <span class="text-sm font-medium text-gray-900">{{ $campus->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Avg Resolution Time by Category</h3>
                    <div class="space-y-3">
                        @foreach($avgResolutionByCategory as $cat)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($cat->avg_hours, 1) }} hrs</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Top Recurring Issues</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issue</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Occurrences</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($topIssues as $index => $issue)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $issue->subject }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $issue->count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Monthly Ticket Trends</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Resolved</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php
                                    $allMonths = $ticketsByMonth->pluck('month')->merge($resolvedByMonth->pluck('month'))->unique()->sort();
                                @endphp
                                @foreach($allMonths as $month)
                                    @php
                                        $submitted = $ticketsByMonth->firstWhere('month', $month)?->count ?? 0;
                                        $resolved = $resolvedByMonth->firstWhere('month', $month)?->count ?? 0;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $submitted }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $resolved }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
