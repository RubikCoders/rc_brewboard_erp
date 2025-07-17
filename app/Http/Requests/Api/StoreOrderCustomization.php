<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderCustomization extends FormRequest
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
            'order_product_id' => 'required|exists:order_products,id',
            'product_customization_id' => 'required|exists:customizations_options,id',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'order_product_id.required' => __('api/order_customization.validation.order_product_id.required'),
            'order_product_id.exists' => __('api/order_customization.validation.order_product_id.exists'),

            'product_customization_id.required' => __('api/order_customization.validation.product_customization_id.required'),
            'product_customization_id.exists' => __('api/order_customization.validation.product_customization_id.exists'),
        ];
    }

}
