@php
    $productIngredient = $getRecord();
    $ingredient = $productIngredient->ingredient;
    $hasStock = $productIngredient->hasAvailableStock();
    $availableStock = $productIngredient->getAvailableStock();
    $maxProductQuantity = $productIngredient->getMaxProductQuantityPossible();
@endphp

<div class="space-y-2">
    {{-- Estado principal --}}
    <div class="flex items-center space-x-2">
        @if($hasStock)
            <x-filament::badge color="success" size="sm">
                Disponible
            </x-filament::badge>
        @else
            <x-filament::badge color="danger" size="sm">
                Agotado
            </x-filament::badge>
        @endif
        
        @if($ingredient && $ingredient->inventory)
            <span class="text-xs text-gray-600">
                Stock: {{ $availableStock }}
            </span>
        @else
            <span class="text-xs text-gray-600">
                Sin inventario
            </span>
        @endif
    </div>

    {{-- Detalles adicionales --}}
    @if($ingredient && $ingredient->inventory)
        <div class="text-xs text-gray-500 space-y-1">
            @if($hasStock)
                <div>
                    <span class="font-medium">Productos posibles:</span>
                    @if($maxProductQuantity > 100)
                        +100
                    @else
                        {{ $maxProductQuantity }}
                    @endif
                </div>
                
                @if($ingredient->inventory->isLowStock())
                    <div class="text-amber-600">
                        ⚠️ Stock bajo (mín: {{ $ingredient->inventory->min_stock }})
                    </div>
                @endif
            @else
                <div class="text-red-600">
                    ❌ Insuficiente para preparar
                </div>
            @endif
        </div>
    @endif
</div>