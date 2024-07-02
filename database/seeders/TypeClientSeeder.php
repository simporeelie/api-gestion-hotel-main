<?php

namespace Database\Seeders;

use App\Models\TypeClient;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeClient::factory()->count(20)->create([
            'libelle' => 'occasionnels',
            'nbReservation' => 1,
            'operateur' => '>',
            'frequense' => 0,
            'periode' => 'jour',
        ]);
    }
}
