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
            $table->string('motor_requirement2_id',12)->nullable();
            $table->string('batch2_id',12)->nullable();
            $table->string('total_capacity',50)->nullable();
            $table->string('useful_volume',50)->nullable();
            $table->string('compress_air_consumption',50)->nullable();
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
