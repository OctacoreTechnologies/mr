<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OpportunityRequest extends FormRequest
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
            'lead_id' => 'required|exists:leads,id', // Make sure the lead_id exists in the leads table
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0', // Ensure that value is numeric and non-negative
            'stage' => 'required', // Status must be one of the listed options
            'close_date' => 'nullable|date|after_or_equal:today', // Ensure close_date is today or in the future
            // 'sales_stage' => 'nullable|in:prospecting,negotiation,closing', // Optional, but should be one of the listed stages
            'probability' => 'nullable|numeric|min:0|max:100', // Optional, between 0 and 100
            'account_name' => 'nullable|string|max:255',
            'expected_close_date'=>'nullable|date',
            // 'assigned_to' => 'nullable|exists:users,id', // Ensure the user exists if assigned
            'priority' => 'nullable|in:low,medium,high', // Optional priority field
            'notes' => 'nullable|string', // Optional field for lead description
            'remark1'=>'nullable',
            'remark2'=>'nullable',
            'type'=>'nullable',
        ];
    }
}
