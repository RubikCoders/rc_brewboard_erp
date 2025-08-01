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

    public static function getNavigationBadge(): ?string
    {        
        return '';
    }
}