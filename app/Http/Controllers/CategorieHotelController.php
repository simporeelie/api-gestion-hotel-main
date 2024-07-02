<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorieHotel;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategorieHotel\CategorieHotelResource;
use App\Http\Requests\CategorieHotel\StoreCategorieHotelRequest;
use App\Http\Requests\CategorieHotel\UpdateCategorieHotelRequest;

class CategorieHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categorieHotels = CategorieHotel::all();

        return response()->json([
            'message' => 'Liste des catégories d\'hôtels récupérée avec succès',
            'data' => CategorieHotelResource::collection($categorieHotels)
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
    public function store(StoreCategorieHotelRequest $request): JsonResponse
    {
        // Les données sont déjà validées par StoreCategorieRequest
        $data = $request->validated();
        $data['admin_id'] = auth()->user()->id ?? 1;
        $categorieHotel = CategorieHotel::create($data);

        return response()->json([
            'message' => 'Catégorie d\'hôtel créée avec succès',
            'data' => new CategorieHotelResource($categorieHotel)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategorieHotel $categorie_hotel): JsonResponse
    {
        return response()->json([
            'message' => 'Catégorie d\'hôtel récupérée avec succès',
            'data' =>  new CategorieHotelResource($categorie_hotel)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategorieHotel $categorie_hotel)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieHotelRequest $request, CategorieHotel $categorie_hotel): JsonResponse
    {
        // dd($request->validated());
        // Les données sont déjà validées par UpdateCategorieRequest
        $categorie_hotel->update($request->validated());

        return response()->json([
            'message' => 'Catégorie d\'hôtel mise à jour avec succès',
            'data' => new CategorieHotelResource($categorie_hotel)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategorieHotel $categorie_hotel): JsonResponse
    {
        $categorie_hotel->delete();

        return response()->json([
            'message' => 'Catégorie d\'hôtel supprimée avec succès'
        ], 200);
    }
}
