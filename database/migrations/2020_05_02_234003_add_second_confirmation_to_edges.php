<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecondConfirmationToEdges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculty_edges', function (Blueprint $table) {
            $table->boolean('confirmed2')->default(false);
            $table->unsignedBigInteger('confirmed2_by')->nullable();

            $table->foreign('confirmed2_by')->references('id')->on('members')->onDelete('set null');
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
            $table->dropColumn('confirmed2');
            $table->dropColumn('confirmed2_by');
        });
    }
}
