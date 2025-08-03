<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MenuCategoryController;
use App\Http\Controllers\Api\MenuProductController;
use App\Http\Controllers\Api\ProductCustomizationController;
use App\Http\Controllers\Api\CustomizationOptionController;
use App\Http\Controllers\Api\OrderCustomizationController;
use App\Http\Controllers\Api\OrderProductController;
use App\Http\Controllers\Api\OrderReviewController;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, "login"])->name("login");

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

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
        Route::get("/customization/{customization}", [CustomizationOptionController::class, "indexByCustomization"]);
        Route::get("/customization/{customization}/option/{option}", [CustomizationOptionController::class, "showByCustomizationAndOption"]);
    });

    // Orders
    Route::group(["prefix" => "order"], function () {
        Route::post("/", [OrderController::class, "store"]);
        Route::get("/{order}", [OrderController::class, "show"]);
    });

    // Order product
    Route::group(["prefix" => "order-product"], function () {
        Route::post("/", [OrderProductController::class, "store"]);
    });

    // Order product customization
    Route::group(["prefix" => "order-customization"], function () {
        Route::post("/", [OrderCustomizationController::class, "store"]);
    });

    // Order Review
    Route::group(["prefix" => "order-review"], function () {
        Route::post("/", [OrderReviewController::class, "store"]);
    });
});
