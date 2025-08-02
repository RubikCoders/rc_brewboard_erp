<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Widgets;

use App\Filament\Clusters\Order\Pages\BaristaView;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Filament\Clusters\Order\Resources\OrderResource\Pages\ListOrders;
use Carbon\Carbon;

class BaristaOriginWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            
            Stat::make('Órdenes Kiosko', Order::where('from', Order::FROM_CSP)
                ->where('status', Order::STATUS_WAITING)
                ->count())
                ->description('Por cliente')
                ->descriptionIcon('heroicon-o-device-phone-mobile')
                ->color('secondary')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . Order::STATUS_WAITING)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Órdenes en Caja', Order::where('from', Order::FROM_ERP)
                ->where('status', Order::STATUS_WAITING)
                ->count())
                ->description('Por barista')
                ->descriptionIcon('heroicon-o-user')
                ->color('warning')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . Order::STATUS_WAITING)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Tiempos Excedidos', Order::where('status', Order::STATUS_WAITING)
                ->where('created_at', '<', Carbon::now()->subMinutes(20))
                ->count())
                ->description('Mayor a 20 min')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('danger')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . Order::STATUS_WAITING)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-4xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),
        ];
    }
}
