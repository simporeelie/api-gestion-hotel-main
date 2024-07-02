<?php

namespace App\Models;

use App\Models\Chambre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContenuChambre extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // liste des chambres lier a un contenu
    public function chambres()
    {
        return $this->belongsToMany(
            Chambre::class,
            'pivot_chambre_contenus',
            'contenu_chambre_id',
            'chambre_id'
        );
    }

    public function creerPar()
    {
        return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
    }

    public function supprimerPar(){
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }
}
