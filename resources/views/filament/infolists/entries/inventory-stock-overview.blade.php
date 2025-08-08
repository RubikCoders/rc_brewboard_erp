@php
    $record = $getRecord();
    $status = $record->getStockStatus();
    $percentage = $record->getStockPercentage();
    $alertInfo = $record->getAlertInfo();
    $recommendedRestock = $record->getRecommendedRestock();
@endphp

<div class="space-y-6">
    {{-- Información principal de stock --}}
    <div class="grid grid-cols-3 gap-6">
        {{-- Stock actual --}}
        <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="text-2xl font-bold text-blue-900">{{ $record->stock }}</div>
            <div class="text-sm text-blue-700">Stock Actual</div>
        </div>
        
        {{-- Stock mínimo --}}
        <div class="text-center p-4 bg-amber-500 rounded-lg border border-amber-500">
            <div class="text-2xl font-bold text-amber-900">{{ $record->min_stock }}</div>
            <div class="text-sm text-amber-700">Stock Mínimo</div>
        </div>
        
        {{-- Stock máximo --}}
        <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
            <div class="text-2xl font-bold text-green-900">{{ $record->max_stock }}</div>
            <div class="text-sm text-green-700">Stock Máximo</div>
        </div>
    </div>

    {{-- Barra de progreso visual --}}
    <div class="space-y-2">
        <div class="flex justify-between text-sm">
            <span class="font-medium">Nivel de Stock</span>
            <span class="text-gray-600">{{ round($percentage, 1) }}%</span>
        </div>
        
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div 
                class="h-3 rounded-full transition-all duration-300 {{ match($status) {
                    'out_of_stock' => 'bg-red-500',
                    'critical' => 'bg-red-500',
                    'low' => 'bg-amber-500',
                    'excess' => 'bg-blue-500',
                    'normal' => 'bg-green-500',
                    default => 'bg-gray-400'
                } }}"
                style="width: {{ min(100, max(0, $percentage)) }}%"
            ></div>
        </div>
        
        {{-- Marcadores de referencia --}}
        <div class="relative">
            {{-- Marcador de mínimo --}}
            @if($record->max_stock > 0)
                <div 
                    class="absolute top-0 w-0.5 h-2 bg-amber-500"
                    style="left: {{ ($record->min_stock / $record->max_stock) * 100 }}%"
                ></div>
            @endif
        </div>
    </div>

    {{-- Estado y alertas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Estado actual --}}
        <div class="space-y-3">
            <h4 class="font-medium text-gray-900">Estado Actual</h4>
            
            <x-filament::badge 
                :color="match($status) {
                    'out_of_stock' => 'danger',
                    'critical' => 'danger',
                    'low' => 'warning', 
                    'excess' => 'info',
                    'normal' => 'success',
                    default => 'gray'
                }"
                size="lg"
            >
                {{ $alertInfo['status_message'] }}
            </x-filament::badge>

            @if($record->needsUrgentRestock())
                <div class="flex items-center space-x-2 text-red-600">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                    <span class="font-medium">Reabastecimiento urgente requerido</span>
                </div>
            @endif
        </div>

        {{-- Recomendaciones --}}
        <div class="space-y-3">
            <h4 class="font-medium text-gray-900">Recomendaciones</h4>
            
            @if($recommendedRestock > 0)
                <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                    <div class="flex items-center space-x-2">
                        <x-heroicon-o-arrow-up class="w-4 h-4 text-blue-600" />
                        <span class="text-sm font-medium text-blue-900">
                            Reabastecer: {{ $recommendedRestock }} unidades
                        </span>
                    </div>
                    <p class="text-xs text-blue-700 mt-1">
                        Para alcanzar el nivel máximo óptimo
                    </p>
                </div>
            @elseif($status === 'excess')
                <div class="bg-amber-50 rounded-lg p-3 border border-amber-200">
                    <div class="flex items-center space-x-2">
                        <x-heroicon-o-arrow-down class="w-4 h-4 text-amber-600" />
                        <span class="text-sm font-medium text-amber-900">
                            Stock excesivo detectado
                        </span>
                    </div>
                    <p class="text-xs text-amber-700 mt-1">
                        Considerar usar antes que se deteriore
                    </p>
                </div>
            @elseif($status === 'normal')
                <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                    <div class="flex items-center space-x-2">
                        <x-heroicon-o-check-circle class="w-4 h-4 text-green-600" />
                        <span class="text-sm font-medium text-green-900">
                            Nivel óptimo de stock
                        </span>
                    </div>
                    <p class="text-xs text-green-700 mt-1">
                        No se requieren acciones inmediatas
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- Estadísticas adicionales --}}
    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
        <h4 class="font-medium text-gray-900 mb-3">Estadísticas</h4>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Unidades disponibles:</span>
                <span class="font-medium text-gray-900">{{ $record->stock }}</span>
            </div>
            
            <div>
                <span class="text-gray-600">Capacidad utilizada:</span>
                <span class="font-medium text-gray-900">{{ round($percentage, 1) }}%</span>
            </div>
            
            <div>
                <span class="text-gray-600">Rango objetivo:</span>
                <span class="font-medium text-gray-900">{{ $record->min_stock }}-{{ $record->max_stock }}</span>
            </div>
            
            <div>
                <span class="text-gray-600">Última actualización:</span>
                <span class="font-medium text-gray-900">{{ $record->updated_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>