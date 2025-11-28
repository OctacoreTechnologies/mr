<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'required|min:10',
            'company' => 'nullable|string|max:255',
            'lead_source' => 'nullable|in:web,referral,cold_call,social_media,other',
            'status' => 'required|in:new,contacted,qualified,disqualified',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string|max:1000',
            'followed_by' => 'required|exists:users,id',
            'remark2' => 'nullable',

        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'First Name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already taken.',
            'status.required' => 'Lead status is required.',
            'status.in' => 'Invalid status selected.',
            'user_id.required' => 'Please Select A User',
        ];
    }
}
