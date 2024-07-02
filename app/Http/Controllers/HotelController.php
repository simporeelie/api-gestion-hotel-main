<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\HotelUpdateRequest;
use App\Http\Resources\Hotel\HotelResource;

class HotelController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $hotels = Hotel::all();
            return response()->json([
                'message' => 'success',
                'data' => HotelResource::collection($hotels),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur interne du serveur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(HotelStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data) {
            try {
                if (isset($data['photo'])) {
                    $photoPath = $this->uploadPhoto($data['photo']);
                    if (!$photoPath) {
                        return response()->json([
                            'message' => 'Erreur lors de l\'upload de la photo',
                        ], 500);
                    }
                    $data['photo'] = $photoPath;
                }else{
                   $data['photo'] = fake()->imageUrl(640, 480, 'hotels');
                }

                $hotel = Hotel::create($data);

                return response()->json([
                    'message' => 'Hôtel créé avec succès',
                    'data' => new HotelResource($hotel),
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Échec de la création de l\'hôtel',
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
    }

    private function uploadPhoto($photo)
    {
        $photoName = 'hotel/' . time() . '.jpg';
        if (Storage::put($photoName, $photo)) {
            return $photoName;
        }
        return null;
    }

    public function show($id): JsonResponse
    {
        try {
            $hotel = Hotel::findOrFail($id);
            return response()->json([
                'message' => 'success',
                'data' => new HotelResource($hotel),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hôtel non trouvé',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(HotelUpdateRequest $request, $id): JsonResponse
    {
        $hotel = Hotel::findOrFail($id);

        DB::beginTransaction();

        try {
            $hotel->update($request->validated());

            DB::commit();

            return response()->json([
                'message' => 'Hôtel mis à jour avec succès',
                'data' => new HotelResource($hotel),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la mise à jour de l\'hôtel',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->delete()) {
            $hotel->update([
                'supprimer_par_id' => auth()->user()->id ?? 2
            ]);
            return response()->json([
                'message' => 'Hôtel supprimé avec succès',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la suppression de l\'hôtel',
            ], 500);
        }
    }
}
