<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Pays;
use App\Models\Hotel;
use App\Models\Chambre;
use App\Models\Indicatif;
use App\Models\Telephone;
use App\Models\TypeClient;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'telephone' => $this->telephone,
            'name' => $this->nom . ' ' . $this->prenom,
            'role' => $this->role,
            'hotel_id' => $this->hotel_id,
        ];
    }

    public static function getClientBuilder(Builder $query){
        $query->orWhere(function($q){
            $q->whereNull('role')
            ->whereNull('admin_id')
            ->whereNull('directeur_hotel_id')
            ->whereNotNull('type_client_id')
            ->whereNotNull('statut');
        });
    }

    public function isClient()
    {
        return $this->role === null &&

            $this->admin_id === null &&
            $this->directeur_hotel_id === null &&

            $this->type_client_id !== null &&
            $this->statut !== null;
    }

    public static function getAdminBuilder(Builder $query){
        $query->orWhere(function($q){
            $q->where('role', 'admin')
            ->whereNull('agent_id')
            ->whereNull('directeur_hotel_id')
            ->whereNull('type_client_id')
            ->whereNull('statut');
        });
    }

    public function isAdmin()
    {
        return $this->role === 'admin' &&

            $this->directeur_hotel_id === null &&
            $this->agent_id === null &&

            $this->type_client_id === null &&
            $this->statut === null;
    }

    public static function getDirecteurHotelBuilder(Builder $query){
        $query->orWhere(function($q){
            $q->where('role', 'directeur_hotel')
            ->whereNull('directeur_hotel_id')
            ->whereNull('agent_id')
            ->whereNull('type_client_id')
            ->whereNull('statut');
        });
    }

    public function isDirecteurHotel()
    {
        return $this->role === 'directeur_hotel' &&

            $this->directeur_hotel_id === null &&
            $this->agent_id === null &&

            $this->type_client_id === null &&
            $this->statut === null;
    }

    public static function getAgentBuilder(Builder $query){
        $query->orWhere(function($q){
            $q->where('role', 'agent')
            ->whereNull('agent_id')
            ->whereNull('admin_id')
            ->whereNull('type_client_id')
            ->whereNull('statut');
        });
    }

    public function isAgent()
    {
        return $this->role === 'agent' &&

            $this->agent_id === null &&
            $this->admin_id === null &&

            $this->type_client_id === null &&
            $this->statut === null;
    }

    public static function getUserDataInRequest()
    {
        if (request()->has('nom')) {
            $data['nom'] = request()->nom;
        }

        if (request()->has('prenom')) {
            $data['prenom'] = request()->prenom;
        }

        if (request()->has('email')) {
            $data['email'] = request()->email;
        }

        if (request()->has('ref_piece')) {
            $data['ref_piece'] = request()->ref_piece;
        }

        if (request()->has('genre')) {
            $data['genre'] = request()->genre;
        }

        if (request()->has('dateNaissance')) {
            $data['dateNaissance'] = request()->dateNaissance;
        }

        if (request()->has('pays_naissance_id')) {
            $data['pays_naissance_id'] = request()->input('pays_naissance_id');
        }

        if (request()->has('pays_residence_id')) {
            $data['pays_residence_id'] = request()->input('pays_residence_id');
        }

        if (request()->has('ville')) {
            $data['ville'] = request()->input('ville');
        }

        if (request()->has('region')) {
            $data['region'] = request()->input('region');
        }

        if (request()->has('rue')) {
            $data['rue'] = request()->input('rue');
        }

        if (request()->has('code_postale')) {
            $data['code_postale'] = request()->input('code_postale');
        }

        if (request()->has('telephone')) {
            $data['telephone'] = request()->input('telephone');
        }

        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        }

        return $data;
    }


    public static function getClientDataInRequest()
    {
        $data = [];

        if (request()->has('statut')) {
            $data['statut'] = request()->statut;
        }

        if (request()->has('password')) {
            $data['password'] =  Hash::make(request()->password);
        }

        if (request()->has('type_client_id')) {
            // $data['type_client_id'] = request()->type_client_id;
        }
        $data['type_client_id'] = request('hotel_id') ? TypeClient::where('hotel_id', request('hotel_id'))->where('libelle', 'occasionnels')->first()->id : 1;

        if (Route::is('user.store') && request()->has('created_by') && request()->created_by === 'agent') {
            $data['agent_id'] = auth()->user()->id ?? 13;
        }

        return $data;
    }

    public static function getEmployerDataInRequest()
    {
        $data = [];

        if (request()->has('role')) {
            $data['role'] = request()->role;
        }

        if (request()->has('password')) {
            $data['password'] = Hash::make(request()->password);
        }

        // if (request()->has('admin_id')) {
        //     $data['admin_id'] = request()->admin_id;
        // }

        // if (request()->has('directeur_hotel_id')) {
        //     $data['directeur_hotel_id'] = request()->directeur_hotel_id;
        // }

        if (Route::is('user.store') && request()->has('created_by') && request()->created_by === 'directeur_hotel') {
            $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        }

        if (Route::is('user.store') && request()->has('created_by') && request()->created_by === 'admin') {
            $data['admin_id'] = auth()->user()->id ?? 1;
        }

        return $data;
    }

    public function paysNaissance()
    {
        return $this->belongsTo(Pays::class, 'pays_naissance_id', 'id');
    }

    public function paysResidence()
    {
        return $this->belongsTo(Pays::class, 'pays_residence_id', 'id');
    }

    // relation pour avoir le type de client de telephone de l'utilisateur
    public function typeClient()
    {
        return $this->belongsTo(TypeClient::class, 'type_client_id', 'id');
    }

    // renvoie les reservation fait par un clients si il est un client
    // ou les reservation creer par un agent si il est un agent
    public function reservations()
    {
        if ($this->role === 'agent') {
            return $this->hasMany(Reservation::class, 'agent_reception_id', 'id');
        } else {
            return $this->hasMany(Reservation::class, 'client_id', 'id');
        }
    }

    // revoie les reservations qui on ete assginer a un agent
    public function reservationsAssigner()
    {
        return $this->hasMany(Reservation::class, 'charger_suivie_id', 'id');
    }

    public function hotelsAssigner()
    {
        return $this->hasMany(Hotel::class, 'directeur_hotel_id', 'id');
    }

    public function hotel(){
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function creerPar()
    {
        switch ($this->role) {
            case 'admin':
                return $this->belongsTo(User::class, 'admin_id', 'id');
                break;
            case 'directeur_hotel':
                return $this->belongsTo(User::class, 'admin_id', 'id');
                break;
            case 'agent':
                return $this->belongsTo(User::class, 'directeur_hotel_id', 'id');
                break;
            default:
                return $this->belongsTo(User::class, 'agent_id', 'id');
                break;
        }
    }

    public function supprimerPar()
    {
        return $this->belongsTo(User::class, 'supprimer_par_id', 'id');
    }

    public function userCreer()
    {
        switch ($this->role) {
            case 'admin':
                return $this->hasMany(User::class, 'admin_id', 'id');
                break;
            case 'directeur_hotel':
                return $this->hasMany(User::class, 'directeur_hotel_id', 'id');
                break;
        }
    }

    public function chambres()
    {
        return $this->hasMany(Chambre::class, 'directeur_hotel_id', 'id');
    }

    public function contenus()
    {
        return $this->hasMany(ContenuChambre::class, 'directeur_hotel_id', 'id');
    }

    public function equipements()
    {
        return $this->hasMany(EquipementChambre::class, 'directeur_hotel_id', 'id');
    }

    public function typeChambres()
    {
        return $this->hasMany(TypeChambre::class, 'directeur_hotel_id', 'id');
    }


    public function options()
    {
        return $this->hasMany(OptionChambre::class, 'directeur_hotel_id', 'id');
    }

    public function commodites()
    {
        return $this->hasMany(Commodite::class, 'directeur_hotel_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'directeur_hotel_id', 'id');
    }
}
