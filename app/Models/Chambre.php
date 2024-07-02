<?php

namespace App\Models;

use App\Models\Reservation;
use App\Models\TypeChambre;
use App\Models\OptionChambre;
use App\Models\ContenuChambre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chambre extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // liste des reservations lier a cette chambre
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'pivot_chambre_reservations', 'chambre_id', 'reservation_id', 'id', 'id');
    }

    // liste des contenus d'une chambre
    public function contenus()
    {
        return $this->belongsToMany(ContenuChambre::class, 'pivot_chambre_contenus', 'chambre_id', 'contenu_chambre_id', 'id', 'id');
    }

    // liste des options d'une chambres
    public function options()
    {
        return $this->belongsToMany(OptionChambre::class, 'pivot_chambre_options', 'chambre_id', 'option_chambre_id', 'id', 'id');
    }

    // type de chambre d'une chambre
    public function typeChambre()
    {
        return $this->belongsTo(TypeChambre::class, 'type_chambre_id', 'id');
    }

    public function equipements()
    {
        return $this->belongsToMany(OptionChambre::class, 'pivot_chambre_equipements', 'chambre_id', 'equipement_chambre_id', 'id', 'id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function creerPar()
    {
        return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
    }

    public function supprimerPar()
    {
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }

    public function prix()
    {
        // Récupérer les relations nécessaires une seule fois
        $typeChambre = $this->typeChambre;
        $options = $this->options;
        $equipements = $this->equipements;
        $contenus = $this->contenus;

        // Calculer les prix
        $prixTypeChambre = $typeChambre->prix ?? 0; // Vérifie si le type de chambre existe
        $prixOptions = $options->sum('prix');
        $prixEquipements = $equipements->sum('prix');
        $prixContenu = $contenus->sum('prix');

        // Retourner la somme totale
        return $prixTypeChambre + $prixOptions + $prixEquipements + $prixContenu;
    }

    public static function tauxOcupation()
    {
        $nbChambresLoue = Chambre::where('disponibilite', false)
            ->when(request()->filled('hotel_id'), function ($query) {
                $query->where('hotel_id', request('hotel_id'));
            })
            ->count();

        $nbChambresDispo = Chambre::where('disponibilite', true)
        ->when(request()->filled('hotel_id'), function ($query) {
            $query->where('hotel_id', request('hotel_id'));
        })
        ->count();

        return ($nbChambresLoue * 100) / (double) $nbChambresDispo;
    }

    public static function indiceFrequentation(){
        // indiceFrequentation = nbCLientsPresent / nbChambresLoue

        // $nbCLientsPresent =
    }
}
