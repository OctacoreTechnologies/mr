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
        Schema::table('customer_follow_ups', function (Blueprint $table) {
            $table->string('followed_by',24)->after('customer_id')->nullable()->comment('Followed by user name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_follow_ups', function (Blueprint $table) {
            //
        });
    }
};
