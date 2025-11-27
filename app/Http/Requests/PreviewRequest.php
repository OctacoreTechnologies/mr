<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PreviewRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'machine_id'=>'required|exists:machines,id',
            'model_id'=>'required|exists:modeles,id',
            'application_id' => 'required|exists:applications,id',
            'reference_no' => 'required|unique:quotations',
            'quantity'=>'required|numeric',
            'date' => 'nullable|date',
            'user_id'=>'required|exists:users,id',
            'total_price' => 'nullable|numeric',
            'discount'=>'nullable|numeric',
        ];
    }
}
