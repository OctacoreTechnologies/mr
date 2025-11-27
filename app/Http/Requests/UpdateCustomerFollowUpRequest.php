<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCustomerFollowUpRequest extends FormRequest
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
            'id'=>'nullable|exists:customers,id',
            'follow_up_id'=>'nullable|array',
            'follow_up_id.*'=>'nullable',
            'follow_up_date'=>'required|array',
            'follow_up_date.*'=>'required|date',
            'notes'=>'required|array',
            'notes.*'=>'required',
            'next_follow_up_date'=>'nullable|array',
            'next_follow_up_date.*'=>'nullable',
        ];
    }
}
