<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'employee_id' => 'nullable|exists:employees,id',
            'customer_name' => 'required|string|max:255',
            'total' => 'required|integer',
            'payment_method' => 'required|string|max:255',
            'from' => 'required|string|max:255',
            'status' => 'required|integer'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array{customer_name.max: string, customer_name.required: string, customer_name.string: string, employee_id.exists: string, from.max: string, from.required: string, from.string: string, payment_method.max: string, payment_method.required: string, payment_method.string: string, status.integer: string, status.required: string, tax.integer: string, tax.required: string, total.integer: string, total.required: string}
     */
    public function messages(): array
    {
        return [
            'employee_id.exists' => __("api/order.validation.employee_id.exists"),

            'customer_name.required' => __("api/order.validation.customer_name.required"),
            'customer_name.string' => __("api/order.validation.customer_name.string"),
            'customer_name.max' => __("api/order.validation.customer_name.max"),

            'total.required' => __("api/order.validation.total.required"),
            'total.integer' => __("api/order.validation.total.integer"),

            'payment_method.required' => __("api/order.validation.payment_method.required"),
            'payment_method.string' => __("api/order.validation.payment_method.string"),
            'payment_method.max' => __("api/order.validation.payment_method.max"),

            'from.required' => __("api/order.validation.from.required"),
            'from.string' => __("api/order.validation.from.string"),
            'from.max' => __("api/order.validation.from.max"),

            'status.required' => __("api/order.validation.status.required"),
            'status.integer' => __("api/order.validation.status.integer"),
        ];
    }
}
