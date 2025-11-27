<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_acceptance_letters', function (Blueprint $table) {
            $table->id();
            $table->string('machine_id',60)->nullable();
            $table->string('model_id',24)->nullable();
            $table->string('material_to_process',24)->nullable();
            $table->string('batch_capacity',72)->nullable();
            $table->string('motor',72)->nullable();
            $table->string('motor_make',72)->nullable();
            $table->string('discharge_operated',72)->nullable();
            $table->string('top_dish_cylinder_operation',72)->nullable();
            $table->string('cylinder_make',72)->nullable();
            $table->string('top_dish_opening_type',72)->nullable();
            $table->string('blade_tier',72)->nullable();
            $table->string('mixing_container',72)->nullable();
            $table->string('deflector',72)->nullable();
            $table->string('top_dish_thickness',72)->nullable();
            $table->string('ms_shell_thickness',72)->nullable();
            $table->string('ms_bottom_dish_thickness',72)->nullable();
            $table->string('ss_shell_thickness',72)->nullable();
            $table->string('ss_bottom_dish_thickness',72)->nullable();
            $table->string('nos_of_opening_in_mixer_lid',72)->nullable();
            $table->string('pulley_type',72)->nullable();
            $table->string('pulley_make',72)->nullable();
            $table->string('top_bearing_make',72)->nullable();
            $table->string('bottom_bearing_make',72)->nullable();
            $table->string('tool_speed_selection',72)->nullable();
            $table->string('safety_switch',72)->nullable();
            $table->string('platform_railing_ladder',72)->nullable();
            $table->string('electrical_panel',72)->nullable();
            $table->string('remote_for_electrical_panel',72)->nullable();
            $table->string('ac_frequency_drive_make',72)->nullable();
            $table->string('ac_frequency_drive_model',72)->nullable();
            $table->string('gasket_type',72)->nullable();
            $table->string('discharge_cover',72)->nullable();
            $table->string('elevation_stand',72)->nullable();
            $table->string('pnuematic_operations',72)->nullable();
            $table->string('paint',72)->nullable();
            $table->string('layout_drawing',72)->nullable();
            $table->string('work_order_no_for_name_plate',72)->nullable();
            $table->string('model_no',72)->nullable();
            $table->string('year',72)->nullable();
            $table->string('delivery_date',72)->nullable();

            $table->string('blade',72)->nullable();
            $table->string('gear_box',72)->nullable();
            $table->string('coupling',72)->nullable();
            $table->string('coupling_make',72)->nullable();
            $table->string('dishcharge_valve_hieght_from_ground',72)->nullable();

            $table->string('cooling_ring',72)->nullable();
            $table->string('butter_fly_make',72)->nullable();
            $table->string('ms_side_plate_thickness',72)->nullable();
            $table->string('ss_side_plate_thickness',72)->nullable();
            $table->string('side_bearing_make',72)->nullable();
            
            $table->string('blade_nos',72)->nullable();

            $table->string('rotating_balde',72)->nullable();
            $table->string('fix_blade',72)->nullable();
            $table->string('vessel_type',72)->nullable( );
            $table->string('motor_rpm',72)->nullable();
            $table->string('motor_provided_by',72)->nullable();
            $table->string('panel_type',72)->nullable();
            $table->string('panel_swtich_gear_make',72)->nullable();
            $table->string('remote_box',72)->nullable();
            $table->string('limit_switch',72)->nullable();
            $table->string('ms_shell_top_thickness',72)->nullable();
            $table->string('ms_shell_bottom_thickness',72)->nullable();
            $table->string('ss_shell_top_thickness',72)->nullable();
            $table->string('ss_shell_bottom_thickness',72)->nullable();
            $table->string('ss_top_thickness',72)->nullable();

            $table->string('panel_kw/hp',72)->nullable();
            $table->string('mesh_hole_dia',72)->nullable();
            $table->string('hopper_type',72)->nullable();
            $table->string('hopper_opneing_type',72)->nullable();
            $table->string('collecting_container',72)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_acceptance_letters');
    }
};
