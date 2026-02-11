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
        Schema::create('rotary_air_lock_valves', function (Blueprint $table) {
            $table->id();
            $table->string('model_id',120)->nullable();
            $table->string('rotary_air_lock_valve',120)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotary_air_lock_valves');
    }
};
