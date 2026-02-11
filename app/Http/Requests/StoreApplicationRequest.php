<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreApplicationRequest extends FormRequest
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
         'name'=>'required|string',
         'model_id'=>'nullable',
         'material_to_process'=>'nullable',
         'batch'=>'nullable',
         'batch2'=>'nullable',
         'mixing_tool'=>'nullable',
         'motor_requirement'=>'nullable',
         'motor_requirement2'=>'nullable',
         'electrical_control'=>'nullable',
         'ac_frequency_drive'=>'nullable',
         'bearing'=>'nullable',
         'pneumatic'=>'nullable',
         'price'=>'nullable',
         'machine'=>'nullable',
         'water_pressure'=>'nullable',
         'operating_pressure'=>'nullable',
         'cooling_water_inlet_temperature'=>'nullable',
         'cooling_water_flow_rate'=>'nullable',
         'feeding_air_pressure'=>'nullable',
         'contact_part'=>'nullable',
         'no_of_rotating_blade'=>'nullable',
         'no_of_fixes_blade'=>'nullable',
         'capacity'=>'nullable',
         'make_motor'=>'nullable',
         'is_two_application'=>'nullable',
         'useful_volume'=>'nullable',
         'compress_air_consumption'=>'nullable',
         'total_capacity'=>'nullable',
         'size_of_input_material'=>'nullable',
         'output'=>'nullable',
         'finish_mesh_size'=>'nullable',
         'blower'=>'nullable',
         'rotary_air_lock_valve'=>'nullable',
         'feeding_hooper_capacity'=>'nullable',
         'conveying_pipe' => 'nullable',
         'rotor'=>'nullable',
         'material'=>'nullable',
         'tank' => 'nullable',

        ];
    }
}
