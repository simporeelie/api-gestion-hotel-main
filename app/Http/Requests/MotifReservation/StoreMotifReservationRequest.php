<?php

namespace App\Http\Requests\MotifReservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMotifReservationRequest extends FormRequest
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
            'libelle' => 'required|string|max:255',
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
