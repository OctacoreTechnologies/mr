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
              $table->string('water_pressure',120)->nullable();
              $table->string('operating_pressure',120)->nullable();
              $table->string('cooling_water_inlet_temperature',120)->nullable();
              $table->string('cooling_water_flow_rate',120)->nullable();
              $table->string('feeding_air_pressure',120)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
};
