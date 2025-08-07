<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Pages;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Filament\Clusters\Order\Resources\OrderResource\Widgets\OrderListWidget;
use App\Models\MenuProduct;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;


class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            OrderListWidget::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__("order.tabs.all"))
                ->icon('heroicon-o-squares-2x2')
                ->badge(Order::count()),

            'pending' => Tab::make(__("order.tabs.pending"))
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', Order::STATUS_WAITING))
                ->badge(Order::where('status', Order::STATUS_WAITING)->count())
                ->badgeColor('info'),

            'ready' => Tab::make(__("order.tabs.ready"))
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', Order::STATUS_FINISHED))
                ->badge(Order::where('status', Order::STATUS_FINISHED)->count())
                ->badgeColor('success'),

            'cancelled' => Tab::make(__("order.tabs.cancelled"))
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', Order::STATUS_CANCELLED))
                ->badge(Order::where('status', Order::STATUS_CANCELLED)->count())
                ->badgeColor('danger'),
        ];
    }
}
