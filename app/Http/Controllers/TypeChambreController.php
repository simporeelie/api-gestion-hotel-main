<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TypeChambre;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TypeChambre\TypeChambreResource;
use App\Http\Requests\TypeChambre\StoreTypeChambreRequest;
use App\Http\Requests\TypeChambre\UpdateTypeChambreRequest;

class TypeChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $typeChambres = $hotel_id ? TypeChambre::where('hotel_id', $hotel_id)->get() :  TypeChambre::all();
        return response()->json([
            'message' => 'Liste des types de chambres récupérée avec succès',
            'data' => TypeChambreResource::collection($typeChambres)
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
    public function store(StoreTypeChambreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }
        $typeChambre = TypeChambre::create($data);

        return response()->json([
            'message' => 'Type de chambre créé avec succès',
            'data' => new TypeChambreResource($typeChambre)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeChambre $typeChambre): JsonResponse
    {
        return response()->json([
            'message' => 'Type de chambre récupéré avec succès',
            'data' => new TypeChambreResource($typeChambre)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeChambre $typeChambre)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeChambreRequest $request, TypeChambre $typeChambre): JsonResponse
    {

        $typeChambre->update($request->validated());

        return response()->json([
            'message' => 'Type de chambre mis à jour avec succès',
            'data' => new TypeChambreResource($typeChambre)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeChambre $typeChambre): JsonResponse
    {
        $typeChambre->update(['supprimer_par_id' => auth()->user()->id ?? 2]);
        $typeChambre->delete();

        return response()->json([
            'message' => 'Type de chambre supprimé avec succès'
        ], 200);
    }
}
