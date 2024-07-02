<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MotifReservation;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\MotifReservation\MotifReservationResource;
use App\Http\Requests\MotifReservation\StoreMotifReservationRequest;
use App\Http\Requests\MotifReservation\UpdateMotifReservationRequest;

class MotifReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $motifs = $hotel_id ? MotifReservation::where('hotel_id', $hotel_id)->get() : MotifReservation::all();
        return response()->json([
            'message' => 'Liste des motifs de réservation récupérée avec succès',
            'data' => MotifReservationResource::collection($motifs)
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
    public function store(StoreMotifReservationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }
        $motif = MotifReservation::create($data);

        return response()->json([
            'message' => 'Motif de réservation créé avec succès',
            'data' => new MotifReservationResource($motif)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MotifReservation $motifReservation): JsonResponse
    {
        return response()->json([
            'message' => 'Motif de réservation récupéré avec succès',
            'data' => new MotifReservationResource($motifReservation)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MotifReservation $motifReservation)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMotifReservationRequest $request, MotifReservation $motifReservation): JsonResponse
    {
        $motifReservation->update($request->validated());

        return response()->json([
            'message' => 'Motif de réservation mis à jour avec succès',
            'data' => new MotifReservationResource($motifReservation)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MotifReservation $motifReservation): JsonResponse
    {
        $motifReservation->delete();
        $motifReservation->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        return response()->json([
            'message' => 'Motif de réservation supprimé avec succès'
        ], 200);
    }
}
