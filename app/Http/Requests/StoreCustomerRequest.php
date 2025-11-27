<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCustomerRequest extends FormRequest
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
            'location_type' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'contact_no'=>'nullable|string|min:9',
            'company_name'=>'nullable|string',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'contact_person_1_name' => 'nullable|string|max:255',
            'contact_person_1_designation' => 'nullable|string|max:255',
            'contact_person_1_email' => 'nullable|email|max:255',

            'contact_person_2_name' => 'nullable|string|max:255',
            'contact_person_2_designation' => 'nullable|string|max:255',
            'contact_person_2_contact' => 'nullable|string|max:255',
            'contact_person_2_email' => 'nullable|email|max:255',

            'contact_person_3_name' => 'nullable|string|max:255',
            'contact_person_3_designation' => 'nullable|string|max:255',
            'contact_person_3_contact' => 'nullable|string|max:255',
            'contact_person_3_email' => 'nullable|email|max:255',

            'contact_person_4_name' => 'nullable|string|max:255',
            'contact_person_4_designation' => 'nullable|string|max:255',
            'contact_person_4_contact' => 'nullable|string|max:255',
            'contact_person_4_email' => 'nullable|email|max:255',

            'contact_person_5_name' => 'nullable|string|max:255',
            'contact_person_5_designation' => 'nullable|string|max:255',
            'contact_person_5_contact' => 'nullable|string|max:255',
            'contact_person_5_email' => 'nullable|email|max:255',

            'contact_person_6_name' => 'nullable|string|max:255',
            'contact_person_6_designation' => 'nullable|string|max:255',
            'contact_person_6_contact' => 'nullable|string|max:255',
            'contact_person_6_email' => 'nullable|email|max:255',

            'gst' => 'nullable|string|max:255',
            'remark' => 'nullable|string|max:500',
            'status' => 'nullable|string|in:new,quoated,lead,invoice',
            'followed_by'=>'required|exists:users,id',
            'continent'=>'required',
            // 'email3' =>'nullable|email',
            // 'email4' =>'nullable|email',
            // 'email5' =>'nullable|email',
            // 'email6' =>'nullable|email',
            'remark2'=>'nullable|string',
        
        ];
    }
}
