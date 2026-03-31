<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FullUpdateQuotationRequest extends FormRequest
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
        // Assuming you have the quotation ID in the route (e.g. /quotations/{quotation})
        $quotationId = $this->route('quotation');

        return [
            'revise' => 'nullable',
            'reflect_in_pdf' => 'nullable',
            'customer_id' => 'required|exists:customers,id',
            'machine_id' => 'required|exists:machines,id',
            'model_id' => 'required',
            'application_id' => 'required|exists:applications,id',
            // 'reference_no' => 'required|unique:quotations,reference_no,' . $quotationId,  // Ignore the current record's reference_no during update
            'quantity' => 'required|numeric',
            'date' => 'nullable|date',
            // 'user_id' => 'required|exists:users,id',
            'total_price' => 'nullable|numeric',
            'total' => 'nullable',
            'discount_type' => 'required',
            'discount_amount' => 'nullable',
            'discount_percentage' => 'nullable',
            'electrical_control' => 'nullable',
            'electrical_control_2' => 'nullable',
            'ac_frequency_drive' => 'nullable',
            'ac_frequency_drive_2' => 'nullable',
            'bearing' => 'nullable',
            'bearing_2' => 'nullable',
            'pneumatic' => 'nullable',
            'pneumatic_2' => 'nullable',
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
            'make_motor_2' => 'nullable',
            'discount' => 'nullable',
            'useful_volume' => 'nullable',
            'compress_air_consumption' => 'nullable',
            'total_capacity' => 'nullable',
            'gear_box_1' => 'nullable',
            'gear_box_2' => 'nullable',
            'drive_system_1' => 'nullable',
            'drive_system_2' => 'nullable',
            'remark' => 'nullable',

            'items' => 'nullable|array',
            'items.*.name' => 'nullable|string',
            'items.*.qty' => 'nullable|numeric',
            'items.*.qty_unit' => 'nullable|string',
            'items.*.price' => 'nullable|numeric',
        ];
    }
}
