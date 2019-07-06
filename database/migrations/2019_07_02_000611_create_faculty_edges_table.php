<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyEdgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_edges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unifac_id')->nullable(true);
            $table->string('section',5);
            $table->unsignedSmallInteger('year');
            $table->unsignedSmallInteger('edge')->default('0');
            $table->timestamps();

            $table->foreign('unifac_id')->references('id')->on('unifac');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_edges');
    }
}
