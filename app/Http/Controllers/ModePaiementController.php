<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ModePaiement;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ModePaiement\ModePaiementResource;
use App\Http\Requests\ModePaiement\StoreModePaiementRequest;
use App\Http\Requests\ModePaiement\UpdateModePaiementRequest;

class ModePaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $modePaiements = $hotel_id ? ModePaiement::where('hotel_id', $hotel_id)->get() : ModePaiement::all();
        return response()->json([
            'message' => 'Liste des modes de paiement récupérée avec succès',
            'data' => ModePaiementResource::collection($modePaiements)
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
    public function store(StoreModePaiementRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }
        $modePaiement = ModePaiement::create($data);

        return response()->json([
            'message' => 'Mode de paiement créé avec succès',
            'data' => new ModePaiementResource($modePaiement)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModePaiement $modePaiement): JsonResponse
    {
        return response()->json([
            'message' => 'Mode de paiement récupéré avec succès',
            'data' => new ModePaiementResource($modePaiement)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModePaiement $modePaiement)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModePaiementRequest $request, ModePaiement $modePaiement): JsonResponse
    {
        $modePaiement->update($request->validated());

        return response()->json([
            'message' => 'Mode de paiement mis à jour avec succès',
            'data' => new ModePaiementResource($modePaiement)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModePaiement $modePaiement): JsonResponse
    {
        $modePaiement->delete();
        $modePaiement->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        return response()->json([
            'message' => 'Mode de paiement supprimé avec succès'
        ], 200);
    }
}
