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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string("libelle")->unique();
            $table->string('indicatif');
            $table->string('drapeau')->nullable()->unique();
            $table->timestamps();

            // $table->foreignId("admin_id")->nullable()->references("id")->on("users"); // !! ajouter dans une autre migration !!
            // $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};
