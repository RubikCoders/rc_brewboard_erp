<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderReview;
use App\Models\OrderReview;
use Faker\Core\File;

class OrderReviewController extends Controller
{

    /**
     * Store an order review from CSP (mobile)
     * @param \App\Http\Requests\Api\StoreOrderReview $request
     * @return \Illuminate\Http\JsonResponse
     * @author Angel Mendoza
     */
    public function store(StoreOrderReview $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . '_' . $image->getClientOriginalName();

            $path = $image->storeAs('', $filename, 'private_reviews');

            $validated['image_path'] = $path;

        }

        $order = OrderReview::create($validated);

        return response()->json($order)->setStatusCode(201);
    }

}
