<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // Génération du numéro de confirmation unique lors de la création d'une réservation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            $reservation->numConfirmation = self::generateUniqueConfirmationNumber();
        });
    }

    // Méthode pour générer un numéro de confirmation unique
    public static function generateUniqueConfirmationNumber()
    {
        do {
            $numConfirmation = strtoupper(uniqid('CONF-'));
        } while (self::where('numConfirmation', $numConfirmation)->exists());

        return $numConfirmation;
    }

    // Relations
    public function creerPar()
    {
        return $this->belongsTo(User::class, 'agent_reception_id', 'id');
    }

    public function supprimerPar()
    {
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }

    public function chargerSuivie()
    {
        return $this->belongsTo(User::class, 'charger_suivie_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function motifReservation()
    {
        return $this->belongsTo(MotifReservation::class, 'motif_reservation_id', 'id');
    }

    public function chambres()
    {
        return $this->belongsToMany(Chambre::class, 'pivot_chambre_reservations', 'reservation_id', 'chambre_id', 'id', 'id');
    }

    public function sejour()
    {
        return $this->hasOne(Sejour::class, 'reservation_id', 'id');
    }

    // public function enCours()
    // {
    //     $now = now();

    //     $reservations = Reservation::when(request()->filled('hotel_id'), function ($query) {
    //         $query->where('hotel_id', request('hotel_id'));
    //     })
    //         ->get();
    //     // utilise carbon pour verifier si la d'aujourd'hui est compris entre la date d'arivie et la date de depart de la reservation
    // }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function fatureProFormaPath()
    {
        return 'pdf/' . $this->dateArrive . '_' . $this->dateDepart . '_' . $this->id;
    }

    public function qteNuite()
    {
        $dateArrive = Carbon::parse($this->dateArrive);
        $dateDepart = Carbon::parse($this->dateDepart);

        // Calculer la différence en jours
        return  $dateArrive->diffInDays($dateDepart);
    }

    public function prixU_NuiteTTC()
    {
        // Initialisation du prix total HT (hors taxes) des chambres à 0
        $prixNuitHT = 0;

        // Récupération du taux de TVA (premier enregistrement dans la table `tvas`)
        $tva = Tva::first()->taux;

        // Parcours de toutes les chambres associées à cette réservation
        foreach ($this->chambres as  $chambre) {
            // Addition du prix HT de chaque chambre au prix total HT
            $prixNuitHT += $chambre->prix();
        }

        // Calcul du prix TTC (HT + TVA)
        return $prixNuitHT + ($tva * $prixNuitHT);
    }

    public function prixT_NuiteTTC()
    {
        // Initialisation du prix total HT (hors taxes) des chambres à 0
        $prixNuitHT = 0;

        // Récupération du taux de TVA (premier enregistrement dans la table `tvas`)
        $tva = Tva::first()->taux;

        // Parcours de toutes les chambres associées à cette réservation
        foreach ($this->chambres as  $chambre) {
            // Addition du prix HT de chaque chambre au prix total HT
            $prixNuitHT += $chambre->prix();
        }

        // Calcul du prix unitaire TTC (HT + TVA)
        $prixNuiteTTC = $prixNuitHT + ($tva * $prixNuitHT);

        // Calcul du prix total TTC (prix unitaire TTC multiplié par la quantité de nuitées)
        return $this->qteNuite() * $prixNuiteTTC;
    }

    public function totalTT()
    {
        return $this->prixT_NuiteTTC();
    }
}
