<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OptionChambre;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\OptionChambre\OptionChambreResource;
use App\Http\Requests\OptionChambre\StoreOptionChambreRequest;
use App\Http\Requests\OptionChambre\UpdateOptionChambreRequest;

class OptionChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $optionChambres = $hotel_id ? OptionChambre::where('hotel_id', $hotel_id)->get() : OptionChambre::all();
        return response()->json([
            'message' => 'Liste des options de chambres récupérée avec succès',
            'data' => OptionChambreResource::collection($optionChambres)
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
    public function store(StoreOptionChambreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        $optionChambre = OptionChambre::create($data);
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }

        return response()->json([
            'message' => 'Option de chambre créée avec succès',
            'data' => new OptionChambreResource($optionChambre)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OptionChambre $optionChambre): JsonResponse
    {
        return response()->json([
            'message' => 'Option de chambre récupérée avec succès',
            'data' => new OptionChambreResource($optionChambre)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OptionChambre $optionChambre)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionChambreRequest $request, OptionChambre $optionChambre): JsonResponse
    {
        $optionChambre->update($request->validated());

        return response()->json([
            'message' => 'Option de chambre mise à jour avec succès',
            'data' => new OptionChambreResource($optionChambre)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptionChambre $optionChambre): JsonResponse
    {
        $optionChambre->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        $optionChambre->delete();

        return response()->json([
            'message' => 'Option de chambre supprimée avec succès'
        ], 200);
    }
}
