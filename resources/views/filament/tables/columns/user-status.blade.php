<div class="flex items-center justify-center">
    @if($getRecord()->user_id)
        <div class="flex items-center space-x-1">
            <x-heroicon-s-check-circle class="w-4 h-4 text-green-500" />
            <span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-1 rounded-full">
                Activo
            </span>
        </div>
    @else
        <div class="flex items-center space-x-1">
            <x-heroicon-o-x-circle class="w-4 h-4 text-red-500" />
            <span class="text-xs text-red-700 bg-red-100 px-2 py-1 rounded-full">
                Sin usuario
            </span>
        </div>
    @endif
</div>