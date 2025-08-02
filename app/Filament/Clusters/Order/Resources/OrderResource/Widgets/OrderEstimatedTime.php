<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Widgets;

use App\Filament\Clusters\Order\Pages\BaristaView;
use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class OrderEstimatedTime extends Widget
{
    public $widgetData;
    public Order $order;
    protected static string $view = 'filament.clusters.order.resources.order-resource.widgets.order-estimated-time';

    public function mount(): void
    {
        $this->widgetData = [
            'order' => $this->order
        ];
    }

    public function getViewData(): array
    {
        $order = $this->widgetData['order'];

        $order->estimated_time = Order::calculateEstimatedTime($order);

        return [
            'order' => $order,
        ];
    }

}
