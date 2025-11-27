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
                $table->foreignId('client_id')->constrained('customers')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->string('reference_no');
                $table->date('date');
                // $table->string('model');
                // $table->string('product');
                // $table->string('batch_size')->nullable();
                // $table->string('mixing_tool')->nullable();
                $table->integer('quantity')->default(1);
                // $table->decimal('unit_price', 12, 2)->nullable();
                $table->decimal('total_price', 12, 2)->nullable();
                $table->text('offer_notes')->nullable();
                // $table->json('terms_and_conditions')->nullable();
                $table->enum('status', ['Draft', 'Sent', 'Accepted', 'Rejected'])->default('Draft');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('remarks')->nullable();
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
