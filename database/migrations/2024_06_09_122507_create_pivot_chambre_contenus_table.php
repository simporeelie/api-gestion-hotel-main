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
        Schema::create('pivot_chambre_contenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contenu_chambre_id')->references('id')->on('contenu_chambres');
            $table->foreignId('chambre_id')->references('id')->on('chambres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_chambre_contenus');
    }
};
