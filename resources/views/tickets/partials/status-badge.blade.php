<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
    @if($status === 'pending') bg-gray-100 text-gray-800
    @elseif($status === 'in_progress') bg-blue-100 text-blue-800
    @elseif($status === 'resolved') bg-green-100 text-green-800
    @else bg-gray-200 text-gray-600
    @endif">
    @if($status === 'in_progress') In Progress @else {{ ucfirst(str_replace('_', ' ', $status)) }} @endif
</span>
