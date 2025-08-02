<?php

namespace App\Filament\Widgets;

use App\Filament\Clusters\Order\Pages\BaristaView;
use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class OrderWidget extends Widget
{
    protected static string $view = 'filament.widgets.order-widget';
    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $orders = Order::where('status', Order::STATUS_WAITING)->latest()->take(9)->get();

        foreach ($orders as $order) {
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
        }

        return [
            'orders' => $orders,
        ];
    }

    //region Livewire methods

    public function changeStatus(Order $order, int $status)
    {
        Order::find($order->id)->update(['status' => $status]);
        return redirect(BaristaView::getUrl());

    }

    public function goToOrder($id)
    {
        return redirect(OrderResource::getUrl('view', ['record' => $id]));
    }

    //endregion
}
