<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
    @if($status === 'pending') bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
    @elseif($status === 'in_progress') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
    @elseif($status === 'resolved') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
    @else bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-400
    @endif">
    @if($status === 'in_progress') In Progress @else {{ ucfirst(str_replace('_', ' ', $status)) }} @endif
</span>
