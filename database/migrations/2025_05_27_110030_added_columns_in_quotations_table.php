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
        Schema::table('quotations', function (Blueprint $table) {
            // $table->string('material_to_process_id',12)->nullable();
            // $table->string('batch_id',12)->nullable();
            // $table->string('mixing_tool_id',12)->nullable();
            // $table->string('motor_requirement_id',12)->nullable();
            // $table->string('electrical_control_id',12)->nullable();
            // $table->string('ac_frequency_drive_id',12)->nullable();
            // $table->string('bearing',12)->nullable();
            // $table->string('pneuamtics',12)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('material_to_process_id',12);
            $table->dropColumn('batch_id',12);
            $table->dropColumn('mixing_tool_id',12);
            $table->dropColumn('motor_requirement_id',12);
            $table->dropColumn('electrical_control_id',12);
            $table->dropColumn('ac_frequency_drive_id',12);
            $table->dropColumn('bearing',12);
            $table->dropColumn('pneuamtics',12);
        });
    }
};
