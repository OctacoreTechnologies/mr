<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreQuotationRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'machine_id' => 'required|exists:machines,id',
            'model_id' => 'required',
            'application_id' => 'required|exists:applications,id',
            'reference_no' => 'required|unique:quotations',
            'quantity' => 'required|numeric',
            'date' => 'nullable|date',
            // 'user_id'=>'required|exists:users,id',
            'total_price' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'electrical_control' => 'nullable',
            'ac_frequency_drive' => 'nullable',
            'bearing' => 'nullable',
            'pneumatic' => 'nullable',
            'material_to_process' => 'nullable',
            'batch' => 'nullable',
            'batch2' => 'nullable',
            'mixing_tool' => 'nullable',
            'motor_requirement' => 'nullable',
            'motor_requirement2' => 'nullable',
            'water_pressure' => 'nullable',
            'operating_pressure' => 'nullable',
            'cooling_water_inlet_temperature' => 'nullable',
            'cooling_water_flow_rate' => 'nullable',
            'feeding_air_pressure' => 'nullable',
            'contact_part' => 'nullable',
            'no_of_rotating_blades' => 'nullable',
            'no_of_fixes_blades' => 'nullable',
            'capacity' => 'nullable',
            'make_motor' => 'nullable',
            'discount' => 'nullable',
            'useful_volume' => 'nullable',
            'compress_air_consumption' => 'nullable',
            'total_capacity' => 'nullable',
            'size_of_input_material' => 'nullable',
            'output' => 'nullable',
            'finish_mesh_size' => 'nullable',
            'blower' => 'nullable',
            'rotary_air_lock_valve' => 'nullable',
            'feeding_hooper_capacity' => 'nullable',
            'tank' => 'nullable',
            'rotor' => 'nullable',
            'material' => 'nullable',

            'remark' => 'nullable',
            'followed_by' => 'required|exists:users,id',
            'conveying_pipe' => 'nullable',

            'items' => 'nullable|array',
            'items.*.name' => 'nullable|string',
            'items.*.qty' => 'nullable|numeric',
            'items.*.qty_unit' => 'nullable|string',
            'items.*.price' => 'nullable|numeric',

        ];
    }
}
