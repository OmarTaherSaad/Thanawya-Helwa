<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Public university directory: stable slug, optional meta, visibility.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique();
            $table->text('meta_description')->nullable();
            $table->boolean('is_active')->default(true);
        });

        DB::table('universities')->orderBy('id')->select(['id'])->chunkById(500, function ($rows): void {
            foreach ($rows as $row) {
                DB::table('universities')->where('id', $row->id)->update([
                    'slug' => 'university-'.$row->id,
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_description', 'is_active']);
        });
    }
};
