<div class="flex items-center space-x-2">
    @if($getRecord()->employee)
        <div class="flex items-center space-x-1">
            <x-heroicon-s-briefcase class="w-4 h-4 text-green-500" />
            <span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-1 rounded-full">
                {{-- {{ Str::limit($getRecord()->employee->role->name, 8) }} --}}
                {{ $getRecord()->employee->role->name }}
            </span>
        </div>
    @else
        <div class="flex items-center space-x-1">
            <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                Indep.
            </span>
        </div>
    @endif
</div>