<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrdersPerMonth extends ChartWidget
{
    protected static ?string $heading = 'Ordenes por mes';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        Carbon::setLocale('es');

        $months = Order::totalOrdersByMonth();

        $labels = array_map(function ($month) {
            return ucfirst(Carbon::createFromFormat('Y-m', $month)->translatedFormat('M'));
        }, array_keys($months));

        return [
            'datasets' => [
                [
                    'label' => 'Órdenes por mes',
                    'data' => array_values($months),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

}
