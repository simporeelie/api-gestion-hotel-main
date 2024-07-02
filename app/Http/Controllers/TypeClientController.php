<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TypeClient;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TypeClient\TypeClientResource;
use App\Http\Requests\TypeClient\StoreTypeClientRequest;
use App\Http\Requests\TypeClient\UpdateTypeClientRequest;

class TypeClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $typeClients = $hotel_id ? TypeClient::where('hotel_id', $hotel_id)->get() : TypeClient::all();
        return response()->json([
            'message' => 'Liste des types de clients récupérée avec succès',
            'data' => TypeClientResource::collection($typeClients)
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
    public function store(StoreTypeClientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }

        $typeClient = TypeClient::create($data);

        return response()->json([
            'message' => 'Type de client créé avec succès',
            'data' => new TypeClientResource($typeClient)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeClient $typeClient): JsonResponse
    {
        return response()->json([
            'message' => 'Type de client récupéré avec succès',
            'data' => new TypeClientResource($typeClient)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeClient $typeClient)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeClientRequest $request, TypeClient $typeClient): JsonResponse
    {
        $typeClient->update($request->validated());

        return response()->json([
            'message' => 'Type de client mis à jour avec succès',
            'data' => new TypeClientResource($typeClient)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeClient $typeClient): JsonResponse
    {
        $typeClient->delete();

        $typeClient->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        return response()->json([
            'message' => 'Type de client supprimé avec succès'
        ], 200);
    }
}
