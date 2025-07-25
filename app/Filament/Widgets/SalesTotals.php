<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SalesTotals extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Ventas Totales de la Cafetería';
    protected static ?string $maxHeight = '300px';
    
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Ventas de Tacos',
                    'data' => [30, 50, 40, 60, 80, 100, 120, 140, 180, 200, 250, 300],  // Datos simulados para las ventas de tacos
                    'backgroundColor' => '#677C5B',  // Color verde principal
                    'borderColor' => '#4A5D44',  // Color de borde un tono más oscuro
                ],
                [
                    'label' => 'Ventas de Café',
                    'data' => [20, 35, 25, 40, 60, 85, 100, 120, 150, 175, 200, 225],  // Datos simulados para las ventas de café
                    'backgroundColor' => '#A8C6A1',  // Un tono más claro de verde para diferenciar
                    'borderColor' => '#7F9B79',  // Borde un poco más oscuro
                ],
                [
                    'label' => 'Ventas de Pasteles',
                    'data' => [15, 25, 35, 50, 70, 90, 110, 130, 160, 180, 210, 250],  // Datos simulados para las ventas de pasteles
                    'backgroundColor' => '#4C6B3C',  // Un verde más oscuro para diferenciar
                    'borderColor' => '#35532E',  // Borde oscuro
                ],
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],  // Meses del año
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';  // Tipo de gráfico en dona
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'week' => 'Semana',
            'month' => 'Mes',
            'year' => 'Año',
        ];
    }
}
