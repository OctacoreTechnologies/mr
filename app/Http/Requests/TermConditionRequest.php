<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TermConditionRequest extends FormRequest
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
            'price' => 'nullable|string',
            'tax' => 'nullable|string',
            'delivery' => 'nullable|string',
            'payment' => 'nullable|string',
            'packing' => 'nullable|string',
            'forwarding' => 'nullable|string',
            'validity' => 'nullable|string',
            'commissioning_charges' => 'nullable|string',
            'guarantee' => 'nullable|string',
            'cancellation_of_order' => 'nullable|string',
            'judiciary' => 'nullable|string',
            'not_in_our_scope_of_supply' => 'nullable|string',
        ];
    }
}
