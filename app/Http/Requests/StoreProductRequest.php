<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
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
            // 'code'=>'required|unique:products,code',
            'name'=>'required|string',
            'description'=>'nullable',
            'price'=>'required|numeric',
            // 'image_url'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            // 'model'=>'required|string',
            'material_to_process'=>'required|string',
            // 'batch_capacity'=>'nullable|string',
            'motor_requirement'=>'required|string',
            'voltage'=>'nullable',
            'frequency'=>'nullable',
            'control_panel'=>'nullable',
        ];
    }
}
