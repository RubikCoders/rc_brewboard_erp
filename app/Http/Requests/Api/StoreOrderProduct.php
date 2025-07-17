<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:menu_products,id',
            'quantity' => 'required|integer|min:1',
            'is_delivered' => 'nullable|boolean',
            'total_price' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:1000',
            'kitchen_status' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => __('api/order_product.validation.order_id.required'),
            'order_id.exists' => __('api/order_product.validation.order_id.exists'),

            'product_id.required' => __('api/order_product.validation.product_id.required'),
            'product_id.exists' => __('api/order_product.validation.product_id.exists'),

            'quantity.required' => __('api/order_product.validation.quantity.required'),
            'quantity.integer' => __('api/order_product.validation.quantity.integer'),
            'quantity.min' => __('api/order_product.validation.quantity.min'),

            'is_delivered.boolean' => __('api/order_product.validation.is_delivered.boolean'),

            'total_price.required' => __('api/order_product.validation.total_price.required'),
            'total_price.integer' => __('api/order_product.validation.total_price.integer'),
            'total_price.min' => __('api/order_product.validation.total_price.min'),

            'notes.string' => __('api/order_product.validation.notes.string'),
            'notes.max' => __('api/order_product.validation.notes.max'),

            'kitchen_status.required' => __('api/order_product.validation.kitchen_status.required'),
            'kitchen_status.integer' => __('api/order_product.validation.kitchen_status.integer'),
        ];
    }
}
