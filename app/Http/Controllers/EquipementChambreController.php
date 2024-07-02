<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EquipementChambre;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EquipementChambre\EquipementChambreResource;
use App\Http\Requests\EquipementChambre\StoreEquipementChambreRequest;
use App\Http\Requests\EquipementChambre\UpdateEquipementChambreRequest;

class EquipementChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');

        $equipementChambres = $hotel_id ? EquipementChambre::where('hotel_id', $hotel_id)->get() : EquipementChambre::all();
        return response()->json([
            'message' => 'Liste des équipements de chambres récupérée avec succès',
            'data' => EquipementChambreResource::collection($equipementChambres)
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
    public function store(StoreEquipementChambreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        $equipementChambre = EquipementChambre::create($data);
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }
        return response()->json([
            'message' => 'Équipement de chambre créé avec succès',
            'data' => new EquipementChambreResource($equipementChambre)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipementChambre $equipementChambre): JsonResponse
    {
        return response()->json([
            'message' => 'Équipement de chambre récupéré avec succès',
            'data' => new EquipementChambreResource($equipementChambre)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipementChambre $equipementChambre)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipementChambreRequest $request, EquipementChambre $equipementChambre): JsonResponse
    {
        $equipementChambre->update($request->validated());

        return response()->json([
            'message' => 'Équipement de chambre mis à jour avec succès',
            'data' => new EquipementChambreResource($equipementChambre)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipementChambre $equipementChambre): JsonResponse
    {
        $equipementChambre->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        $equipementChambre->delete();

        return response()->json([
            'message' => 'Équipement de chambre supprimé avec succès'
        ], 200);
    }
}
