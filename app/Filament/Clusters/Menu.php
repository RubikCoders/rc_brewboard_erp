<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Pages\SubNavigationPosition;

class Menu extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?string $navigationLabel = 'Menú';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {        
        return '';
    }

    public static function getClusterBreadcrumb(): string
    {
        return 'Gestión del Menú';
    }
}