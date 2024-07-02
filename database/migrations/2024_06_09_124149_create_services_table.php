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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->integer('prix');
            $table->timestamps();
            $table->foreignId('directeur_hotel_id')->references('id')->on('users');
            $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
            $table->foreignId("hotel_id")->nullable()->references("id")->on("hotels");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
