<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmationToEdges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->boolean('confirmed')->default(false);
            $table->unsignedBigInteger('confirmed_by')->nullable();

            $table->foreign('confirmed_by')->references('id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->dropColumn('confirmed');
            $table->dropColumn('confirmed_by');
        });
    }
}
