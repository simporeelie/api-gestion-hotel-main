<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ContenuChambre;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ContenuChambre\ContenuChambreResource;
use App\Http\Requests\ContenuChambre\StoreContenuChambreRequest;
use App\Http\Requests\ContenuChambre\UpdateContenuChambreRequest;

class ContenuChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $contenuChambres = $hotel_id ? ContenuChambre::where('hotel_id', $hotel_id)->get() : ContenuChambre::all();
        return response()->json([
            'message' => 'Liste des contenus de chambres récupérée avec succès',
            'data' => ContenuChambreResource::collection($contenuChambres)
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContenuChambreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        $contenuChambre = ContenuChambre::create($data);
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }
        return response()->json([
            'message' => 'Contenu de chambre créé avec succès',
            'data' => new ContenuChambreResource($contenuChambre)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContenuChambre $contenuChambre): JsonResponse
    {
        return response()->json([
            'message' => 'Contenu de chambre récupéré avec succès',
            'data' => new ContenuChambreResource($contenuChambre)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContenuChambre $contenuChambre)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContenuChambreRequest $request, ContenuChambre $contenuChambre): JsonResponse
    {
        $contenuChambre->update($request->validated());

        return response()->json([
            'message' => 'Contenu de chambre mis à jour avec succès',
            'data' => new ContenuChambreResource($contenuChambre)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContenuChambre $contenuChambre): JsonResponse
    {
        $contenuChambre->update(['supprimer_par_id' => auth()->user()->id ?? 2]);
        $contenuChambre->delete();

        return response()->json([
            'message' => 'Contenu de chambre supprimé avec succès'
        ], 200);
    }
}
