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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('stage', ['qualification', 'proposal', 'negotiation', 'closed_won', 'closed_lost']);
            $table->date('expected_close_date')->nullable();
            $table->integer('probability')->default(0);  // In percentage
            $table->date('close_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('owner')->nullable(); // Sales rep
            $table->enum('opportunity_type', ['new_business', 'upsell', 'cross_sell', 'renewal'])->default('new_business');
            $table->string('campaign')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
