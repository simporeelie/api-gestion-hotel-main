<?php

namespace App\Http\Requests\Chambre;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreChambreRequest extends FormRequest
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
            'type_chambre_id' => 'required|exists:type_chambres,id',
            'disponibilite' => 'required|boolean',
            'taille' => 'required|integer|min:0',
            // 'numero' => 'sometimes|integer|min:0|unique:chambres,numero',
            'contenus' => [
                'sometimes',
                'array',
                function ($attribute, $value, $fail) {
                    if (!$this->validateArrayElementsExist($value, 'contenu_chambres')) {
                        $fail('Les éléments du champ contenus sont invalides.');
                    }
                }
            ],
            'options' => [
                'sometimes',
                'array',
                function ($attribute, $value, $fail) {
                    if (!$this->validateArrayElementsExist($value, 'option_chambres')) {
                        $fail('Les éléments du champ options sont invalides.');
                    }
                }
            ],
            'type' => [
                'sometimes',
                'array',
                function ($attribute, $value, $fail) {
                    if (!$this->validateArrayElementsExist($value, 'type_chambres')) {
                        $fail('Les éléments du champ type sont invalides.');
                    }
                }
            ],
            'equipements' => [
                'sometimes',
                'array',
                function ($attribute, $value, $fail) {
                    if (!$this->validateArrayElementsExist($value, 'equipement_chambres')) {
                        $fail('Les éléments du champ équipements sont invalides.');
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
            'type_chambre_id.required' => 'Le champ type de chambre est obligatoire.',
            'type_chambre_id.exists' => 'Le type de chambre sélectionné est invalide.',
            'disponibilite.required' => 'Le champ disponibilité est obligatoire.',
            'disponibilite.boolean' => 'Le champ disponibilité doit être vrai ou faux.',
            'taille.required' => 'Le champ taille est obligatoire.',
            'taille.integer' => 'Le champ taille doit être un entier.',
            'taille.min' => 'Le champ taille doit être au moins 0.',
            'numero.integer' => 'Le champ numéro doit être un entier.',
            'numero.min' => 'Le champ numéro doit être au moins 0.',
            'numero.unique' => 'Le numéro de chambre est déjà utilisé.',
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
