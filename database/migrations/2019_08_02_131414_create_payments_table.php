<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method');
            $table->date('date');
            $table->string('amount');
            $table->string('mobile_of_payment');
            $table->timestamps();

            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('payment_adder_user_id')->nullable();

            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('payment_adder_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
