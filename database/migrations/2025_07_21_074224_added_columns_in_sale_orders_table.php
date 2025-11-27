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
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade')->onUpdate('cascade');
            $table->date('order_date'); 
            $table->date('delivery_date')->nullable(); 
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'canceled'])->default('pending');
            $table->decimal('total_amount', 12, 2); 
            $table->decimal('discount', 12, 2)->nullable(); 
            $table->decimal('tax', 12, 2)->nullable();
            $table->decimal('grand_total', 12, 2); 
            $table->string('payment_status')->default('unpaid');
            $table->text('remarks')->nullable(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            //
        });
    }
};
