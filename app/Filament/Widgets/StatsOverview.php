<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    //protected ?string $pollingInterval = "30s";

    protected function getStats(): array
    {
        //Ordenes pendientes logica


        return [
            // Primera línea: Órdenes pendientes, en preparación y entregadas
            Stat::make('Órdenes Pendientes', '120'  ) // Valor simulado
                ->description('Órdenes pendientes por procesar')
                ->descriptionIcon('heroicon-o-clock') 
                ->color('secondary'),
            Stat::make('Órdenes en Preparación', '45') // Valor simulado
                ->description('Órdenes en proceso')
                ->descriptionIcon('heroicon-o-cog') // Icono Heroicon
                ->color('warning'),
            Stat::make('Órdenes Entregadas', '300') // Valor simulado
                ->description('Órdenes entregadas')
                ->descriptionIcon('heroicon-o-check') // Icono Heroicon
                ->color('success'),

              
        ];
    }
}
