<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCustomization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCustomizationController extends Controller
{
    /**
     * Get all product customizations by product
     * @param int $productId Product ID
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function indexByProduct($productId): JsonResponse
    {
        $productCustomizations = ProductCustomization::with('options')
            ->where("product_id", $productId)
            ->orderBy("created_at", "desc")
            ->get();

        return response()->json($productCustomizations)->setStatusCode(200);
    }

    /**
     * Get a specific customization for a product
     * @param int $productId Product ID
     * @param int $categoryId Category ID
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function showCategoryByProduct($productId, $categoryId): JsonResponse
    {
        $productCustomization = ProductCustomization::where("product_id", $productId)
            ->where("id", $categoryId)
            ->orderBy("created_at", "desc")
            ->first();

        return response()->json($productCustomization)->setStatusCode(200);
    }
}
