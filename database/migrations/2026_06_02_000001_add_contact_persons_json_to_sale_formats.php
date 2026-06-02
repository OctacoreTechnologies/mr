<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sale_formats', function (Blueprint $table) {
            $table->json('contact_persons')->nullable()->after('customer_id');
        });

        // Migrate existing single-person data into the new JSON column
        DB::table('sale_formats')
            ->where(function ($q) {
                $q->whereNotNull('cp_name')
                  ->orWhereNotNull('cp_contact')
                  ->orWhereNotNull('cp_email')
                  ->orWhereNotNull('cp_designation');
            })
            ->orderBy('id')
            ->each(function ($row) {
                $person = [
                    'name'        => $row->cp_name        ?? '',
                    'designation' => $row->cp_designation ?? '',
                    'contact'     => $row->cp_contact ? [$row->cp_contact] : [],
                    'email'       => $row->cp_email   ? [$row->cp_email]   : [],
                ];
                DB::table('sale_formats')
                    ->where('id', $row->id)
                    ->update(['contact_persons' => json_encode([$person])]);
            });

        Schema::table('sale_formats', function (Blueprint $table) {
            $table->dropColumn(['cp_name', 'cp_designation', 'cp_contact', 'cp_email']);
        });
    }

    public function down(): void
    {
        Schema::table('sale_formats', function (Blueprint $table) {
            $table->string('cp_name')->nullable();
            $table->string('cp_designation')->nullable();
            $table->string('cp_contact')->nullable();
            $table->string('cp_email')->nullable();
        });

        // Restore first contact person back into legacy columns
        DB::table('sale_formats')
            ->whereNotNull('contact_persons')
            ->orderBy('id')
            ->each(function ($row) {
                $persons = json_decode($row->contact_persons, true) ?? [];
                if (!empty($persons)) {
                    $first = $persons[0];
                    DB::table('sale_formats')
                        ->where('id', $row->id)
                        ->update([
                            'cp_name'        => $first['name']               ?? null,
                            'cp_designation' => $first['designation']        ?? null,
                            'cp_contact'     => $first['contact'][0] ?? null,
                            'cp_email'       => $first['email'][0]   ?? null,
                        ]);
                }
            });

        Schema::table('sale_formats', function (Blueprint $table) {
            $table->dropColumn('contact_persons');
        });
    }
};
