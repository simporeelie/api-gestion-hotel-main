<?php

namespace App\Http\Requests\Pays;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePaysRequest extends FormRequest
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
            'libelle' => 'sometimes|string|max:255|unique:pays,libelle,' . $this->pay->id,
            'indicatif' => 'sometimes|string|max:10',
            'drapeau' => 'sometimes|string|max:255',
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
            'libelle.unique' => 'Le libellé existe déjà.',
            'indicatif.required' => 'Le champ indicatif est obligatoire.',
            'indicatif.string' => 'Le champ indicatif doit être une chaîne de caractères.',
            'indicatif.max' => 'Le champ indicatif ne peut pas dépasser 10 caractères.',
            'drapeau.required' => 'Le champ drapeau est obligatoire.',
            'drapeau.string' => 'Le champ drapeau doit être une chaîne de caractères.',
            'drapeau.max' => 'Le champ drapeau ne peut pas dépasser 255 caractères.',
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
