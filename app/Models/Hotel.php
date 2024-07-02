<?php

namespace App\Models;

use App\Models\Pays;
use App\Models\User;
use App\Models\Adresse;
use App\Models\Chambre;
use App\Models\Service;
use App\Models\Commodite;
use App\Models\Indicatif;
use App\Models\CategorieHotel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public static function getDataFromRequest()
    {
        $data = [];

        if (request()->filled('categorie_hotel_id')) {
            $data['categorie_hotel_id'] = request()->input('categorie_hotel_id');
        }

        if (request()->filled('directeur_hotel_id')) {
            $data['directeur_hotel_id'] = request()->input('directeur_hotel_id');
        }

        if (request()->filled('libelle')) {
            $data['libelle'] = request()->input('libelle');
        }

        if (request()->filled('photo')) {
            $data['photo'] = request()->input('photo');
        }

        if (request()->filled('emplacement')) {
            $data['emplacement'] = request()->input('emplacement');
        }

        if (request()->filled('email')) {
            $data['email'] = request()->input('email');
        }

        if (request()->filled('site_web')) {
            $data['site_web'] = request()->input('site_web');
        }

        if (request()->filled('telephone')) {
            $data['telephone'] = request()->input('telephone');
        }

        if (request()->filled('pays_id')) {
            $data['pays_id'] = request()->input('pays_id');
        }

        if (request()->filled('ville')) {
            $data['ville'] = request()->input('ville');
        }

        if (request()->filled('region')) {
            $data['region'] = request()->input('region');
        }

        if (request()->filled('rue')) {
            $data['rue'] = request()->input('rue');
        }

        if (request()->filled('code_postale')) {
            $data['code_postale'] = request()->input('code_postale');
        }

        return $data;
    }


    public function categorieHotel(){
        return $this->belongsTo(CategorieHotel::class, 'categorie_hotel_id', 'id');
    }

    public function pays(){
        return $this->belongsTo(Pays::class, 'pays_id', 'id');
    }

    public function comodites(){
        return $this->hasMany(Commodite::class, 'hotel_id', 'id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'hotel_id', 'id');
    }

    public function directeurHotel(){
        return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
    }

    public function chambres(){
        return $this->hasMany(Chambre::class, 'hotel_id', 'id');
    }

    public function supprimerPar(){
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }
}
