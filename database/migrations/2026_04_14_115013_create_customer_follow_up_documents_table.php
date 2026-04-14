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
        Schema::create('customer_follow_up_documents', function (Blueprint $table) {
            $table->id();
            $table->string('follow_up_id')->nullable();
            $table->string('original_name')->nullable();          // Original file name shown to user
            $table->string('file_path')->nullable();              // Storage path
            $table->string('file_type', 10);          // pdf, xlsx, jpg, png, etc.
            $table->unsignedBigInteger('file_size')->nullable();  // Size in bytes
            $table->string('uploaded_by')->nullable(); // user id or name
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_follow_up_documents');
    }
};
