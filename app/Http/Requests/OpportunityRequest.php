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
            // 'lead_id' => 'required|exists:leads,id', 
            // 'name' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'nullable|numeric|min:0', 
            'description' => 'nullable|string',
            'stage' => 'required', 
            'close_date' => 'nullable|date|after_or_equal:today',
            // 'sales_stage' => 'nullable|in:prospecting,negotiation,closing', 
            // 'probability' => 'nullable|numeric|min:0|max:100', 
            'account_name' => 'nullable|string|max:255',
            'expected_close_date'=>'nullable|date',
            // 'assigned_to' => 'nullable|exists:users,id', 
            'priority' => 'nullable|in:low,medium,high',
            'notes' => 'nullable|string', 
            'remark1'=>'nullable',
            'remark2'=>'nullable',
            'type'=>'required|in:new_enquiry,upsell,cross_sell,renewal',
        ];
    }
}
