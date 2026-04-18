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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('messages')->nullable();
            $table->enum('channel', ['system', 'email', 'whatsapp'])->default('system');
            $table->dateTime('send_at')->nullable();

            $table->json('meta')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['title','messages','channel','send_at','meta','status']);
        });
    }
};
