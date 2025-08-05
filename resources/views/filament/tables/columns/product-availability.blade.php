@php
    $status = $getRecord()->getAvailabilityStatus();
    $badgeColors = [
        'available' => 'success',
        'low_stock' => 'warning', 
        'out_of_stock' => 'danger',
        'disabled' => 'gray',
        'missing_customizations' => 'warning'
    ];
    $color = $badgeColors[$status['status']] ?? 'gray';
@endphp

<div class="flex flex-col space-y-1">
    <x-filament::badge :color="$color" size="sm">
        {{ $status['message'] }}
    </x-filament::badge>
    
    @if($status['can_order'] && isset($status['max_quantity']) && $status['max_quantity'] <= 10)
        <span class="text-xs text-gray-500">
            Máx: {{ $status['max_quantity'] }}
        </span>
    @endif
</div>