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
        Schema::create('order_payment_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_payment_id');
            $table->string('title', 50);
            $table->string('description', 100)->nullable();
            $table->boolean('received')->default(false);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('order_payment_id')->references('id')->on('order_payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payment_statuses');
    }
};
