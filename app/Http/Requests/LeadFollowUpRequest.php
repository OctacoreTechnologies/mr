<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LeadFollowUpRequest extends FormRequest
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
            // 'lead_id'=>'required|exists:leads,id',
            'follow_up_id'=>'nullable|array',
            'follow_up_id.*'=>'nullable',
            'followup_date'=>'required|array',
            'followup_date.*'=>'required|date',
            'notes'=>'required|array',
            'notes,*'=>'required',
            'next_followup_data_time'=>'required|array',
            'next_followup_data_time.*'=>'required|date',
        ];
    }
}
