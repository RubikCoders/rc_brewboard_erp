<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($this->getCards() as $card)
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div class="text-lg font-medium text-gray-800">{{ $card->getTitle() }}</div>
                <div class="text-3xl font-bold text-gray-600">{{ $card->getValue() }}</div>
            </div>
            <div class="mt-2 text-sm text-gray-500">{{ $card->getDescription() }}</div>
        </div>
    @endforeach
</div>
