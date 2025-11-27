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
            $table->string('code')->nullable();
            $table->string('name',120)->nullable();
            $table->string('model',120)->nullable();
            $table->string('material_to_process',120)->nullable();
            $table->string('batch_capacity',120)->nullable();
            $table->string('mixing_tool',120)->nullable();
            $table->string('motor_requirement',120)->nullable();
            $table->text('description')->nullable();
            $table->string('voltage',50)->nullable();
            $table->string('frequency',100)->nullable();
            $table->text('control_panel')->nullable();
            $table->decimal('price',12,2)->nullable();
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
