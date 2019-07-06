<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditGeoDistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('GeoDist', function (Blueprint $table) {
            $table->renameColumn('governorate_id','administration_id');

            $table->dropForeign('GeoDist_governorate_id_foreign');

            $table->foreign('administration_id')->references('id')->on('administrations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('GeoDist', function (Blueprint $table) {
            $table->renameColumn('administration_id','governorate_id');

            $table->dropForeign('GeoDist_administration_id_foreign');

            $table->foreign('governorate_id')->references('id')->on('governorates');
        });
    }
}
