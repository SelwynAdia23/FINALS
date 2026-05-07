<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
    @if($priority === 'urgent') bg-red-100 text-red-800
    @elseif($priority === 'high') bg-orange-100 text-orange-800
    @elseif($priority === 'medium') bg-yellow-100 text-yellow-800
    @else bg-green-100 text-green-800
    @endif">
    {{ ucfirst($priority) }}
</span>
