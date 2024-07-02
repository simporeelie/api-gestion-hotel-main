<?php

namespace App\Models;

use App\Models\User;
use App\Models\Sejour;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModePaiement extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // liste des paiement effectuer avec un mode de paiement
    public function sejours()
    {
        return $this->hasMany(Sejour::class, 'mode_paiement_id', 'id');
    }

    public function supprimerPar()
    {
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }

    public function creerPar()
    {
        return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
    }
}
