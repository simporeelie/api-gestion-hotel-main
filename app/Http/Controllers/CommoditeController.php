<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Commodite;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Commodite\CommoditeResource;
use App\Http\Requests\Commodite\StoreCommoditeRequest;
use App\Http\Requests\Commodite\UpdateCommoditeRequest;

class CommoditeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $commodites = $hotel_id ? Commodite::where('hotel_id', $hotel_id)->get() : Commodite::all();
        return response()->json([
            'message' => 'Liste des commodités récupérée avec succès',
            'data' => CommoditeResource::collection($commodites)
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
    public function store(StoreCommoditeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;

        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }

        $commodite = Commodite::create($data);

        return response()->json([
            'message' => 'Commodité créée avec succès',
            'data' => new CommoditeResource($commodite)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Commodite $commodite): JsonResponse
    {
        return response()->json([
            'message' => 'Commodité récupérée avec succès',
            'data' => new CommoditeResource($commodite)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commodite $commodite)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommoditeRequest $request, Commodite $commodite): JsonResponse
    {
        $commodite->update($request->validated());

        return response()->json([
            'message' => 'Commodité mise à jour avec succès',
            'data' => new CommoditeResource($commodite)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commodite $commodite): JsonResponse
    {
        $commodite->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);
        $commodite->delete();

        return response()->json([
            'message' => 'Commodité supprimée avec succès'
        ], 200);
    }
}
