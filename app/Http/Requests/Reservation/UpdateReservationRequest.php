<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateReservationRequest extends FormRequest
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
            'nb_enfant' => 'sometimes|integer|min:0',
            'nb_adulte' => 'sometimes|integer|min:0',
            'dateArrive' => 'sometimes|date|after_or_equal:today',
            'dateDepart' => 'sometimes|date|after:dateArrive',
            // 'numConfirmation' => 'required|string|max:255|unique:reservations,numConfirmation,' . $this->reservation->id,
            'statut' => 'sometimes|required|in:en_attente,confirmee,en_cours,completee,annulee,no_show,en_attente_de_paiement,payee,modifiee',
            'demandes_particuliere' => 'sometimes|nullable|string',
            // 'client_id' => 'sometimes|exists:users,id',
            // 'agent_reception_id' => 'nullable|exists:users,id',
            // 'charger_suivie_id' => 'required|exists:users,id',
            'motif_reservation_id' => 'sometimes|required|exists:motif_reservations,id',
            // 'supprimer_par_id' => 'nullable|exists:users,id',
            'chambres' => [
                'sometimes',
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
            'nb_enfant.integer' => 'Le nombre d\'enfants doit être un nombre entier.',
            'nb_adulte.integer' => 'Le nombre d\'adultes doit être un nombre entier.',
            'dateArrive.date' => 'La date d\'arrivée doit être une date valide.',
            'dateArrive.after_or_equal' => 'La date d\'arrivée doit être aujourd\'hui ou après.',
            'dateDepart.date' => 'La date de départ doit être une date valide.',
            'dateDepart.after' => 'La date de départ doit être postérieure à la date d\'arrivée.',
            'numConfirmation.string' => 'Le numéro de confirmation doit être une chaîne de caractères.',
            'numConfirmation.max' => 'Le numéro de confirmation ne peut pas dépasser 255 caractères.',
            'numConfirmation.unique' => 'Le numéro de confirmation existe déjà.',
            'statut.required' => 'Le statut de la réservation est obligatoire.',
            'statut.in' => 'Le statut de la réservation est invalide.',
            'demandes_particuliere.string' => 'Les demandes particulières doivent être une chaîne de caractères.',
            'client_id.exists' => 'Le client sélectionné est invalide.',
            'agent_reception_id.exists' => 'L\'agent de réception sélectionné est invalide.',
            'charger_suivie_id.exists' => 'L\'agent chargé du suivi sélectionné est invalide.',
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
