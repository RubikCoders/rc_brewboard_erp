<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class OrderEllapsedTime extends Widget
{
    public $widgetData;
    public Order $order;
    protected static string $view = 'filament.clusters.order.resources.order-resource.widgets.order-ellapsed-time';

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

        $created = Carbon::parse($order->created_at);
        $now = Carbon::now();
        $minutes = $created->diffInMinutes($now);
        $order->time_ago = $created->diffForHumans();

        if ($minutes < $order->estimated_time * 0.75) {
            $order->elapsed_status = 'success';
        } elseif ($minutes < $order->estimated_time) {
            $order->elapsed_status = 'warning';
        } else {
            $order->elapsed_status = 'danger';
        }

        return [
            'order' => $order,
        ];
    }
}
