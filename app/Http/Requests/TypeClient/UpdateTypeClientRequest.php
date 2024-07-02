<?php

namespace App\Http\Requests\TypeClient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTypeClientRequest extends FormRequest
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
            'libelle' => 'sometimes|in:occasionnels,fideles,VIP',
            'nbReservation' => 'sometimes|integer|min:1',
            'operateur' => 'sometimes|in:>=,<=',
            'frequense' => 'sometimes|integer|min:1',
            'periode' => 'sometimes|in:jour,semaine,mois,annee',
            // 'directeur_hotel_id' => 'sometimes|exists:users,id',
            // 'supprimer_par_id' => 'sometimes|exists:users,id',
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
            // 'libelle.required' => 'Le champ libellé est obligatoire.',
            'libelle.in' => 'Le champ libellé doit être l\'une des valeurs suivantes : occasionnels, fideles, VIP.',
            // 'nbReservation.required' => 'Le champ nombre de réservations est obligatoire.',
            'nbReservation.integer' => 'Le champ nombre de réservations doit être un nombre entier.',
            'nbReservation.min' => 'Le champ nombre de réservations doit être au moins 1.',
            // 'operateur.required' => 'Le champ opérateur est obligatoire.',
            'operateur.in' => 'Le champ opérateur doit être >= ou <=.',
            // 'frequense.required' => 'Le champ fréquence est obligatoire.',
            'frequense.integer' => 'Le champ fréquence doit être un nombre entier.',
            'frequense.min' => 'Le champ fréquence doit être au moins 1.',
            // 'periode.required' => 'Le champ période est obligatoire.',
            'periode.in' => 'Le champ période doit être l\'une des valeurs suivantes : jour, semaine, mois, annee.',
            // 'directeur_hotel_id.required' => 'Le champ directeur d\'hôtel est obligatoire.',
            // 'directeur_hotel_id.exists' => 'Le directeur d\'hôtel sélectionné est invalide.',
            // 'supprimer_par_id.exists' => 'L\'utilisateur qui supprime est invalide.',
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
