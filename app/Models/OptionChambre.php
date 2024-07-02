<?php

namespace App\Models;

use App\Models\User;
use App\Models\Chambre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionChambre extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // liste des chambre lier a cette equipement
    public function chambres()
    {
        return $this->belongsTo(
            Chambre::class,
            'pivot_chambre_options',
            'option_chambre_id',
            'chambre_id'
        );
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
