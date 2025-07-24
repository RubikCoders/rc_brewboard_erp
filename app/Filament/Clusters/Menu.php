<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Pages\SubNavigationPosition;
use app\Models\MenuProduct;

class Menu extends Cluster
{
    protected static ?string $navigationIcon = 'icon-products';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?int $navigationSort = 1;

    protected static ?string $clusterBreadcrumb = 'Menú';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getNavigationBadge(): ?string
    {
        return (string) MenuProduct::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return MenuProduct::count() > 0 ? 'success' : 'gray';
    }
}