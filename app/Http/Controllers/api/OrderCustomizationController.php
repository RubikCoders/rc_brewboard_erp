<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderCustomization;
use App\Models\OrderCustomization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderCustomizationController extends Controller
{
    public function store(StoreOrderCustomization $request): JsonResponse
    {
        $validated = $request->validated();
        $orderCustomization = OrderCustomization::create($validated);

        return response()->json($orderCustomization)->setStatusCode(201);
    }
}
