<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coin_history_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coin_history_id');
            $table->enum('type', ['total', 'from']);
            $table->string('title', 100);
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('coin_history_id')->references('id')->on('coin_histories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_history_details');
    }
};
