<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReservationRequest extends FormRequest
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
            'nb_enfant' => 'required|integer|min:0',
            'nb_adulte' => 'required|integer|min:0',
            'dateArrive' => 'required|date|after_or_equal:today',
            'dateDepart' => 'required|date|after:dateArrive',
            // 'numConfirmation' => 'required|string|max:255|unique:reservations,numConfirmation',
            'type' => 'sometimes|in:appel,en_ligne,presentiel',
            'demandes_particuliere' => 'nullable|string',
            'client_id' => 'required|exists:users,id',
            // 'agent_reception_id' => 'nullable|exists:users,id',
            // 'charger_suivie_id' => 'required|exists:users,id',
            'motif_reservation_id' => 'required|exists:motif_reservations,id',
            // 'supprimer_par_id' => 'nullable|exists:users,id',
            'chambres' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (!$this->validateArrayElementsExist($value, 'chambres')) {
                        $fail('Les éléments du champ contenus sont invalides.');
                    }
                    if (empty($value)) {
                        $fail('Une réservation concerne au moins une chambre.');
                    }
                }
            ],
        ];
    }

    /**
     * Validate that each element in the array exists in the corresponding table.
     *
     * @param array $values
     * @param string $table
     * @return bool
     */
    protected function validateArrayElementsExist(array $values, string $table): bool
    {
        // Assuming the $table corresponds to the actual table name in the database
        foreach ($values as $value) {
            if (!DB::table($table)->where('id', $value)->exists()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nb_enfant.required' => 'Le nombre d\'enfants est obligatoire.',
            'nb_enfant.integer' => 'Le nombre d\'enfants doit être un nombre entier.',
            'nb_adulte.required' => 'Le nombre d\'adultes est obligatoire.',
            'nb_adulte.integer' => 'Le nombre d\'adultes doit être un nombre entier.',
            'dateArrive.required' => 'La date d\'arrivée est obligatoire.',
            'dateArrive.date' => 'La date d\'arrivée doit être une date valide.',
            'dateArrive.after_or_equal' => 'La date d\'arrivée doit être aujourd\'hui ou après.',
            'dateDepart.required' => 'La date de départ est obligatoire.',
            'dateDepart.date' => 'La date de départ doit être une date valide.',
            'dateDepart.after' => 'La date de départ doit être postérieure à la date d\'arrivée.',
            'numConfirmation.required' => 'Le numéro de confirmation est obligatoire.',
            'numConfirmation.string' => 'Le numéro de confirmation doit être une chaîne de caractères.',
            'numConfirmation.max' => 'Le numéro de confirmation ne peut pas dépasser 255 caractères.',
            'numConfirmation.unique' => 'Le numéro de confirmation existe déjà.',
            'type.sometimes' => 'Le type de réservation est parfois obligatoire.',
            'type.in' => 'Le type de réservation est invalide.',
            'demandes_particuliere.string' => 'Les demandes particulières doivent être une chaîne de caractères.',
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.exists' => 'Le client sélectionné est invalide.',
            'agent_reception_id.exists' => 'L\'agent de réception sélectionné est invalide.',
            'chambres.required' => 'Les chambres sont obligatoires.',
            'charger_suivie_id.exists' => 'L\'agent chargé du suivi sélectionné est invalide.',
            'motif_reservation_id.required' => 'Le motif de réservation est obligatoire.',
            'motif_reservation_id.exists' => 'Le motif de réservation sélectionné est invalide.',
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
