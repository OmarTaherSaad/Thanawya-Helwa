<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('content_before_review');
            $table->longText('content')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('state')->default('draft');
            $table->float('rate')->nullable();
            $table->unsignedBigInteger('written_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('written_by')->references('id')->on('members')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
