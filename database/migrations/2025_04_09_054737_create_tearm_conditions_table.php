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
        Schema::create('tearm_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('type',120)->nullable();
            $table->text('price')->nullable();
            $table->text('tax')->nullable();
            $table->text('delivery')->nullable();
            $table->text('payment')->nullable();
            $table->text('packing')->nullable();
            $table->text('forwarding')->nullable();
            $table->text('validity')->nullable();
            $table->text('commissioning_charges')->nullable();
            $table->text('guarantee')->nullable();
            $table->text('cancellation_of_order')->nullable();
            $table->text('judiciary')->nullable();
            $table->text('not_in_our_scope_of_supply')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tearm_conditions');
    }
};
