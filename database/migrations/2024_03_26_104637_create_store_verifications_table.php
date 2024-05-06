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
        Schema::create('store_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('full_name', 100);
            $table->string('address', 100);
            $table->string('subdistrict', 50);
            $table->string('district', 50);
            $table->string('city', 20);
            $table->string('province', 20);
            $table->string('postal_code', 10);
            $table->string('ktp_number', 20);
            $table->string('ktp_photo', 100);
            $table->string('npwp_number', 20)->nullable();
            $table->string('npwp_photo', 100)->nullable();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_verifications');
    }
};
