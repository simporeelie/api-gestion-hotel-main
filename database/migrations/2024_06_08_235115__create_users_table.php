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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
            // quand un admin cree un directeur d'hotel
            $table->foreignId("admin_id")->nullable()->references("id")->on("users");
            // quand un directeur hotel cree un agent
            $table->foreignId("directeur_hotel_id")->nullable()->references("id")->on("users");
            // quand un agent enregistre un client
            $table->foreignId("agent_id")->nullable()->references("id")->on("users");
            $table->foreignId('pays_naissance_id')->nullable()->references('id')->on('pays');
            $table->foreignId('pays_residence_id')->references('id')->on('pays');
            $table->foreignId("type_client_id")->nullable()->references("id")->on("type_clients");
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('genre', ['M', 'F', 'A']);
            $table->string("ref_piece");
            $table->date("dateNaissance");
            $table->enum("statut", ['standard', 'invite'])->nullable();
            $table->enum('role', ['directeur_hotel', 'agent', 'admin'])->nullable();
            $table->string('password')->nullable();
            $table->string('ville')->nullable();
            $table->string('region')->nullable();
            $table->string('rue')->nullable();
            $table->string('telephone');
            $table->string('code_postale')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
