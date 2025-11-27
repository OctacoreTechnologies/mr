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
        Schema::table('sale_ledgers', function (Blueprint $table) {
            $table->foreignId('sale_order_id')->constrained('sale_orders')->onDelete('cascade');
            $table->date('payment_date')->nullable();
            $table->string('amount',60)->nullable();
            $table->string('mode',48)->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('remarks')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_ledgers', function (Blueprint $table) {
            //
        });
    }
};
