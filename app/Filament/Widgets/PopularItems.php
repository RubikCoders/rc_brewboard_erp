<?php

namespace App\Filament\Widgets;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PopularItems extends ChartWidget
{
    protected static ?string $heading = 'Productos más populares';
    protected static ?int $sort = 4;
    public ?string $filter = 'hot_drinks'; // Valor por defecto

    protected function getFilters(): ?array
    {
        return [
            'hot_drinks' => 'Bebidas Calientes',
            'cold_drinks' => 'Bebidas Frías',
            'food' => 'Alimentos',
        ];
    }

    protected function getData(): array
    {
        $category = match ($this->filter) {
            'cold_drinks' => 'bebidas frías',
            'food' => 'alimentos',
            default => 'bebidas calientes',
        };

        $sevenDaysAgo = Carbon::now()->subDays(7);

        $topProducts = OrderProduct::with('product.category')
            ->whereHas('product.category', fn ($query) => $query->where('name', $category))
            ->whereHas('order', fn ($query) => $query->where('created_at', '>=', $sevenDaysAgo))
            ->selectRaw('product_id, SUM(quantity) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->mapWithKeys(fn ($op) => [$op->product->name => $op->total])
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Más vendidos',
                    'data' => array_values($topProducts),
                    'backgroundColor' => [
                        '#E4E6C3', // Hover
                        '#677C5B', // Primary
                        '#EFE9DB', // Secondary 01
                        '#AFA288', // Secondary 02
                        '#988B71', // Secondary 03
                    ],
                ],
            ],
            'labels' => array_keys($topProducts),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
