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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->integer('montantRecus');
            $table->integer('montantRestant');
            $table->foreignId('mode_paiement_id')->references('id')->on('mode_paiements');
            $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
            $table->foreignId("hotel_id")->nullable()->references("id")->on("hotels");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
