<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
    @if($priority === 'urgent') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
    @elseif($priority === 'high') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300
    @elseif($priority === 'medium') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
    @else bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
    @endif">
    {{ ucfirst($priority) }}
</span>
