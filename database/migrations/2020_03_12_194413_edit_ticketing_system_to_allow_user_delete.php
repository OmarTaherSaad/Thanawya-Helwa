<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTicketingSystemToAllowUserDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_payment_adder_user_id_foreign');
            $table->foreign('payment_adder_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_payment_adder_user_id_foreign');
            $table->foreign('payment_adder_user_id')->references('id')->on('users');
        });
    }
}
