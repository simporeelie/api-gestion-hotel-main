<?php

namespace Database\Seeders;

use App\Models\CategorieHotel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategorieHotel::factory()->count(5)->create();
    }
}