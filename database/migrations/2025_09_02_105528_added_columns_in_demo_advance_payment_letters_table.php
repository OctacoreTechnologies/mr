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
              $table->boolean('blade')->default(false);
              $table->boolean('gear_box')->default(false);
              $table->boolean('coupling')->default(false);
              $table->boolean('coupling_make')->default(false);
              $table->boolean('dishcharge_valve_hieght_from_ground')->default(false);
           
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
