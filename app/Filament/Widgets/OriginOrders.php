<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OriginOrders extends BaseWidget
{

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            // Primera línea: Órdenes pendientes, en preparación y entregadas
            Stat::make('Órdenes Kiosko', '50'  ) // Valor simulado
                ->description('Órdenes ingresadas por clientes')
                ->descriptionIcon('heroicon-o-clock') 
                ->color('secondary'),
            Stat::make('Órdenes en Caja', '15') // Valor simulado
                ->description('Órdenes ingresadas por baristas')
                ->descriptionIcon('heroicon-o-cog') // Icono Heroicon
                ->color('warning'),
            
        ];
    }
}
