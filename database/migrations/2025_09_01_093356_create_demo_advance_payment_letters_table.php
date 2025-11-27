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
        Schema::create('demo_advance_payment_letters', function (Blueprint $table) {
            $table->id();
            $table->string('machine_id',24)->nullable();
            $table->string('model_id',24)->nullable();
            $table->string('material_to_process',24)->nullable();
            $table->boolean('batch_capacity')->default(false);
            $table->boolean('motor')->default(false);
            $table->boolean('motor_make')->default(false);
            $table->boolean('discharge_operated')->default(false);
            $table->boolean('top_dish_cylinder_operation',)->default(false);
            $table->boolean('cylinder_make')->default(false);
            $table->boolean('top_dish_opening_type')->default(false);
            $table->boolean('blade_tier')->default(false);
            $table->boolean('mixing_container')->default(false);
            $table->boolean('deflector')->default(false);
            $table->boolean('top_dish_thickness')->default(false);
            $table->boolean('ms_shell_thickness')->default(false);
            $table->boolean('ms_bottom_dish_thickness')->default(false);
            $table->boolean('ss_shell_thickness')->default(false);
            $table->boolean('ss_bottom_dish_thickness')->default(false);
            $table->boolean('nos_of_opening_in_mixer_lid')->default(false);
            $table->boolean('pulley_type')->default(false);
            $table->boolean('pulley_make')->default(false);
            $table->boolean('top_bearing_make')->default(false);
            $table->boolean('bottom_bearing_make')->default(false);
            $table->boolean('tool_speed_selection')->default(false);
            $table->boolean('safety_switch')->default(false);
            $table->boolean('platform_railing_ladder')->default(false);
            $table->boolean('electrical_panel')->default(false);
            $table->boolean('remote_for_electrical_panel')->default(false);
            $table->boolean('ac_frequency_drive_make')->default(false);
            $table->boolean('ac_frequency_drive_model')->default(false);
            $table->boolean('gasket_type')->default(false);
            $table->boolean('discharge_cover')->default(false);
            $table->boolean('elevation_stand')->default(false);
            $table->boolean('pnuematic_operations')->default(false);
            $table->boolean('paint')->default(false);
            $table->boolean('layout_drawing')->default(false);
            $table->boolean('work_order_no_for_name_plate')->default(false);
            $table->boolean('model_no')->default(false);
            $table->boolean('year')->default(false);
            $table->boolean('delivery_date')->default(false);
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_advance_payment_letters');
    }
};
