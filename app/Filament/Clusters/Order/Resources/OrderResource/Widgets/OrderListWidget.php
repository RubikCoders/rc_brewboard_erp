<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Widgets;

use App\Filament\Clusters\Order\Pages\BaristaView;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order as ModelsOrder;
use App\Filament\Clusters\Order\Resources\OrderResource\Pages\ListOrders;

class OrderListWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Órdenes por Procesar', ModelsOrder::where('status', ModelsOrder::STATUS_WAITING)->count())
                ->description('Por atender')
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary')
                ->url(BaristaView::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_WAITING)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-4xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Órdenes Entregadas', ModelsOrder::where('status', ModelsOrder::STATUS_FINISHED)->count())
                ->description('Completadas')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_FINISHED)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-4xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Órdenes Canceladas', ModelsOrder::where('status', ModelsOrder::STATUS_CANCELLED)->count())
                ->description('Canceladas')
                ->descriptionIcon('heroicon-o-archive-box-x-mark')
                ->color('danger')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_CANCELLED)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-4xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),
        ];
    }
}
