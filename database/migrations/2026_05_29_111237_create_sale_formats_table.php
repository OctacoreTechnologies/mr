<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_formats', function (Blueprint $table) {
            $table->id();

            // Customer se link
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');

            // ── Contact person (customer ke fields se copy) ──
            $table->string('cp_name')->nullable();
            $table->string('cp_designation')->nullable();
            $table->string('cp_contact')->nullable();
            $table->string('cp_email')->nullable();

            // ── Sale details ──
            $table->date('sale_date');
            $table->string('application')->nullable();
            $table->string('model')->nullable();
            $table->string('output')->nullable();
            $table->text('remark')->nullable();

            // ── Sign-off ──
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();

            // ── Status ──
            $table->enum('status', ['draft', 'approved', 'rejected'])->default('draft');

            $table->timestamps();
            $table->softDeletes();
        });

        // Requirements — separate table (one-to-many)
        Schema::create('sale_format_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_format_id')
                  ->constrained('sale_formats')
                  ->onDelete('cascade');
            $table->string('requirement_description');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_format_requirements');
        Schema::dropIfExists('sale_formats');
    }
};
