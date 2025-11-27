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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->text('remarks')->nullable();
            $table->text('tentative_dispatch_date')->nullable();
            $table->text('payment_term_days')->nullable();
            $table->text('customer_po_number')->nullable();
            $table->text('whatsapp_number')->nullable();
            $table->text('employee_id')->nullable();
            $table->text('status')->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
