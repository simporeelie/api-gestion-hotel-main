<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\ModePaiement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sejour extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // reservation lier au sejour
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }

    // paiement lier au salaire
    public function modePaiement()
    {
        return $this->belongsTo(ModePaiement::class, 'mode_paiement_id', 'id');
    }

    // liste des service souscrit pendant un sejour
    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'pivot_service_sejours',
            'sejour_id',
            'service_id'
        );
    }

    public function supprimerPar()
    {
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }

    public function creerPar()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }
}
