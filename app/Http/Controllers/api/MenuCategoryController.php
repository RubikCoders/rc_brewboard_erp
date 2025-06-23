<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MenuCategoryController extends Controller
{
    /**
     * Get all categories
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function index(): JsonResponse
    {
        $categories = MenuCategory::orderBy("created_at", "desc")->paginate(10);
        return response()->json($categories)->setStatusCode(200);
    }


    /**
     * Get a category by id
     * @param int $id Category ID
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function show($id): JsonResponse
    {
        $category = MenuCategory::find($id);
        return response()->json(
            $category
        )->setStatusCode(200);
    }
}
