<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\ModePaiement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModePaiementSeeder extends Seeder
{
    private $modes =  [
        'Carte de crédit',
        'Carte de débit',
        'Espèces',
        'Chèque',
        'Virement bancaire',
        'PayPal',
        'Apple Pay',
        'Google Pay'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            foreach ($this->modes as $mode) {
                ModePaiement::factory()->create([
                    'libelle' => $mode,
                    'directeur_hotel_id' => $hotel->directeurHotel->id,
                    'hotel_id' => $hotel->directeurHotel->hotel_id
                ]);
            }
        }
    }
}
