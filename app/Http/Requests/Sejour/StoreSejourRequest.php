<?php

namespace App\Http\Requests\Sejour;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSejourRequest extends FormRequest
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
            'reservation_id' => 'required|exists:reservations,id',
            'dateArrive' => 'required|date',
            // 'dateDepart' => 'nullable|date|after:dateArrive',
            // 'montantHT' => 'nullable|integer',
            // 'montantTTC' => 'nullable|integer',
            // 'montantRecus' => 'nullable|integer',
            // 'mode_paiement_id' => 'nullable|exists:mode_paiements,id',
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
            'reservation_id.required' => 'La réservation est obligatoire.',
            'reservation_id.exists' => 'La réservation sélectionnée est invalide.',
            'dateArrive.required' => 'La date d\'arrivée est obligatoire.',
            'dateArrive.date' => 'La date d\'arrivée doit être une date valide.',
            'dateDepart.date' => 'La date de départ doit être une date valide.',
            'dateDepart.after' => 'La date de départ doit être après la date d\'arrivée.',
            'montantHT.integer' => 'Le montant HT doit être un entier.',
            'montantTTC.integer' => 'Le montant TTC doit être un entier.',
            'montantRecus.integer' => 'Le montant reçu doit être un entier.',
            'mode_paiement_id.exists' => 'Le mode de paiement sélectionné est invalide.',
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
