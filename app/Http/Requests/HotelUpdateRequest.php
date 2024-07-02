<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HotelUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorie_hotel_id' => 'sometimes|exists:categorie_hotels,id',
            'directeur_hotel_id' => 'sometimes|exists:users,id',
            'libelle' => 'sometimes|string|max:255',
            'photo' => 'sometimes|nullable|max:2048',
            'emplacement' => "sometimes|string|max:255|unique:hotels,emplacement,". $this->hotel,
            'email' => "sometimes|email|max:255|unique:hotels,email,". $this->hotel,
            'site_web' => "sometimes|nullable|string|max:255|unique:hotels,site_web,". $this->hotel,
            'telephone' => "sometimes|string|max:255|unique:hotels,telephone,". $this->hotel,
            'pays_id' => 'sometimes|exists:pays,id',
            'ville' => 'sometimes|string|max:255',
            'region' => 'sometimes|string|max:255',
            'rue' => 'sometimes|string|max:255',
            'code_postale' => "sometimes|string|max:20|unique:hotels,code_postale,". $this->hotel,
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erreur de validation',
            'errors' => $validator->errors()
        ], 422));
    }

    public function messages(): array
    {
        return [
            'categorie_hotel_id.exists' => 'La catégorie d\'hôtel sélectionnée est invalide.',
            'directeur_hotel_id.exists' => 'Le directeur d\'hôtel sélectionné est invalide.',
            'libelle.string' => 'Le libellé de l\'hôtel doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé de l\'hôtel ne peut pas dépasser 255 caractères.',
            'photo.max' => 'La photo ne peut pas dépasser 2048 caractères.',
            'emplacement.string' => 'L\'emplacement de l\'hôtel doit être une chaîne de caractères.',
            'emplacement.max' => 'L\'emplacement de l\'hôtel ne peut pas dépasser 255 caractères.',
            'emplacement.unique' => 'L\'emplacement de l\'hôtel doit être unique.',
            'email.email' => 'L\'email de l\'hôtel doit être une adresse email valide.',
            'email.max' => 'L\'email de l\'hôtel ne peut pas dépasser 255 caractères.',
            'email.unique' => 'L\'email de l\'hôtel doit être unique.',
            'site_web.string' => 'Le site web de l\'hôtel doit être une chaîne de caractères.',
            'site_web.max' => 'Le site web de l\'hôtel ne peut pas dépasser 255 caractères.',
            'site_web.unique' => 'Le site web de l\'hôtel doit être unique.',
            'telephone.string' => 'Le numéro de téléphone de l\'hôtel doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone de l\'hôtel ne peut pas dépasser 255 caractères.',
            'telephone.unique' => 'Le numéro de téléphone de l\'hôtel doit être unique.',
            'pays_id.exists' => 'Le pays sélectionné est invalide.',
            'ville.string' => 'La ville de l\'hôtel doit être une chaîne de caractères.',
            'ville.max' => 'La ville de l\'hôtel ne peut pas dépasser 255 caractères.',
            'region.string' => 'La région de l\'hôtel doit être une chaîne de caractères.',
            'region.max' => 'La région de l\'hôtel ne peut pas dépasser 255 caractères.',
            'rue.string' => 'La rue de l\'hôtel doit être une chaîne de caractères.',
            'rue.max' => 'La rue de l\'hôtel ne peut pas dépasser 255 caractères.',
            'code_postale.string' => 'Le code postal de l\'hôtel doit être une chaîne de caractères.',
            'code_postale.max' => 'Le code postal de l\'hôtel ne peut pas dépasser 20 caractères.',
            'code_postale.unique' => 'Le code postal de l\'hôtel doit être unique.',
        ];
    }
}
