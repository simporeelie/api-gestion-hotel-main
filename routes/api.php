<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CommoditeController;
use App\Http\Controllers\TypeClientController;
use App\Http\Controllers\CategorieHotelController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\ContenuChambreController;
use App\Http\Controllers\EquipementChambreController;
use App\Http\Controllers\ModePaiementController;
use App\Http\Controllers\MotifReservationController;
use App\Http\Controllers\OptionChambreController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SejourController;
use App\Http\Controllers\TypeChambreController;
use App\Models\ModePaiement;

Route::get('reservations/count', [ReservationController::class, 'countByStatus']);
Route::get('reservations/statutandhotel', [ReservationController::class, 'hotelByStatutAndHotel']);

// Routes nécessitant une authentification
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('user', UserController::class)->except(['edit', 'create'])->only([
        'index', 'show', 'update', 'destroy'
    ]);

    Route::resource('hotel', HotelController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('type_clients', TypeClientController::class)->except(['edit', 'create']);

    Route::resource('categorie_hotel', CategorieHotelController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('services', ServiceController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('commodites', CommoditeController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('pays', PaysController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('type_chambres', TypeChambreController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('contenu_chambres', ContenuChambreController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('option_chambres', OptionChambreController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('equipement_chambres', EquipementChambreController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('chambres', ChambreController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::get('chambres/taux_occupation', [ChambreController::class, 'tauxOccupation']);

    Route::resource('motif_reservations', MotifReservationController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('reservations', ReservationController::class)->except(['edit', 'create'])->only([
        'update', 'destroy'
    ]);

    Route::resource('mode_paiements', ModePaiementController::class)->except(['edit', 'create'])->only([
        'store', 'update', 'destroy'
    ]);

    Route::resource('sejours', SejourController::class)->except(['edit', 'create']);

    Route::post('logout', [AuthController::class, 'logout']);
});

// Routes publiques (ne nécessitant pas d'authentification)
Route::resource('user', UserController::class)->except(['edit', 'create'])->only(['store']);
Route::resource('hotel', HotelController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('categorie_hotel', CategorieHotelController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('services', ServiceController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('commodites', CommoditeController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('pays', PaysController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('type_chambres', TypeChambreController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('contenu_chambres', ContenuChambreController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('option_chambres', OptionChambreController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('equipement_chambres', EquipementChambreController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('chambres', ChambreController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('motif_reservations', MotifReservationController::class)->except(['edit', 'create'])->only(['index', 'show']);
Route::resource('reservations', ReservationController::class)->except(['edit', 'create'])->only(['show', 'store', 'index']);
Route::resource('mode_paiements', ModePaiementController::class)->except(['edit', 'create'])->only(['index', 'show']);

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@hotel.com'
    ], 404);
});