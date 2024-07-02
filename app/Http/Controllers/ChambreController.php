<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chambre\StoreChambreRequest;
use App\Http\Requests\Chambre\UpdateChambreRequest;
use App\Http\Resources\Chambre\ChambreResource;
use App\Models\Chambre;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');

        $chambres = $hotel_id
            ? Chambre::where('hotel_id', $hotel_id)->get()
            : Chambre::all();

        return response()->json([
            'message' => 'Liste des chambres récupérée avec succès',
            'data' => ChambreResource::collection($chambres)
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
    public function store(StoreChambreRequest $request): JsonResponse
    {
        // dd($request->validated());
        $data = $request->validated();
        $data['directeur_hotel_id'] = auth()->user()->id ?? 2;
        // $data['numero'] = auth()->user()->chambres->count() + 1;
        $data['numero'] = User::findOrFail(2)->chambres->count() + 1;

        if (request()->has('hotel_id')) {
            $data['hotel_id'] = request()->input('hotel_id');
        }else{
            $data['hotel_id'] = auth()->user()->hotel->id ?? 2;
        }

        if (isset($data['equipements'])) {
            $otherData['equipements'] = $data['equipements'];
            unset($data['equipements']);
        }


        if (isset($data['contenus'])) {
            $otherData['contenus'] = $data['contenus'];
            unset($data['contenus']);
        }


        if (isset($data['options'])) {
            $otherData['options'] = $data['options'];
            unset($data['options']);
        }

        $chambre = Chambre::create($data);

        if (isset($otherData['equipements']))
            $chambre->equipements()->attach($otherData['equipements']);

        if (isset($otherData['contenus']))
            $chambre->contenus()->attach($otherData['contenus']);

        if (isset($otherData['options']))
            $chambre->options()->attach($otherData['options']);

        return response()->json([
            'message' => 'Chambre créée avec succès',
            'data' => new ChambreResource($chambre)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chambre $chambre): JsonResponse
    {
        return response()->json([
            'message' => 'Chambre récupérée avec succès',
            'data' => new ChambreResource($chambre)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chambre $chambre)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChambreRequest $request, Chambre $chambre): JsonResponse
    {
        // dd($request->validated());
        $data = $request->validated();

        if (isset($data['equipements'])) {
            $otherData['equipements'] = $data['equipements'];
            unset($data['equipements']);
        }


        if (isset($data['contenus'])) {
            $otherData['contenus'] = $data['contenus'];
            unset($data['contenus']);
        }


        if (isset($data['options'])) {
            $otherData['options'] = $data['options'];
            unset($data['options']);
        }

        $chambre->update($data);

        if (isset($otherData['equipements']))
            $chambre->equipements()->sync($otherData['equipements']);

        if (isset($otherData['contenus']))
            $chambre->contenus()->sync($otherData['contenus']);

        if (isset($otherData['options']))
            $chambre->options()->sync($otherData['options']);

        return response()->json([
            'message' => 'Chambre mise à jour avec succès',
            'data' => new ChambreResource($chambre)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chambre $chambre): JsonResponse
    {
        $chambre->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        $chambre->delete();

        return response()->json([
            'message' => 'Chambre supprimée avec succès'
        ], 200);
    }

    public function tauxOccupation() {
        return response()->json([
            'message' => 'Sucess',
            'data' => Chambre::tauxOcupation()
        ]);
    }
}
