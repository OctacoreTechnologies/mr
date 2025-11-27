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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->text('location_type');
            $table->text('country')->nullable();
            $table->text('region')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->text('area')->nullable();
            $table->text('pincode')->nullable();
            $table->text('company_name')->nullable();
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->text('contact_person_1_name')->nullable();
            $table->text('contact_person_1_designation')->nullable();
            $table->text('contact_person_1_contact')->nullable();
            $table->text('contact_person_1_email')->nullable();
            $table->text('contact_person_2_name')->nullable();
            $table->text('contact_person_2_designation')->nullable();
            $table->text('contact_person_2_contact')->nullable();
            $table->text('contact_person_2_email')->nullable();
            $table->text('gst')->nullable();
            $table->text('remarks')->nullable();
            $table->text('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
