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
        Schema::table('type_clients', function (Blueprint $table) {
            $table->foreignId("directeur_hotel_id")->nullable()->constrained('users');
            $table->foreignId('supprimer_par_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_client', function (Blueprint $table) {
            //
        });
    }
};
