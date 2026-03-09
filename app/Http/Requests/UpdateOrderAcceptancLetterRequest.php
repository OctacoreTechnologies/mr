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
            'model' => 'nullable|string',
            'material_to_process' => 'nullable|string',
            'batch_capacity' => 'nullable|string',
            'motor' => 'nullable|string',
            'motor_make' => 'nullable|string',
            'discharge_operated' => 'nullable|string',
            'top_dish_cylinder_operation' => 'nullable|string',
            'cylinder_make' => 'nullable|string',
            'top_dish_opening_type' => 'nullable|string',
            'blade_tier' => 'nullable|string',
            'mixing_container' => 'nullable|string',
            'deflector' => 'nullable|string',
            'top_dish_thickness' => 'nullable|string',
            'ms_shell_thickness' => 'nullable|string',
            'ms_bottom_dish_thickness' => 'nullable|string',
            'ss_shell_thickness' => 'nullable|string',
            'ss_bottom_dish_thickness' => 'nullable|string',
            'nos_of_opening_in_mixer_lid' => 'nullable|string',
            'pulley_type' => 'nullable|string',
            'pulley_make' => 'nullable|string',
            'top_bearing_make' => 'nullable|string',
            'bottom_bearing_make' => 'nullable|string',
            'tool_speed_selection' => 'nullable|string',
            'safety_switch' => 'nullable|string',
            'platform_railing_ladder' => 'nullable|string',
            'electrical_panel' => 'nullable|string',
            'remote_for_electrical_panel' => 'nullable|string',
            'ac_frequency_drive_make' => 'nullable|string',
            'ac_frequency_drive_model' => 'nullable|string',
            'gasket_type' => 'nullable|string',
            'discharge_cover' => 'nullable|string',
            'elevation_stand' => 'nullable|string',
            'pnuematic_operations' => 'nullable|string',
            'paint' => 'nullable|string',
            'layout_drawing' => 'nullable|string',
            'work_order_no_for_name_plate' => 'nullable|string',
            'model_no' => 'nullable|string',
            'year' => 'nullable|string',
            'delivery_date' => 'nullable|string',
            'blade' => 'nullable|string',
            'gear_box' => 'nullable|string',
            'coupling' => 'nullable|string',
            'coupling_make' => 'nullable|string',
            'dishcharge_valve_hieght_from_ground' => 'nullable|string',
            'cooling_ring' => 'nullable|string',
            'butter_fly_make' => 'nullable|string',
            'ms_side_plate_thickness' => 'nullable|string',
            'ss_side_plate_thickness' => 'nullable|string',
            'side_bearing_make' => 'nullable|string',
            'blade_nos' => 'nullable|string',
            'rotating_balde' => 'nullable|string',
            'fix_blade' => 'nullable|string',
            'vessel_type' => 'nullable|string',
            'motor_rpm' => 'nullable|string',
            'motor_provided_by' => 'nullable|string',
            'panel_type' => 'nullable|string',
            'panel_swtich_gear_make' => 'nullable|string',
            'remote_box' => 'nullable|string',
            'limit_switch' => 'nullable|string',
            'ms_shell_top_thickness' => 'nullable|string',
            'ms_shell_bottom_thickness' => 'nullable|string',
            'ss_shell_top_thickness' => 'nullable|string',
            'ss_shell_bottom_thickness' => 'nullable|string',
            'ss_top_thickness' => 'nullable|string',
            'panel_kw/hp' => 'nullable|string',
            'mesh_hole_dia' => 'nullable|string',
            'hopper_type' => 'nullable|string',
            'hopper_opneing_type' => 'nullable|string',
            'collecting_container' => 'nullable|string',
            'remark_1' => 'nullable',
            'remark_2' => 'nullable',
            'remark_3' => 'nullable',
            'remark_4' => 'nullable',
            'remark_5' => 'nullable',
        ];
    }
}
