<?php

namespace App\Models;

use App\Models\User;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pays extends Model
{
    use HasFactory;

    protected $table = 'pays';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // utilisateurs Nés Ici
    public function utilisateursNesIci()
    {
        return $this->hasMany(User::class, 'pays_naissance_id', 'id');
    }

    // utilisateurs Residant Ici
    public function utilisateursResidantIci()
    {
        return $this->hasMany(User::class, 'pays_residence_id', 'id');
    }


    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'hotel_id', 'id');
    }

    public function creerPar()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
