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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('code')->nullable();
            $table->string('name',120)->nullable();
            $table->string('model_id',12)->nullable();
            $table->string('material_to_process_id',12)->nullable();
            $table->string('batch_capacity',12)->nullable();
            $table->string('mixing_tool',12)->nullable();
            $table->string('motor_requirement',12)->nullable();
            $table->decimal('price',12,2)->nullable();
            $table->softDeletes();
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
};
