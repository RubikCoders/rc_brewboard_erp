<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersRadar extends ChartWidget
{
    protected static ?string $heading = 'Distribución de ordenes';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        return [
            'labels' => ["Entregadas", "Pendientes", "Canceladas"],
            'datasets' => [
                [
                    'label' => "Ordenes",
                    'data' => [
                        Order::where('status', Order::STATUS_FINISHED)->count(),
                        Order::where('status', Order::STATUS_WAITING)->count(),
                        Order::where('status', Order::STATUS_CANCELLED)->count(),
                    ],
                    "backgroundColor" => [
                        'rgba(75, 192, 143, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    "borderColor" => [
                        'rgb(75, 192, 128)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)',
                    ],
                    'pointBackgroundColor' => '#698a5f',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => '#698a5f',
                    'fill' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

}
