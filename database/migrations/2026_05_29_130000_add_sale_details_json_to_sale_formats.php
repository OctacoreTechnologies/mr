<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sale_formats', function (Blueprint $table) {
            $table->json('sale_details')->nullable()->after('sale_date');
            $table->dropColumn(['application', 'model', 'output']);
        });
    }

    public function down(): void
    {
        Schema::table('sale_formats', function (Blueprint $table) {
            $table->string('application')->nullable();
            $table->string('model')->nullable();
            $table->string('output')->nullable();
            $table->dropColumn('sale_details');
        });
    }
};
