<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderCustomization;
use App\Models\OrderCustomization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderCustomizationController extends Controller
{

    /**
     * Store an order product customization
     * @param \App\Http\Requests\Api\StoreOrderCustomization $request
     * @return JsonResponse
     */
    public function store(StoreOrderCustomization $request): JsonResponse
    {
        $validated = $request->validated();
        $orderCustomization = OrderCustomization::create($validated);

        return response()->json($orderCustomization)->setStatusCode(201);
    }
}
