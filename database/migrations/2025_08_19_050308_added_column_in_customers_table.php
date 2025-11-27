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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('contact_person_3_name',120)->nullable();
            $table->string('contact_person_3_designation',120)->nullable();
            $table->string('contact_person_3_contact',120)->nullable();

            $table->string('contact_person_4_name',120)->nullable();
            $table->string('contact_person_4_designation',120)->nullable();
            $table->string('contact_person_4_contact',120)->nullable();

            $table->string('contact_person_5_name',120)->nullable();
            $table->string('contact_person_5_designation',120)->nullable();
            $table->string('contact_person_5_contact',120)->nullable();

            $table->string('contact_person_6_name',120)->nullable();
            $table->string('contact_person_6_designation',120)->nullable();
            $table->string('contact_person_6_contact',120)->nullable();
            
            $table->text('remark2')->nullable();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
