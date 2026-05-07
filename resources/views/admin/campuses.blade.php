<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campuses') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Tickets</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($campuses as $campus)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $campus->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $campus->code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $campus->address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $campus->tickets_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-200">
                    {{ $campuses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
