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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_hotel_id')->references('id')->on('categorie_hotels');
            $table->foreignId('directeur_hotel_id')->references('id')->on('users');
            $table->string("libelle");
            $table->string("photo")->nullable();
            $table->string("emplacement")->unique();
            $table->string("email")->unique();
            $table->string("site_web")->nullable()->unique();
            $table->string('ville')->nullable();
            $table->string('region')->nullable();
            $table->string('rue')->nullable();
            $table->string('code_postale')->nullable()->unique();
            $table->string('telephone')->unique();
            $table->foreignId('pays_id')->nullable()->references('id')->on('pays');
            $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
