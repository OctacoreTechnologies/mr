<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateQuotationRequest extends FormRequest
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
            'reference_no' => 'required|unique:quotations,reference_no,' . $this->route('quotation'). ',id' ,
            'quantity'=>'required|numeric',
            'date' => 'nullable|date',
            'total_price' => 'nullable|numeric',
            // 'discount'=>'nullable',
            'discount_type' =>'required',
            'discount_amount'=>'nullable',
            'discount_percentage'=>'nullable',
            'total'=>'nullable', 
            'status'=>'required',
            'revise'=>'nullable',
            'reminder_date'=>'nullable|date',
            'remark'=>'nullable',
            'followed_by' =>'required|exists:users,id',

        ];
    }
}
