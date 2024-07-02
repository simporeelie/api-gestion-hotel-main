<?php

namespace App\Models;

use App\Models\Chambre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeChambre extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // liste des chambres qui sont lier a un type
    public function chambres(){
        return $this->hasMany(Chambre::class, 'type_chambre_id', 'id');
    }

    public function creerPar(){
        return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
    }

    public function supprimerPar(){
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }
}
