@php
    $record = $getRecord();
    $status = $record->getAvailabilityStatus();
    $missingIngredients = $record->getMissingIngredients();
    $maxQuantity = $record->getMaxAvailableQuantity();
@endphp

<div class="space-y-4">
    {{-- Estado general --}}
    <div class="flex items-center space-x-3">
        <x-filament::badge 
            :color="match($status['status']) {
                'available' => 'success',
                'low_stock' => 'warning',
                'out_of_stock' => 'danger',
                'disabled' => 'gray',
                'missing_customizations' => 'warning',
                default => 'gray'
            }"
            size="lg"
        >
            {{ $status['message'] }}
        </x-filament::badge>
        
        @if($status['can_order'])
            <span class="text-sm text-green-600 font-medium">
                ✓ Puede ordenarse
            </span>
        @else
            <span class="text-sm text-red-600 font-medium">
                ✗ No disponible
            </span>
        @endif
    </div>

    {{-- Información de stock --}}
    @if($record->inventory)
        <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
            <h4 class="font-medium text-blue-900 mb-2">Inventario Directo</h4>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-blue-700 font-medium">Stock actual:</span>
                    <span class="text-blue-900">{{ $record->inventory->stock }}</span>
                </div>
                <div>
                    <span class="text-blue-700 font-medium">Stock mínimo:</span>
                    <span class="text-blue-900">{{ $record->inventory->min_stock }}</span>
                </div>
                <div>
                    <span class="text-blue-700 font-medium">Stock máximo:</span>
                    <span class="text-blue-900">{{ $record->inventory->max_stock }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
            <p class="text-sm text-gray-600">
                <x-heroicon-o-information-circle class="w-4 h-4 inline mr-1"/>
                Este producto se prepara por ingredientes (sin stock directo)
            </p>
        </div>
    @endif

    {{-- Cantidad máxima disponible --}}
    @if($status['can_order'])
        <div class="bg-green-50 rounded-lg p-3 border border-green-200">
            <p class="text-sm text-green-800">
                <x-heroicon-o-check-circle class="w-4 h-4 inline mr-1"/>
                <span class="font-medium">Cantidad máxima disponible:</span>
                @if($maxQuantity > 100)
                    Más de 100 unidades
                @else
                    {{ $maxQuantity }} unidades
                @endif
            </p>
        </div>
    @endif

    {{-- Ingredientes faltantes --}}
    @if(!empty($missingIngredients))
        <div class="bg-red-50 rounded-lg p-3 border border-red-200">
            <h4 class="font-medium text-red-900 mb-2">
                <x-heroicon-o-exclamation-triangle class="w-4 h-4 inline mr-1"/>
                Ingredientes Faltantes ({{ count($missingIngredients) }})
            </h4>
            <div class="space-y-2">
                @foreach($missingIngredients as $missing)
                    <div class="flex justify-between text-sm bg-white rounded p-2 border border-red-200">
                        <span class="font-medium text-red-900">{{ $missing['name'] }}</span>
                        <span class="text-red-700">
                            Necesita: {{ $missing['needed'] }} {{ $missing['unit'] }} | 
                            Disponible: {{ $missing['available'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Recomendaciones --}}
    @if($status['status'] === 'low_stock')
        <div class="bg-amber-50 rounded-lg p-3 border border-amber-200">
            <p class="text-sm text-amber-800">
                <x-heroicon-o-light-bulb class="w-4 h-4 inline mr-1"/>
                <span class="font-medium">Recomendación:</span>
                Reabastecer ingredientes pronto para evitar interrupciones
            </p>
        </div>
    @elseif($status['status'] === 'out_of_stock')
        <div class="bg-red-50 rounded-lg p-3 border border-red-200">
            <p class="text-sm text-red-800">
                <x-heroicon-o-exclamation-circle class="w-4 h-4 inline mr-1"/>
                <span class="font-medium">Acción requerida:</span>
                Reabastecer ingredientes para habilitar el producto
            </p>
        </div>
    @endif
</div>