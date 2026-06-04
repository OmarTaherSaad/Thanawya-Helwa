<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coordination_prediction_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unifac_id')->nullable()->index();
            $table->string('college_slug', 191)->index();
            $table->char('section', 1);
            $table->string('method', 64);
            $table->decimal('estimate', 8, 2)->nullable();
            $table->json('payload')->nullable();
            $table->text('disclaimer');
            $table->string('ip_address', 45)->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('unifac_id')->references('id')->on('unifac')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coordination_prediction_runs');
    }
};
