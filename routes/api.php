<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MenuCategoryController;
use App\Http\Controllers\Api\MenuProductController;
use App\Http\Controllers\Api\ProductCustomizationController;
use App\Http\Controllers\api\ProductCustomizationOptionController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Categories
Route::group(["prefix" => "category"], function () {
    Route::get("/", [MenuCategoryController::class, "index"]);
    Route::get("/{category}", [MenuCategoryController::class, "show"]);
});

// Products
Route::group(["prefix" => "product"], function () {
    Route::get("/", [MenuProductController::class, "index"]);
    Route::get("/{product}", [MenuProductController::class, "show"]);
    Route::get("/category/{category}", [MenuProductController::class, "indexByCategory"]);
});

// Product customizations
Route::group(["prefix" => "product-customization"], function () {
    Route::get("/product/{product}", [ProductCustomizationController::class, "indexByProduct"]);
    Route::get('/product/{product}/category/{category}', [ProductCustomizationController::class, "showCategoryByProduct"]);
});

// Customization options
Route::group(["prefix" => "customization-option"], function () {
    Route::get("/customization/{customization}", [ProductCustomizationOptionController::class, "indexByCustomization"]);
    Route::get("/customization/{customization}/option/{option}", [ProductCustomizationOptionController::class, "showByCustomizationAndOption"]);
});

// Orders
Route::group(["prefix" => "order"], function () {
    Route::get("/", [OrderController::class, "index"]);
    Route::get("/{order}", [OrderController::class, "show"]);
});
