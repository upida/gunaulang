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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_new')->default(true);
            $table->boolean('is_food')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedFloat('price', 10);
            $table->timestamp('expired_at')->nullable();
            $table->unsignedInteger('likes')->default(0);
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
