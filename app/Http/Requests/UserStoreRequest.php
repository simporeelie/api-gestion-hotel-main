<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            // 'admin_id' => 'nullable|exists:users,id',
            // 'directeur_hotel_id' => 'nullable|exists:users,id',
            // 'type_client_id' => 'nullable|exists:type_clients,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:M,F,A',
            'dateNaissance' => 'required|date',
            'statut' => 'nullable|in:standard,invite',
            'role' => 'nullable|in:directeur_hotel,agent,admin',
            'password' => 'nullable|string|min:8|confirmed',

            // Champs d'adresse
            'pays_naissance_id' => 'nullable|exists:pays,id',
            'pays_residence_id' => 'required|exists:pays,id',
            'ville' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'rue' => 'nullable|string|max:255',
            'code_postale' => 'nullable|string|max:20',

            // Champs de téléphone
            'telephone' => 'required|string|max:20',
        ];

        if ($this->filled('role')) {
            $rules['email'] = 'required|string|email|max:255|unique:users';
            $rules['ref_piece'] = 'required|string|max:255|unique:users';
        }

        return $rules;
    }


    public function failedvalidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'message' => 'erreur de validation ',
            'errorsList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'admin_id.exists' => 'L\'admin doit être valide',
            'directeur_hotel_id.exists' => 'Le directeur d\'hôtel doit être valide',
            'type_client_id.exists' => 'Le type de client doit être valide',
            'nom.required' => 'Le nom n\'est pas saisi',
            'prenom.required' => 'Le prénom doit être fourni',
            'email.required' => 'L\'email doit être fourni',
            'email.unique' => 'L\'email est déjà utilisé',
            'genre.required' => 'Le genre doit être fourni',
            'genre.in' => 'Le genre doit être M, F ou A',
            'ref_piece.required' => 'La référence de pièce doit être fournie',
            'dateNaissance.required' => 'La date de naissance doit être fournie',
            'statut.required' => 'Le statut doit être fourni',
            'statut.in' => 'Le statut doit être standard ou invite',
            'role.in' => 'Le rôle doit être directeur d\'hôtel, agent ou admin',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',

            // Messages d'erreur pour les champs d'adresse
            'pays_naissance_id.exists' => 'Le pays doit être valide',
            'pays_residence_id.required' => 'L\'indicatif doit être fourni',
            'pays_residence_id.exists' => 'L\'indicatif doit être valide',
            'ville.string' => 'La ville doit être une chaîne de caractères',
            'ville.max' => 'La ville ne peut pas dépasser 255 caractères',
            'region.string' => 'La région doit être une chaîne de caractères',
            'region.max' => 'La région ne peut pas dépasser 255 caractères',
            'rue.string' => 'La rue doit être une chaîne de caractères',
            'rue.max' => 'La rue ne peut pas dépasser 255 caractères',
            'code_postale.string' => 'Le code postal doit être une chaîne de caractères',
            'code_postale.max' => 'Le code postal ne peut pas dépasser 20 caractères',

            // Messages d'erreur pour les champs de téléphone
            'telephone.required' => 'Le numéro de téléphone doit être fourni',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères',
        ];
    }
}
