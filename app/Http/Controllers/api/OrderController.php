<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\StoreOrderRequest  $request
     * @return JsonResponse
     * @author Angel Mendoza
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $order = Order::create($validated);

        return response()->json($order)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return JsonResponse
     * @author Angel Mendoza
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json($order)->setStatusCode(200);
    }
}
