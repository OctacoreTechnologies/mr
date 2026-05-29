<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleFormatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'    => 'required|exists:customers,id',
            'cp_name'        => 'nullable|string|max:255',
            'cp_designation' => 'nullable|string|max:255',
            'cp_contact'     => 'nullable|string|max:50',
            'cp_email'       => 'nullable|email|max:255',
            'sale_date'      => 'required|date',
            'sale_details'                => 'nullable|array',
            'sale_details.*.application'  => 'nullable|string|max:255',
            'sale_details.*.model'        => 'nullable|string|max:255',
            'sale_details.*.output'       => 'nullable|string|max:255',
            'remark'         => 'nullable|string',
            'prepared_by'    => 'nullable|string|max:255',
            'approved_by'    => 'nullable|string|max:255',
            'status'         => 'required|in:draft,approved,rejected',
            'requirements'   => 'nullable|array',
            'requirements.*' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Customer select karna zaroori hai.',
            'customer_id.exists'   => 'Selected customer exist nahi karta.',
            'sale_date.required'   => 'Sale date required hai.',
        ];
    }
}
