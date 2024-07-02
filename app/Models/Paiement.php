<?php

namespace App\Models;

use App\Models\Sejour;
use App\Models\ModePaiement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // mode de paiement utiliser pour un paiement
    public function modePaiement() {
        return $this->belongsTo(ModePaiement::class, 'mode_paiement_id', 'id');
    }

    public function sejour(){
        return $this->hasOne(Sejour::class, 'paiement_id', 'id');
    }
}
