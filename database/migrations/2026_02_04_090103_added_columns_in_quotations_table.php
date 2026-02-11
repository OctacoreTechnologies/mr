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
            $table->string('size_of_input_material',120)->nullable();
            $table->string('output',120)->nullable();
            $table->string('finish_mesh_size',120)->nullable();
            $table->string('blower_id',120)->nullable();
            $table->string('rotary_air_lock_valve_id',120)->nullable();
            $table->string('feeding_hooper_capacity_id',120)->nullable();
            $table->string('conveying_pipe_size',120)->nullable();
            $table->string('cutting_disk_dia',120)->nullable();
            $table->string('conveying_pipe',120)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            //
        });
    }
};
