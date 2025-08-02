<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Pages;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Filament\Clusters\Order\Resources\OrderResource\Widgets\OrderListWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;


class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderListWidget::make(),
        ];
    }
}
