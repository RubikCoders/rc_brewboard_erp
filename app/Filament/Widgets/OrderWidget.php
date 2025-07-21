<?php

namespace App\Filament\Widgets;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Models\Order;
use Filament\Widgets\Widget;

class OrderWidget extends Widget
{
    protected static string $view = 'filament.widgets.order-widget';
    protected int|string|array $columnSpan = 'full';


    public function getViewData(): array
    {
        $orders = Order::where('status', Order::STATUS_WAITING)->latest()->take(9)->get();

        foreach ($orders as $order) {
            $order['estimated_time'] = Order::calculateEstimatedTime($order);
        }

        return [
            'orders' => $orders,
        ];
    }

    //region Livewire methods

    public function changeStatus(Order $order, int $status)
    {
        Order::find($order->id)->update(['status' => $status]);
    }

    public function goToOrder($id)
    {
        return redirect(OrderResource::getUrl('view', ['record' => $id]));
    }

    //endregion
}
