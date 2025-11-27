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
               $table->boolean('ms_side_plate_thickness')->default(false);
               $table->boolean('ss_side_plate_thickness')->default(false);
               $table->boolean('side_bearing_make')->default(false);
               $table->boolean('blade_nos')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_advance_payment_letters', function (Blueprint $table) {
             
            
        });
    }
};
