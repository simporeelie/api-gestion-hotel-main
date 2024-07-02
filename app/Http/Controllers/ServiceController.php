<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $services = $hotel_id ? Service::where('hotel_id', $hotel_id)->get() : Service::all();
        return response()->json([
            'message' => 'Liste des services récupérée avec succès',
            'data' => ServiceResource::collection($services)
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
    public function store(StoreServiceRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        } else {
            $user = User::findOrFail(2);
            $data['hotel_id'] = auth()->user()->hotel->id ?? $user->hotel->id;
        }
        $service = Service::create($data);

        return response()->json([
            'message' => 'Service créé avec succès',
            'data' => new ServiceResource($service)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): JsonResponse
    {
        return response()->json([
            'message' => 'Service récupéré avec succès',
            'data' => new ServiceResource($service)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): JsonResponse
    {
        $service->update($request->validated());

        return response()->json([
            'message' => 'Service mis à jour avec succès',
            'data' => new ServiceResource($service)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): JsonResponse
    {
        $service->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        $service->delete();

        return response()->json([
            'message' => 'Service supprimé avec succès'
        ], 200);
    }
}
