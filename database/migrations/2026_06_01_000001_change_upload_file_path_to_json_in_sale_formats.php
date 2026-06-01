<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing single-path strings to JSON arrays
        DB::table('sale_formats')
            ->whereNotNull('upload_file_path')
            ->where('upload_file_path', 'not like', '[%')
            ->orderBy('id')
            ->each(function ($row) {
                DB::table('sale_formats')
                    ->where('id', $row->id)
                    ->update(['upload_file_path' => json_encode([$row->upload_file_path])]);
            });

        Schema::table('sale_formats', function (Blueprint $table) {
            $table->text('upload_file_path')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('sale_formats', function (Blueprint $table) {
            $table->string('upload_file_path')->nullable()->change();
        });
    }
};
