<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotifReservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // la reservation qui est lier a ce motif
    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'motif_reservation_id', 'id');
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
