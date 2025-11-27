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
            $table->string('location_type')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('pincode')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('contact_person_1_name')->nullable();
            $table->string('contact_person_1_designation')->nullable();
            $table->string('contact_person_1_email')->nullable();
            $table->string('contact_person_2_name')->nullable();
            $table->string('contact_person_2_designation')->nullable();
            $table->string('contact_person_2_contact')->nullable();
            $table->string('contact_person_2_email')->nullable();
            $table->string('gst')->nullable();
            $table->string('remark')->nullable();
            $table->string('status')->nullable();
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
