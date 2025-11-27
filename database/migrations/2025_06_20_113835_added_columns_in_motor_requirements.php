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
        Schema::table('motot_requirements', function (Blueprint $table) {
            // $table->string('modele_id')->nullable();
            // $table->string('machine_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motor_requirements', function (Blueprint $table) {
            $table->dropColumn('modele_id');
            $table->dropColumn('machine_id');
        });
    }
};
