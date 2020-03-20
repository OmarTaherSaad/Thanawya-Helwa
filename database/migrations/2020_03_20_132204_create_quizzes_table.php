<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('questions');
            $table->string('subject', 100);
            $table->string('description',255);
            $table->float('total_mark');
            $table->unsignedBigInteger('made_by')->nullable();
            $table->unsignedBigInteger('revised_by')->nullable();
            $table->unsignedBigInteger('inserted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('made_by')->references('id')->on('members')->onDelete('set null');
            $table->foreign('revised_by')->references('id')->on('members')->onDelete('set null');
            $table->foreign('inserted_by')->references('id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
