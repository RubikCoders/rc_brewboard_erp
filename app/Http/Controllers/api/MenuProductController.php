<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MenuProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuProductController extends Controller
{
    /**
     * Get all products
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function index(): JsonResponse
    {
        $products = MenuProduct::orderBy("created_at", "desc")->where("is_available", true)->paginate(10);
        return response()->json($products)->setStatusCode(200);
    }

    /**
     * Get products by category
     * @param int $categoryId Category ID
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function indexByCategory($categoryId): JsonResponse
    {
        $products = MenuProduct::where("category_id", $categoryId)->orderBy("created_at", "desc")->paginate(10);
        return response()->json(
            $products
        )->setStatusCode(200);
    }

    /**
     * Get a product by id
     * @param int $id Product ID
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function show($id): JsonResponse
    {
        $product = MenuProduct::find($id);
        return response()->json(
            $product
        )->setStatusCode(200);
    }
}
