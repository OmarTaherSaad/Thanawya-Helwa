<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->string('thanawya_system', 32)->nullable()->after('year');
        });

        DB::table('faculty_edges')->whereNull('thanawya_system')->update([
            'thanawya_system' => DB::raw("CASE
                WHEN year <= 2014 THEN 'pre_single_year'
                WHEN year <= 2020 THEN 'single_year_paper'
                WHEN year <= 2024 THEN 'electronic_bank'
                ELSE 'new_curriculum'
            END"),
        ]);

        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->index(['section', 'thanawya_system'], 'faculty_edges_section_thanawya_system_index');
        });
    }

    public function down(): void
    {
        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->dropIndex('faculty_edges_section_thanawya_system_index');
        });

        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->dropColumn('thanawya_system');
        });
    }
};
