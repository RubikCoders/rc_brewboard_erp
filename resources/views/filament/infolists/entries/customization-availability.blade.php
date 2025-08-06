@php
    $option = $getRecord();
    $availabilityInfo = $option->getAvailabilityInfo();
    $isAvailable = $availabilityInfo['available'];
    $status = $availabilityInfo['status'];
    $stock = $availabilityInfo['stock'];
@endphp

<div class="flex items-center space-x-2">
    {{-- Badge de estado --}}
    <x-filament::badge 
        :color="match($status) {
            'unlimited' => 'primary',
            'in_stock' => 'success',
            'low_stock' => 'warning',
            'out_of_stock' => 'danger',
            default => 'gray'
        }"
        size="sm"
    >
        @switch($status)
            @case('unlimited')
                Ilimitado
                @break
            @case('in_stock')
                En stock
                @break
            @case('low_stock')
                Stock bajo
                @break
            @case('out_of_stock')
                Agotado
                @break
            @default
                Desconocido
        @endswitch
    </x-filament::badge>

    {{-- Información de stock --}}
    @if($stock !== null && $stock >= 0)
        <span class="text-xs text-gray-600">
            ({{ $stock }} disponibles)
        </span>
    @endif

    {{-- Icono de estado --}}
    @if($isAvailable)
        <x-heroicon-o-check-circle class="w-4 h-4 text-green-500" />
    @else
        <x-heroicon-o-x-circle class="w-4 h-4 text-red-500" />
    @endif
</div>