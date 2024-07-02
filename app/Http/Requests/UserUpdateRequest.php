<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        return [
            // 'admin_id' => 'nullable|exists:users,id',
            // 'directeur_hotel_id' => 'nullable|exists:users,id',
            'type_client_id' => 'nullable|exists:type_clients,id',
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $this->user,
            'genre' => 'nullable|in:M,F,A',
            'ref_piece' => 'nullable|string|max:255|unique:users,ref_piece,' . $this->user,
            'dateNaissance' => 'nullable|date',
            'statut' => 'nullable|in:standard,invite',
            'role' => 'nullable|in:directeur_hotel,agent,admin',
            'password' => 'nullable|string|min:8|confirmed',

            // Champs d'adresse
            'pays_naissance_id' => 'nullable|exists:pays,id',
            'pays_residence_id' => 'nullable|exists:pays,id',
            'ville' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'rue' => 'nullable|string|max:255',
            'code_postale' => 'nullable|string|max:20',

            // Champs de téléphone
            'telephone' => 'nullable|string|max:20|unique:users,telephone,' . $this->user,
            // 'indicatif_id' => 'nullable|exists:indicatifs,id'
        ];
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
            'admin_id.exists' => 'L\'administrateur spécifié n\'existe pas.',
            'directeur_hotel_id.exists' => 'Le directeur d\'hôtel spécifié n\'existe pas.',
            'type_client_id.exists' => 'Le type de client spécifié n\'existe pas.',

            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser :max caractères.',

            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser :max caractères.',

            'email.string' => 'L\'email doit être une chaîne de caractères.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne peut pas dépasser :max caractères.',
            'email.unique' => 'L\'email est déjà utilisé par un autre utilisateur.',

            'genre.in' => 'Le genre doit être M, F ou A.',

            'ref_piece.string' => 'La référence de pièce doit être une chaîne de caractères.',
            'ref_piece.max' => 'La référence de pièce ne peut pas dépasser :max caractères.',
            'ref_piece.unique' => 'La référence de pièce est déjà utilisée par un autre utilisateur.',

            'dateNaissance.date' => 'La date de naissance doit être une date valide.',

            'statut.in' => 'Le statut doit être standard ou invite.',

            'role.in' => 'Le rôle doit être directeur d\'hôtel, agent ou admin.',

            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

            // Messages d'erreur pour les champs d'adresse
            'pays_naissance_id.exists' => 'Le pays doit être valide',
            'pays_residence_id.exists' => 'L\'indicatif doit être valide',
            'ville.string' => 'La ville doit être une chaîne de caractères.',
            'ville.max' => 'La ville ne peut pas dépasser :max caractères.',
            'region.string' => 'La région doit être une chaîne de caractères.',
            'region.max' => 'La région ne peut pas dépasser :max caractères.',
            'rue.string' => 'La rue doit être une chaîne de caractères.',
            'rue.max' => 'La rue ne peut pas dépasser :max caractères.',
            'code_postale.string' => 'Le code postal doit être une chaîne de caractères.',
            'code_postale.max' => 'Le code postal ne peut pas dépasser :max caractères.',

            // Messages d'erreur pour les champs de téléphone
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser :max caractères.',
            'telephone.unique' => 'Le numéro de téléphone est déjà utilisé par un autre utilisateur.',
            'indicatif_id.exists' => 'L\'indicatif spécifié n\'existe pas.'
        ];
    }
}
