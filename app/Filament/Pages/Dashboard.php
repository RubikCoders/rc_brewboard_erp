<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OriginOrders;
use App\Filament\Widgets\SalesTotals;
use App\Filament\Widgets\StatusOrders;
use App\Filament\Widgets\PopularItems;


class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            StatusOrders::make(),
            OriginOrders::make(),
            SalesTotals::make(),
            PopularItems::make(),
        ];
    }
}
