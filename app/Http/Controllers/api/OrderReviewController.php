<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderReview;
use App\Models\OrderReview;

class OrderReviewController extends Controller
{

    /**
     * Store an order review from CSP (mobile)
     * @param \App\Http\Requests\Api\StoreOrderReview $request
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function store(StoreOrderReview $request){
        $validated = $request->validated();
        $order = OrderReview::create($validated);

        return response()->json($order)->setStatusCode(201);
    }

}
