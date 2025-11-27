<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateOrderAcceptancLetterRequest extends FormRequest
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
            'machine_id' => 'nullable|string|max:60',
            'model' => 'nullable|string|max:24',
            'material_to_process' => 'nullable|string|max:24',
            'batch_capacity' => 'nullable|string|max:72',
            'motor' => 'nullable|string|max:72',
            'motor_make' => 'nullable|string|max:72',
            'discharge_operated' => 'nullable|string|max:72',
            'top_dish_cylinder_operation' => 'nullable|string|max:72',
            'cylinder_make' => 'nullable|string|max:72',
            'top_dish_opening_type' => 'nullable|string|max:72',
            'blade_tier' => 'nullable|string|max:72',
            'mixing_container' => 'nullable|string|max:72',
            'deflector' => 'nullable|string|max:72',
            'top_dish_thickness' => 'nullable|string|max:72',
            'ms_shell_thickness' => 'nullable|string|max:72',
            'ms_bottom_dish_thickness' => 'nullable|string|max:72',
            'ss_shell_thickness' => 'nullable|string|max:72',
            'ss_bottom_dish_thickness' => 'nullable|string|max:72',
            'nos_of_opening_in_mixer_lid' => 'nullable|string|max:72',
            'pulley_type' => 'nullable|string|max:72',
            'pulley_make' => 'nullable|string|max:72',
            'top_bearing_make' => 'nullable|string|max:72',
            'bottom_bearing_make' => 'nullable|string|max:72',
            'tool_speed_selection' => 'nullable|string|max:72',
            'safety_switch' => 'nullable|string|max:72',
            'platform_railing_ladder' => 'nullable|string|max:72',
            'electrical_panel' => 'nullable|string|max:72',
            'remote_for_electrical_panel' => 'nullable|string|max:72',
            'ac_frequency_drive_make' => 'nullable|string|max:72',
            'ac_frequency_drive_model' => 'nullable|string|max:72',
            'gasket_type' => 'nullable|string|max:72',
            'discharge_cover' => 'nullable|string|max:72',
            'elevation_stand' => 'nullable|string|max:72',
            'pnuematic_operations' => 'nullable|string|max:72',
            'paint' => 'nullable|string|max:72',
            'layout_drawing' => 'nullable|string|max:72',
            'work_order_no_for_name_plate' => 'nullable|string|max:72',
            'model_no' => 'nullable|string|max:72',
            'year' => 'nullable|string|max:72',
            'delivery_date' => 'nullable|string|max:72',
            'blade' => 'nullable|string|max:72',
            'gear_box' => 'nullable|string|max:72',
            'coupling' => 'nullable|string|max:72',
            'coupling_make' => 'nullable|string|max:72',
            'dishcharge_valve_hieght_from_ground' => 'nullable|string|max:72',
            'cooling_ring' => 'nullable|string|max:72',
            'butter_fly_make' => 'nullable|string|max:72',
            'ms_side_plate_thickness' => 'nullable|string|max:72',
            'ss_side_plate_thickness' => 'nullable|string|max:72',
            'side_bearing_make' => 'nullable|string|max:72',
            'blade_nos' => 'nullable|string|max:72',
            'rotating_balde' => 'nullable|string|max:72',
            'fix_blade' => 'nullable|string|max:72',
            'vessel_type' => 'nullable|string|max:72',
            'motor_rpm' => 'nullable|string|max:72',
            'motor_provided_by' => 'nullable|string|max:72',
            'panel_type' => 'nullable|string|max:72',
            'panel_swtich_gear_make' => 'nullable|string|max:72',
            'remote_box' => 'nullable|string|max:72',
            'limit_switch' => 'nullable|string|max:72',
            'ms_shell_top_thickness' => 'nullable|string|max:72',
            'ms_shell_bottom_thickness' => 'nullable|string|max:72',
            'ss_shell_top_thickness' => 'nullable|string|max:72',
            'ss_shell_bottom_thickness' => 'nullable|string|max:72',
            'ss_top_thickness' => 'nullable|string|max:72',
            'panel_kw/hp' => 'nullable|string|max:72',
            'mesh_hole_dia' => 'nullable|string|max:72',
            'hopper_type' => 'nullable|string|max:72',
            'hopper_opneing_type' => 'nullable|string|max:72',
            'collecting_container' => 'nullable|string|max:72',
            'remark_1' => 'nullable',
            'remark_2' => 'nullable',
            'remark_3' => 'nullable',
            'remark_4' => 'nullable',
            'remark_5' => 'nullable',
        ];
    }
}
