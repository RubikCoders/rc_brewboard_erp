<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderProduct;
use App\Models\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function store(StoreOrderProduct $request): JsonResponse
    {
        $validated = $request->validated();
        $orderProduct = OrderProduct::create($validated);

        return response()->json($orderProduct)->setStatusCode(201);
    }
}
