<?php

use App\Helpers\Money;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $order = \App\Models\Order::latest()->first();
    $orderProducts = $order->orderProducts;

    foreach ($orderProducts as $orderProduct) {
        $total = 0;

        $total += $orderProduct->total_price * $orderProduct->quantity;

        foreach ($orderProduct->customizations as $customization) {
            $total += $customization->customization->extra_price;
        }

        $orderProduct->total_price = Money::format($total);
    }

    $pdf = Pdf::loadView('pdf.order-ticket', [
        'order' => $order,
        'orderProducts' => $orderProducts
    ])
        ->setPaper([0, 0, 240, 600]); // tamaño tipo ticket

    return $pdf->stream('ticket.pdf');
});
