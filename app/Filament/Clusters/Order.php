<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Order extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?int $navigationSort = 2;


    public static function getNavigationLabel(): string
    {
        return __("order.model");
    }

    public static function getClusterBreadcrumb(): string
    {
        return __("order.order");
    }
}
