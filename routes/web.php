<?php

use App\Models\User;
use App\Models\Hotel;
use App\Models\TypeClient;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@hotel.com'
    ], 404);
});
