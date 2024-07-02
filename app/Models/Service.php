<?php

namespace App\Models;

use App\Models\Hotel;
use App\Models\Sejour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function sejours() {
        return $this->belongsToMany(
            Sejour::class,
            'pivot_service_sejours',
            'service_id',
            'sejour_id'
        );
    }

    public function creerPar(){
        return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
    }

    public function supprimerPar(){
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }
}
