<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Api\OrderReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ticket-order/{order}', [OrderController::class, 'viewOrderTicket'])->name('order.ticket');

Route::middleware(['web', \App\Http\Middleware\LandingPageMiddleware::class])->group(function () {
    Route::get('/', [LandingController::class, 'home'])->name('landing.home');
    Route::get('/contacto', [LandingController::class, 'contact'])->name('landing.contact');
});

Route::get('/private-image/{path}', function ($path) {
    abort_unless(Auth::check(), 403); // o tu lógica de permisos

    $file = Storage::disk('private_reviews')->get($path);
    return response($file)->header('Content-Type', 'image/jpeg');
})->where('path', '.*')->name('private.image');

Route::get('/private-image/{path}', function ($path) {
    abort_unless(Auth::check(), 403); // o tu lógica de permisos

    $file = Storage::disk('private_reviews')->get($path);
    return response($file)->header('Content-Type', 'image/jpeg');
})->where('path', '.*')->name('private.image');

//Route::get('/test', function () {
//    $order = \App\Models\Order::latest()->first();
//    $orderProducts = $order->orderProducts;
//
//    foreach ($orderProducts as $orderProduct) {
//        $total = 0;
//
//        $total += $orderProduct->total_price * $orderProduct->quantity;
//
//        foreach ($orderProduct->customizations as $customization) {
//            $total += $customization->customization->extra_price;
//        }
//
//        $orderProduct->total_price = Money::format($total);
//    }
//
//    $pdf = Pdf::loadView('pdf.order-ticket', [
//        'order' => $order,
//        'orderProducts' => $orderProducts
//    ])
//        ->setPaper([0, 0, 240, 600]); // tamaño tipo ticket
//
//    return $pdf->stream('ticket.pdf');
//});
