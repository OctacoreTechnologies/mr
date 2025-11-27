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
        Schema::table('demo_advance_payment_letters', function (Blueprint $table) {
            //    $table->boolean('dishcharge_operated_type')->default(false);
            //    $table->boolean('discharge_cylineder_make')->default(false);
            //    $table->boolean('ms_side_plate_thickness')->default(false);
               $table->boolean('rotating_balde')->default(false);
               $table->boolean('fix_blade')->default(false);
               $table->boolean('vessel_type')->default( false);
               $table->boolean('motor_rpm')->default(false);
               $table->boolean('motor_provided_by')->default(false);
               $table->boolean('panel_type')->default(false);
               $table->boolean('panel_swtich_gear_make')->default(false);
               $table->boolean('remote_box')->default(false);
               $table->boolean('limit_switch')->default(false);
               $table->boolean('ms_shell_top_thickness')->default(false);
               $table->boolean('ms_shell_bottom_thickness')->default(false);
               $table->boolean('ss_shell_top_thickness')->default(false);
               $table->boolean('ss_shell_bottom_thickness')->default(false);
               $table->boolean('ss_top_thickness')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_advance_payment_letters', function (Blueprint $table) {
            //
        });
    }
};
