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
        Schema::create('ublades', function (Blueprint $table) {
            $table->id();
            $table->string('type',60)->nullable();
            $table->string('no_of_blade',12)->nullable();
            $table->string('model')->nullable();
            $table->string('model_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ublades');
    }
};
