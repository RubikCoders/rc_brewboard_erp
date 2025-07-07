<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderReview extends FormRequest
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
            'order_id' => 'required',
            'rating' => 'required|min:0|max:10',
            'comment' => 'nullable'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array{customer_name.max: string, customer_name.required: string, customer_name.string: string, employee_id.exists: string, from.max: string, from.required: string, from.string: string, payment_method.max: string, payment_method.required: string, payment_method.string: string, status.integer: string, status.required: string, tax.integer: string, tax.required: string, total.integer: string, total.required: string}
     */
    public function messages(): array
    {
        return [
            'order_id.required' => __('api/orderreview.validation.order_id.required'),
            'rating.required' => __('api/orderreview.validation.rating.required'),
            'rating.min' => __('api/orderreview.validation.rating.min'),
            'rating.max' => __('api/orderreview.validation.rating.max'),
        ];
    }
}
