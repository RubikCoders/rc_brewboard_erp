<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesTotals extends ChartWidget
{
    protected static ?string $heading = 'Ventas Totales';
    protected static ?int $sort = 3;
    public ?string $filter = 'today';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'month' => 'Mes',
            'year' => 'Año',
        ];
    }

    protected function getData(): array
    {
        $from = match ($this->filter) {
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfDay(),
        };

        $ventas = Order::where('created_at', '>=', $from)
            ->where('status', Order::STATUS_FINISHED)
            ->selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get()
            ->mapWithKeys(fn ($row) => [Carbon::parse($row->fecha)->format('d M') => $row->total])
            ->toArray();

        $colores = [
            '#677C5B', // Primary

        ];

        return [
            'datasets' => [
                [
                    'label' => 'Ventas en $',
                    'data' => array_values($ventas),
                    'backgroundColor' => array_slice($colores, 0, count($ventas)),
                    'borderColor' => '#2F3036', // Off
                    'borderWidth' => 1,
                ],
            ],
            'labels' => array_keys($ventas) ?: ['Sin datos'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    
}
