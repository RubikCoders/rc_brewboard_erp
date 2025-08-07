<?php

namespace App\Filament\Widgets;

use App\Filament\Clusters\Order;
use App\Models\Order as ModelsOrder;
use App\Filament\Clusters\Order\Pages\BaristaView;
use App\Filament\Clusters\Order\Resources\OrderResource\Pages\ListOrders;
use App\Helpers\Money;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Revenue extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $monthColor = ModelsOrder::isCurrentMonthRevenueGreaterThanLastMonth();
        $weekColor = ModelsOrder::isThisWeekRevenueGreaterThanLastWeek();
        $dayColor = ModelsOrder::isTodayRevenueGreaterThanYesterday();

        return [
            Stat::make('Ventas Totales', Money::format(ModelsOrder::calculateTotalRevenue()))
                ->description('Acumulado desde el inicio.')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart(ModelsOrder::totalRevenueChartByMonth())
                ->color('primary'),

            Stat::make('Ventas del Mes', Money::format(ModelsOrder::calculateLastMonthRevenue()))
                ->description('Ingresos acumulados del mes.')
                ->descriptionIcon($monthColor ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart(ModelsOrder::monthRevenueChartByMonth())
                ->color($monthColor ? "primary" : "danger"),

            Stat::make('Ventas de la Semana', Money::format(ModelsOrder::calculateTotalRevenueThisWeek()))
                ->description('Total vendido esta semana.')
                ->descriptionIcon($weekColor ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart(ModelsOrder::totalRevenueChartByWeek())
                ->color($weekColor ? "primary" : "danger"),

            Stat::make('Ventas del Día', Money::format(ModelsOrder::calculateTotalRevenueToday()))
                ->description('Ingresos generados hoy.')
                ->descriptionIcon($dayColor ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart(ModelsOrder::totalRevenueChartByDay())
                ->color($dayColor ? "primary" : "danger"),
        ];
    }

}
