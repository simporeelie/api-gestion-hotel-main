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
        Schema::create('pivot_service_sejours', function (Blueprint $table) {
            $table->id();
            $table->date('dateSouscription')->default(now());
            $table->foreignId('service_id')->references('id')->on('services');
            $table->foreignId('sejour_id')->references('id')->on('sejours');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_service_sejours');
    }
};
