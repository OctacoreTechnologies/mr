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
        Schema::create('modele_preview_data', function (Blueprint $table) {
            $table->id();
            $table->string('modele_id')->nullable();
            $table->string('motor_requitment_id')->nullable();
            $table->string('blade')->nullable();
            $table->strig('motor')->nullable();
            $table->string('motor_type')->nullable();
            $table->string('motor_power')->nullable();
            $table->string('motor_power_unit')->nullable();
            $table->string('motor_power_unit_type')->nullable();
            $table->string('motor_power_unit_type_value')->nullable();
            $table->string('motor_power_unit_value')->nullable();
            $table->string('motor_power_unit_value_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modele_preview_data');
    }
};
