<?php

namespace App\Filament\Widgets;

use App\Models\Order as ModelsOrder;
use App\Filament\Clusters\Order\Pages\BaristaView;
use App\Filament\Clusters\Order\Resources\OrderResource\Pages\ListOrders;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusOrders extends BaseWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'INFORMACIÓN DE LAS ÓRDENES DEL DÍA';
    protected ?string $description = 'Visualiza las órdenes pendientes, entregadas y canceladas del día de hoy';

    protected function getStats(): array
    {
        return [
            Stat::make('Órdenes Pendientes', ModelsOrder::where('status', ModelsOrder::STATUS_WAITING)->count())
                ->description('ÓRDENES POR PROCESAR')
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary')
                ->url(BaristaView::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_WAITING)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-4xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Órdenes Entregadas', ModelsOrder::where('status', ModelsOrder::STATUS_FINISHED)->count())
                ->description('ÓRDENES ENTREGADAS')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_FINISHED)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-4xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            Stat::make('Órdenes Canceladas', ModelsOrder::where('status', ModelsOrder::STATUS_CANCELLED)->count())
                ->description('ÓRDENES CANCELADAS')
                ->descriptionIcon('heroicon-o-archive-box-x-mark')
                ->color('danger')
                ->url(ListOrders::getUrl() . '?tableFilters[status][value]=' . ModelsOrder::STATUS_CANCELLED)
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-4xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),
        ];
    }
}
