<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GeoDist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GeoDist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('governorate_id');
            $table->char('group',1);

            $table->foreign('university_id')->references('id')->on('universities');
            $table->foreign('governorate_id')->references('id')->on('governorates');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('GeoDist');
    }
}
