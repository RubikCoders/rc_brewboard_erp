@php
    $record = $getRecord();
    $status = $record->getStockStatus();
    $statusMessage = $record->getStockStatusMessage();
    $needsRestock = $record->needsUrgentRestock();
    
    $badgeColors = [
        'out_of_stock' => 'danger',
        'critical' => 'danger', 
        'low' => 'warning',
        'excess' => 'info',
        'normal' => 'success'
    ];
    $color = $badgeColors[$status] ?? 'gray';
@endphp

<div class="flex flex-col space-y-1">
    {{-- Badge principal --}}
    <x-filament::badge :color="$color" size="sm">
        {{ $statusMessage }}
    </x-filament::badge>
    
    {{-- Indicadores adicionales --}}
    @if($needsRestock)
        <div class="flex items-center space-x-1">
            <x-heroicon-o-exclamation-triangle class="w-3 h-3 text-red-500" />
            <span class="text-xs text-red-600 font-medium">
                Reabastecer urgente
            </span>
        </div>
    @endif
    
    {{-- Recomendación de restock --}}
    @if($record->getRecommendedRestock() > 0)
        <span class="text-xs text-gray-500">
            Sugerido: +{{ $record->getRecommendedRestock() }}
        </span>
    @endif
</div>