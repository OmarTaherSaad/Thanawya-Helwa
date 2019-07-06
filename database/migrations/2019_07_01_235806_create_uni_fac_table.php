<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniFacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UniFac', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('faculty_id');
            $table->timestamps();

            $table->foreign('university_id')->references('id')->on('universities');
            $table->foreign('faculty_id')->references('id')->on('faculties');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('UniFac');
    }
}
