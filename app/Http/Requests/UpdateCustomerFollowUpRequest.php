<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerFollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quotation_id'              => ['nullable', 'string', 'max:24'],
            'follow_up_id'              => ['required', 'array'],
            'follow_up_id.*'            => ['nullable'],
            'follow_up_date'            => ['required', 'array'],
            'follow_up_date.*'          => ['required', 'string'],
            'next_follow_up_date'       => ['required', 'array'],
            'next_follow_up_date.*'     => ['required', 'string'],
            'notes'                     => ['required', 'array'],
            'notes.*'                   => ['required', 'string', 'max:2000'],

            // Documents
            'documents'                 => ['nullable', 'array'],
            'documents.*'               => ['nullable', 'array'],
            'documents.*.*'             => [
                'file',
                'max:20480', // 20 MB per file
                'mimes:pdf,xls,xlsx,csv,doc,docx,jpg,jpeg,png,gif,webp,svg,zip,rar',
            ],

            // IDs of documents marked for deletion
            'delete_document_ids'       => ['nullable', 'array'],
            'delete_document_ids.*'     => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'follow_up_date.*.required'      => 'Follow-up date is required for each entry.',
            'next_follow_up_date.*.required' => 'Next follow-up date is required for each entry.',
            'notes.*.required'               => 'Notes are required for each entry.',
            'documents.*.*.mimes'            => 'Allowed file types: PDF, Excel, Word, Images, ZIP.',
            'documents.*.*.max'              => 'Each file must be under 20 MB.',
        ];
    }
}