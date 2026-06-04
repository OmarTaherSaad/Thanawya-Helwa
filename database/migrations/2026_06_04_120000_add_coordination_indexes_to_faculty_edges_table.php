<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Speeds up the public historical coordination explorer (section + year / name filters).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->index(['section', 'year'], 'faculty_edges_section_year_index');
            $table->index(['section', 'TempName'], 'faculty_edges_section_tempname_index');
        });
    }

    public function down(): void
    {
        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->dropIndex('faculty_edges_section_year_index');
            $table->dropIndex('faculty_edges_section_tempname_index');
        });
    }
};
