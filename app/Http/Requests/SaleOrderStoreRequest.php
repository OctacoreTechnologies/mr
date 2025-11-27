<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SaleOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check()?true:false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quotation_id' => 'required|exists:quotations,id',
            'order_date' => 'nullable|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status' => 'nullable|in:pending,processing,shipped,delivered,canceled',
            'payment_status' => 'nullable|in:paid,unpaid,half paid',
            'total_amount' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'grand_total' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string|max:1000',
            'followed_by'=>'required|exists:users,id',
            'payment_term'=>'required|numeric',

            // Payments array validation
            'payments' => 'nullable|array',
            'payments.*.date' => 'nullable|date',
            'payments.*.amount' => 'nullable|numeric|min:0.01',
            'payments.*.mode' => 'nullable|in:cash,online,other',
            'payments.*.transaction_id' => 'nullable|string|required_if:payments.*.mode,online|max:255',
            'payments.*.remarks' => 'nullable|string|required_if:payments.*.mode,other|max:1000',
        ];
    }

    public function messages(){
        return [
            'quotation_id.required' => 'Quotation is required.',
            'quotation_id.exists' => 'Selected quotation does not exist.',
            'order_date.required' => 'Order date is required.',
            'delivery_date.after_or_equal' => 'Delivery date cannot be before order date.',
            'payments.required' => 'At least one payment entry is required.',
            'payments.*.amount.min' => 'Payment amount must be at least 0.01.',
            'payments.*.transaction_id.required_if' => 'Transaction ID is required for online payments.',
            'payments.*.remarks.required_if' => 'Remarks are required for other payment modes.',
        ];
    }
}
