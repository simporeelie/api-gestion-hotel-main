<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Adresse;
use App\Models\Telephone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class UserController extends Controller
{

    public function index(Request $request)
    {
        try {
            $hotel_id = $request->input('hotel_id');
            $roles = $request->query('role'); // Retrieve the 'role' parameter value
            $query = User::query(); // Initialize the query builder

            // Check if the 'role' parameter is present and non-empty
            if ($roles) {
                $roleArray = explode(',', $roles);

                foreach ($roleArray as $role) {
                    switch ($role) {
                        case 'admin':
                            User::getAdminBuilder($query);
                            break;
                        case 'directeur_hotel':
                            User::getDirecteurHotelBuilder($query);
                            break;
                        case 'agent':
                            User::getAgentBuilder($query);
                            break;
                        case 'client':
                            User::getClientBuilder($query);
                            break;
                    }
                }
            }

            // Filter by hotel_id if provided
            if ($hotel_id) {
                $query->where('hotel_id', $hotel_id);
            }

            // Get the users based on the query or all users if no roles are specified
            $users = UserResource::collection($query->get());

            return response()->json([
                'message' => 'Liste de tous les utilisateurs',
                'data' => $users
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur interne du serveur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function store(UserStoreRequest $request)
    {
        $user = User::withTrashed()
            ->where('email', request('email'))
            ->orWhere('ref_piece', request('ref_piece'))
            ->orWhere('telephone', request('telephone'))
            ->first();

        if (!$user) {
            return $this->storeUser();
        }

        if ($user->deleted_at) {
            $user->restore();
            $user->save();
        }

        if ($request->role === null) {
            return $this->update(new UserUpdateRequest(), $user->id);
        } else {
            return $this->storeUser();
        }
    }

    private function storeUser()
    {
        DB::beginTransaction();

        try {

            $userData = User::getUserDataInRequest();
            $additionalData = request('role') === null ? User::getClientDataInRequest() : User::getEmployerDataInRequest();
            $userData = array_merge($userData, $additionalData);

            $user = User::create($userData);

            DB::commit();

            return response()->json([
                'message' => 'Utilisateur créé avec succès',
                'data' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Échec de la création de l\'utilisateur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'message' => 'Informations de l\'utilisateur',
                'data' => new UserResource($user),
            ]);
        } catch (NotFoundResourceException $e) {
            return response()->json([
                'message' => 'Utilisateur non trouvé',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur interne du serveur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {

            $userData = User::getUserDataInRequest();
            $additionalData = request('role') === null ? User::getClientDataInRequest() : User::getEmployerDataInRequest();
            $userData = array_merge($userData, $additionalData);

            $user->update($userData);

            DB::commit();

            return response()->json([
                'message' => 'L\'utilisateur a été modifié',
                'data' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Erreur interne du serveur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            $user->update([
                'supprimer_par_id' => auth()->user()->id ?? 2
            ]);
            return response()->json([
                'message' => 'Utilisateur supprimé avec succès'
            ]);
        } else {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la suppression de l\'utilisateur'
            ], 500);
        }
    }
}
