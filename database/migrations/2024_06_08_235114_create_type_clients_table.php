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
        Schema::create('type_clients', function (Blueprint $table) {
            $table->id();
            $table->enum('libelle', ['occasionnels','fideles', 'VIP'])->default('occasionnels');
            $table->integer("nbReservation")->default(1);
            $table->enum('operateur', ['>=','<=', '>', '<', '=']);
            $table->integer("frequense")->default(1);
            $table->enum("periode", ['jour', 'semaine', 'mois', 'annee']);
            // $table->foreignId("directeur_hotel_id")->constrained('users'); // ajouter dans une autre migration
            // $table->foreignId('supprimer_par_id')->nullable()->constrained('users'); // ajouter dans une autre migration
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_clients');
    }
};
