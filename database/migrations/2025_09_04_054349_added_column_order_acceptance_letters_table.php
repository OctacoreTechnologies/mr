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
         Schema::table('order_acceptance_letters', function (Blueprint $table) {
            $table->text('remark_1')->nullable();
            $table->text('remark_2')->nullable();
            $table->text('remark_3')->nullable();
            $table->text('remark_4')->nullable();
            $table->text('remark_5')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
