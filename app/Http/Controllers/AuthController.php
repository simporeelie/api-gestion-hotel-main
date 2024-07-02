<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function create(){
        return response()->json([
            'message' => 'Veuillez fournir vos identifiants pour vous connecter'
        ], 401); // 401 Unauthorized
    }




    public function login(LoginRequest $request)
    {

        $login = $request->input('login');
        $password = $request->input('password');

        // Déterminer si l'entrée login est un email ou un numéro de téléphone
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $credentials = [$fieldType => $login, 'password' => $password];


        $token = Auth::guard('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login ou Mot de passe incorecte',
            ], 401);
        }

        $user = Auth::guard('api')->user();

        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'deconnexion reussie',
        ]);
    }



    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => Auth::guard('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }



}
