<?php

namespace App\Filament\Clusters\Order\Pages;

use App\Filament\Clusters\Order;
use App\Filament\Clusters\Order\Resources\OrderResource\Widgets\BaristaOriginWidget;
use App\Filament\Widgets\OrderWidget;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class BaristaView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static string $view = 'filament.clusters.order.pages.barista-view';
    protected static ?string $cluster = Order::class;
    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __("baristaview.title");
    }

    public function getTitle(): string | Htmlable
    {
        return __("baristaview.title");
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BaristaOriginWidget::make(),
            OrderWidget::make(),
            
        ];
    }

}
