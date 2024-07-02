<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pays\StorePaysRequest;
use App\Http\Requests\Pays\UpdatePaysRequest;
use App\Http\Resources\PaysResource;
use App\Models\Pays;
use Illuminate\Http\JsonResponse;

class PaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $pays = Pays::all();
        return response()->json([
            'message' => 'Liste des pays récupérée avec succès',
            'data' => PaysResource::collection($pays)
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
    public function store(StorePaysRequest $request): JsonResponse
    {
        // Les données sont déjà validées par StorePaysRequest
        $data = $request->validated();
        $data['admin_id'] = auth()->user()->id ?? 1;

        $pay = Pays::create($data);

        return response()->json([
            'message' => 'Pays créé avec succès',
            'data' => new PaysResource($pay)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pays $pay): JsonResponse
    {
        return response()->json([
            'message' => 'Pays récupéré avec succès',
            'data' => new PaysResource($pay)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pays $pay)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaysRequest $request, Pays $pay): JsonResponse
    {
        // Les données sont déjà validées par UpdatePaysRequest
        $pay->update($request->validated());

        return response()->json([
            'message' => 'Pays mis à jour avec succès',
            'data' => new PaysResource($pay)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pays $pay): JsonResponse
    {
        $pay->delete();
        $pay->update([
            'supprimer_par_id' => auth()->user()->id ?? 1
        ]);

        return response()->json([
            'message' => 'Pays supprimé avec succès'
        ], 200);
    }
}
