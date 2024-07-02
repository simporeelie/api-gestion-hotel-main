<?php

namespace Database\Seeders;

use App\Models\Tva;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tva::create([
            'taux' => 10.00,
        ]);
    }
}
