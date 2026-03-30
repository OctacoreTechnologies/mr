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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('electrical_control_2_id',12)->nullable()->after('electrical_control_id');
            $table->string('ac_frequency_drive_2_id',12)->nullable()->after('ac_frequency_drive_id');
            $table->string('bearing_2_id',12)->nullable()->after('bearing_id');
            $table->string('pneumatic_2_id',12)->nullable()->after('pneumatic_id');
            $table->string('make_motor_2_id',12)->nullable()->after('make_motor_id');
            $table->string('gear_box_1',120)->nullable()->after('make_motor_2_id');
            $table->string('gear_box_2',120)->nullable()->after('gear_box_1');
            $table->string('drive_system_1',120)->nullable()->after('gear_box_2');
            $table->string('drive_system_2',120)->nullable()->after('drive_system_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('electrical_control_2_id');
            $table->dropColumn('ac_frequency_drive_2_id');
            $table->dropColumn('bearing_2_id');
            $table->dropColumn('pneumatic_2_id');
            $table->dropColumn('make_motor_2_id');
            $table->dropColumn('gear_box_1');
            $table->dropColumn('gear_box_2');
            $table->dropColumn('drive_system_1');
            $table->dropColumn('drive_system_2');   
        });
    }
};
