<?php

namespace App\Filament\Widgets;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Models\Order;
use App\Filament\Clusters\Order\Resources\OrderResource\Pages\ListOrders;
use App\Models\Order as ModelsOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OriginOrders extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Órdenes totales', Order::all()->count())
                ->description('Órdenes registradas')
                ->descriptionIcon('heroicon-o-pencil')
                ->color('primary')
                ->url(OrderResource::getUrl("index"))
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Órdenes Kiosko', Order::where('from', Order::FROM_CSP)->count())
                ->description('Órdenes ingresadas por clientes')
                ->descriptionIcon('heroicon-o-device-phone-mobile')
                ->color('secondary')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_FINISHED)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Órdenes en Caja', Order::where('from', Order::FROM_ERP)->count())
                ->description('Órdenes ingresadas por baristas')
                ->descriptionIcon('heroicon-o-user')
                ->color('primary')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_FINISHED)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),


        ];
    }
}
