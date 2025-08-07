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

Route::get('/test', function () {
    // Necessary when you want to show all records
    ini_set('memory_limit', '512M');
    set_time_limit(60);
    $allSales = false;

    $startDate = \Carbon\Carbon::parse('2025-07-01')->startOfDay();
    $endDate = \Carbon\Carbon::parse('2025-08-01')->endOfDay();

    // Consulta de órdenes finalizadas entre las fechas
    if ($allSales) {
        $orders = \App\Models\Order::all();
    } else {
        $orders = \App\Models\Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', \App\Models\Order::STATUS_FINISHED)
            ->get();
    }

    // Información de generación
    $generatedAt = \App\Helpers\Formatter::dateTime(\Carbon\Carbon::now());
    $generatedBy = Auth::user()?->name ?? 'Sistema';

    // Rango de fechas mostrado
    $dateRange = $allSales
        ? 'Todas las ventas'
        : \App\Helpers\Formatter::date($startDate) . ' hasta ' . \App\Helpers\Formatter::date($endDate);

    // Datos para el reporte
    $total = \App\Helpers\Money::format($orders->sum('total'));
    $averageTicket = \App\Helpers\Money::format($orders->avg('total'));

    // set correct from value
    foreach ($orders as $order) {
        $order->from = match ($order->from) {
            "erp" => __("order.erp"),
            "csp" => __("order.csp"),
        };

        $order->total = \App\Helpers\Money::format($order->total);
        $order->tax = \App\Helpers\Money::format($order->tax);
    }

    // Generar el PDF
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.sales-report', [
        'generatedAt' => $generatedAt,
        'dateRange' => $dateRange,
        'generatedBy' => $generatedBy,
        'orders' => $orders,
        'total' => $total,
        'averageTicket' => $averageTicket,
    ]);

    return $pdf->stream('sales-report.pdf');
});
