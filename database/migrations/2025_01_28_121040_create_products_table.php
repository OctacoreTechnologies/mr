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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->integer('min_stock_qty')->default(0);
            $table->string('product_type')->nullable()->default('test');
            $table->string('gst')->nullable();
            $table->string('hsn_code')->nullable();
            $table->foreignId('category_id');
            $table->string('status')->default('active');
            $table->foreignId('supplier_id')->nullable();
            $table->float('sales_price',24,2)->default(0);
            $table->float('purchase_price',24,2)->default(0);
            $table->float('opening_stock',24,2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
