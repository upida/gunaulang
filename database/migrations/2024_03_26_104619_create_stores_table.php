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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('storename', 20)->unique();
            $table->string('name', 30);
            $table->string('description')->nullable();
            $table->string('logo', 50)->nullable();
            $table->string('cover', 50)->nullable();
            $table->string('phone', 20);
            $table->string('address', 100);
            $table->string('subdistrict', 50);
            $table->string('district', 50);
            $table->string('city', 20);
            $table->string('province', 20);
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->string('gmaps_point', 20)->nullable();
            $table->string('notes', 50)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
