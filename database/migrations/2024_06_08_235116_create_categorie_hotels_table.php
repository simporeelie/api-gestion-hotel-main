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
        Schema::create('categorie_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique();
            $table->foreignId("admin_id")->nullable()->constrained('users');
            // $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_hotels');
    }
};
