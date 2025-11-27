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
              $table->boolean('panel_kw/hp')->default(false);
              $table->boolean('mesh_hole_dia')->default(false);
              $table->boolean('hopper_type')->default(false);
              $table->boolean('hopper_opneing_type')->default(false);
              $table->boolean('collecting_container')->default(false);
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
