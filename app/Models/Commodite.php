<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commodite extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function creerPar()
    {
        return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
    }

    public function suprimerPar()
    {
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }
}
