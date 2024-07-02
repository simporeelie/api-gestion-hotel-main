<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\TypeChambre;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeChambreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypeChambre::class;

    /**
     * Room capacity data.
     *
     * @var array
     */
    protected static $roomCapacity = [
        'Chambre simple' => ['adults' => 1, 'children' => 0],
        'Chambre double' => ['adults' => 2, 'children' => 0],
        'Chambre triple' => ['adults' => 3, 'children' => 0],
        'Dortoir' => ['adults' => 1, 'children' => 0],
        'Chambre mixte ou non' => ['adults' => 2, 'children' => 1],
        'Chambre standard' => ['adults' => 2, 'children' => 2],
        'Chambre de milieu de gamme' => ['adults' => 2, 'children' => 1],
        'Chambre supérieure' => ['adults' => 2, 'children' => 2],
        'Chambre familiale' => ['adults' => 2, 'children' => 3],
        'Chambre économique' => ['adults' => 2, 'children' => 0],
        'Chambre de luxe' => ['adults' => 2, 'children' => 2],
        'Chambre exécutive' => ['adults' => 2, 'children' => 1],
        'Studio' => ['adults' => 2, 'children' => 1],
        'Suite junior' => ['adults' => 2, 'children' => 2],
        'Suite' => ['adults' => 2, 'children' => 2],
        'Chambre deluxe' => ['adults' => 2, 'children' => 1],
        'Penthouse' => ['adults' => 2, 'children' => 2],
        'Chambre premium' => ['adults' => 2, 'children' => 2],
    ];

    /**
     * VIP room types.
     *
     * @var array
     */
    protected static $vipLibelles = [
        'Chambre de luxe',
        'Chambre exécutive',
        'Studio',
        'Suite junior',
        'Suite',
        'Chambre deluxe',
        'Penthouse',
        'Chambre premium',
    ];

    /**
     * Non-VIP room types.
     *
     * @var array
     */
    protected static $nonVipLibelles = [
        'Chambre simple',
        'Chambre double',
        'Chambre triple',
        'Dortoir',
        'Chambre mixte ou non',
        'Chambre standard',
        'Chambre de milieu de gamme',
        'Chambre supérieure',
        'Chambre familiale',
        'Chambre économique',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->defaultState();
    }

    /**
     * Generate the default state for the room type.
     *
     * @param bool $isVip
     * @param string|null $libelle
     * @return array
     */
    protected function defaultState($isVip = null, $libelle = null)
    {
        if (is_null($libelle)) {
            $libelle = $this->faker->randomElement(array_keys(static::$roomCapacity));
        }

        $capacity = static::$roomCapacity[$libelle];

        return [
            'libelle' => $libelle,
            'prix' => $this->faker->numberBetween(50, 1000),
            'isVip' => $isVip ?? in_array($libelle, static::$vipLibelles),
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'nb_adulte' => $capacity['adults'],
            'nb_enfant' => $capacity['children'],
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }

    /**
     * Indicate that the room is a VIP room.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function vip()
    {
        return $this->state(function () {
            $libelle = $this->faker->randomElement(static::$vipLibelles);
            return $this->defaultState(true, $libelle);
        });
    }

    /**
     * Indicate that the room is a non-VIP room.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function nonVip()
    {
        return $this->state(function () {
            $libelle = $this->faker->randomElement(static::$nonVipLibelles);
            return $this->defaultState(false, $libelle);
        });
    }
}
