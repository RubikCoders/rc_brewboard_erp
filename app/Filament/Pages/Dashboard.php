<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OriginOrders;
use App\Filament\Widgets\StatusOrders;
use App\Filament\Widgets\PopularItems;
use App\Filament\Widgets\Revenue;
use App\Filament\Widgets\OrdersPerMonth;
use App\Filament\Widgets\OrdersRadar;
use App\Filament\Widgets\ReviewsChart;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            Revenue::make(),
            OrdersPerMonth::make(),
            OrdersRadar::make(),
            OriginOrders::make(),
            PopularItems::make(),
            ReviewsChart::make()
        ];
    }
}
