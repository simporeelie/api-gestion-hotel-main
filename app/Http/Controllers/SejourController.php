<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sejour;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Sejour\SejourResource;
use App\Http\Requests\Sejour\StoreSejourRequest;
use App\Http\Requests\Sejour\UpdateSejourRequest;

class SejourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $sejours = $hotel_id ? Sejour::where('hotel_id', $hotel_id)->get() : Sejour::all();
        return response()->json([
            'message' => 'Liste des séjours récupérée avec succès',
            'data' => SejourResource::collection($sejours)
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
    public function store(StoreSejourRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['agent_id'] = auth()->user()->id ?? 13;

        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(13);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }

        $sejour = Sejour::create($data);

        return response()->json([
            'message' => 'Séjour créé avec succès',
            'data' => new SejourResource($sejour)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sejour $sejour): JsonResponse
    {
        return response()->json([
            'message' => 'Séjour récupéré avec succès',
            'data' => new SejourResource($sejour)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sejour $sejour)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSejourRequest $request, Sejour $sejour): JsonResponse
    {
        $sejour->update($request->validated());

        return response()->json([
            'message' => 'Séjour mis à jour avec succès',
            'data' => new SejourResource($sejour)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sejour $sejour): JsonResponse
    {
        $sejour->delete();
        $sejour->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        return response()->json([
            'message' => 'Séjour supprimé avec succès'
        ], 200);
    }
}
