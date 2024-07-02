<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * En attente : La réservation a été créée mais n'a pas encore été confirmée.
     */

    /**
     * Confirmée : La réservation a été confirmée par l'hôtel et est active.
     */

    /**
     * En cours : Le client est actuellement en séjour à l'hôtel.
     */

    /**
     * Complétée : Le séjour du client est terminé et la réservation a été clôturée.
     */

    /**
     * Annulée : La réservation a été annulée par le client ou l'hôtel avant l'arrivée prévue.
     */

    /**
     * No Show : Le client ne s'est pas présenté à l'hôtel et n'a pas annulé la réservation.
     */

    /**
     * En attente de paiement : La réservation a été créée mais le paiement n'a pas encore été effectué.
     */

    /**
     * Payée : Le paiement pour la réservation a été reçu.
     */

    /**
     * Modifiée : Les détails de la réservation ont été modifiés après la création initiale.
     */


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('nb_enfant');
            $table->integer('nb_adulte');
            $table->date('dateArrive');
            $table->date('dateDepart');
            $table->string('numConfirmation')->unique();
            $table->enum('type', ['appel', 'en_ligne', 'presentiel']);
            $table->text('demandes_particuliere')->nullable();
            $table->enum('statut', ['en_attente', 'confirmee', 'en_cours', 'completee', 'annulee', 'no_show', 'en_attente_de_paiement', 'payee', 'modifiee'])->default('en_attente');
            // id du client
            $table->foreignId('client_id')->references('id')->on('users');
            // id de l'agent qui a créé la réservation
            $table->foreignId('agent_reception_id')->nullable()->references('id')->on('users');
            // id de l'agent chargé de la suivi de la réservation
            $table->foreignId('charger_suivie_id')->references('id')->on('users');
            $table->foreignId('motif_reservation_id')->references('id')->on('motif_reservations');
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
        Schema::dropIfExists('reservations');
    }
};
