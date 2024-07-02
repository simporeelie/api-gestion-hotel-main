<?php

namespace App\Http\Requests\TypeChambre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTypeChambreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ou selon votre logique d'autorisation
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'libelle' => 'required|string|max:255',
            'prix' => 'required|integer|min:0',
            'nb_enfant' => 'required|integer|min:0',
            'nb_adulte' => 'required|integer|min:0',
            'isVip' => 'boolean',
            // 'directeur_hotel_id' => 'required|exists:users,id',
            // 'supprimer_par_id' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'libelle.required' => 'Le champ libellé est obligatoire.',
            'libelle.string' => 'Le champ libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le champ libellé ne peut pas dépasser 255 caractères.',
            'prix.required' => 'Le champ prix est obligatoire.',
            'prix.integer' => 'Le champ prix doit être un entier.',
            'prix.min' => 'Le champ prix doit être au moins 0.',
            'nb_enfant.required' => 'Le champ nombre d\'enfants est obligatoire.',
            'nb_enfant.integer' => 'Le champ nombre d\'enfants doit être un entier.',
            'nb_enfant.min' => 'Le champ nombre d\'enfants doit être au moins 0.',
            'nb_adulte.required' => 'Le champ nombre d\'adultes est obligatoire.',
            'nb_adulte.integer' => 'Le champ nombre d\'adultes doit être un entier.',
            'nb_adulte.min' => 'Le champ nombre d\'adultes doit être au moins 0.',
            'isVip.boolean' => 'Le champ VIP doit être un booléen.',
            'directeur_hotel_id.required' => 'Le champ directeur d\'hôtel est obligatoire.',
            'directeur_hotel_id.exists' => 'Le directeur d\'hôtel sélectionné est invalide.',
            'supprimer_par_id.exists' => 'L\'utilisateur qui supprime est invalide.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }
}
