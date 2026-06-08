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
            'contact_persons'                => 'nullable|array',
            'contact_persons.*.name'         => 'nullable|string|max:255',
            'contact_persons.*.designation'  => 'nullable|string|max:255',
            'contact_persons.*.contact'      => 'nullable|array',
            'contact_persons.*.contact.*'    => 'nullable|string|max:255',
            'contact_persons.*.email'        => 'nullable|array',
            'contact_persons.*.email.*'      => 'nullable|email|max:255',
            'sale_date'      => 'required|date',
            'sale_details'                => 'nullable|array',
            'sale_details.*.application'  => 'nullable|string|max:255',
            'sale_details.*.model'        => 'nullable|string|max:255',
            'sale_details.*.output'       => 'nullable|string|max:255',
            'remark'         => 'nullable|string',
            'prepared_by'    => 'nullable|string|max:255',
            'approved_by'    => 'nullable|string|max:255',
            'person_documents'       => 'nullable|array',
            'person_documents.*'     => 'nullable|array',
            'person_documents.*.*'   => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'person_existing_docs'   => 'nullable|array',
            'person_existing_docs.*' => 'nullable|array',
            'person_existing_docs.*.*' => 'nullable|string',
            'remark_documents'     => 'nullable|array',
            'remark_documents.*'   => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,pdf|max:5120',
            'remark_existing_docs'   => 'nullable|array',
            'remark_existing_docs.*' => 'nullable|string',
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
