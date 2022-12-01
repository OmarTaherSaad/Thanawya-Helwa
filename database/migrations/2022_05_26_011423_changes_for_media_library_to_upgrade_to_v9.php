<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ChangesForMediaLibraryToUpgradeToV9 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            if (!Schema::hasColumn('media', 'conversions_disk')) {
                $table->string('conversions_disk')->nullable();
            }
            if (!Schema::hasColumn('media', 'uuid')) {
                $table->uuid('uuid')->nullable();
            }
        });

        if (!Schema::hasColumn('media', 'generated_conversions')) {
            Schema::table('media', function (Blueprint $table) {
                $table->json('generated_conversions')->nullable();
            });
        }

        Media::cursor()->each(function (Media $media) {
            $custom_properties = $media->custom_properties;
            $media->update([
                'uuid' => \Str::uuid(),
                'generated_conversions' => $custom_properties['generated_conversions'],
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('conversions_disk');
            $table->dropColumn('uuid');
            $table->dropColumn('generated_conversions');
        });
    }
}
