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
        Schema::create('sejours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->references('id')->on('reservations');
            $table->date("dateArrive");
            $table->date("dateDepart")->nullable();
            $table->integer('montantHT')->nullable();
            $table->integer('montantTTC')->nullable();
            $table->integer('montantRecus')->nullable();
            $table->foreignId('mode_paiement_id')->nullable()->references('id')->on('mode_paiements');
            $table->foreignId('agent_id')->constrained('users');
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
        Schema::dropIfExists('sejours');
    }
};
