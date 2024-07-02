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
        Schema::create('chambres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_chambre_id')->references('id')->on('type_chambres');
            $table->boolean('disponibilite')->default(true);
            $table->integer('taille')->default(0);
            $table->integer('numero')->default(0);
            // $table->foreignId('hotel_id')->references('id')->on('hotels');
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('directeur_hotel_id')->references('id')->on('users');
            $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
            $table->foreignId("hotel_id")->nullable()->references("id")->on("hotels");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};
