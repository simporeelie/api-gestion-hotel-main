<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HotelStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorie_hotel_id' => 'nullable|exists:categorie_hotels,id',
            'directeur_hotel_id' => 'nullable|exists:users,id',
            'libelle' => 'required|string|max:255',
            'photo' => 'nullable|max:2048',
            'emplacement' => 'required|string|max:255|unique:hotels,emplacement',
            'email' => 'required|email|max:255|unique:hotels,email',
            'site_web' => 'nullable|string|max:255|unique:hotels,site_web',
            'telephone' => 'required|string|max:255|unique:hotels,telephone',
            'pays_id' => 'required|exists:pays,id',
            'ville' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'rue' => 'required|string|max:255',
            'code_postale' => 'required|string|max:20|unique:hotels,code_postale',
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
            'libelle.required' => 'Le libellé de l\'hôtel est requis.',
            'libelle.string' => 'Le libellé de l\'hôtel doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé de l\'hôtel ne peut pas dépasser 255 caractères.',
            'photo.max' => 'La photo ne peut pas dépasser 2048 caractères.',
            'emplacement.required' => 'L\'emplacement de l\'hôtel est requis.',
            'emplacement.string' => 'L\'emplacement de l\'hôtel doit être une chaîne de caractères.',
            'emplacement.max' => 'L\'emplacement de l\'hôtel ne peut pas dépasser 255 caractères.',
            'email.required' => 'L\'email de l\'hôtel est requis.',
            'email.email' => 'L\'email de l\'hôtel doit être une adresse email valide.',
            'email.max' => 'L\'email de l\'hôtel ne peut pas dépasser 255 caractères.',
            'site_web.string' => 'Le site web de l\'hôtel doit être une chaîne de caractères.',
            'site_web.max' => 'Le site web de l\'hôtel ne peut pas dépasser 255 caractères.',
            'telephone.required' => 'Le numéro de téléphone de l\'hôtel est requis.',
            'telephone.string' => 'Le numéro de téléphone de l\'hôtel doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone de l\'hôtel ne peut pas dépasser 255 caractères.',
            'pays_id.required' => 'Le pays de l\'hôtel est requis.',
            'pays_id.exists' => 'Le pays sélectionné est invalide.',
            'ville.required' => 'La ville de l\'hôtel est requise.',
            'ville.string' => 'La ville de l\'hôtel doit être une chaîne de caractères.',
            'ville.max' => 'La ville de l\'hôtel ne peut pas dépasser 255 caractères.',
            'region.required' => 'La région de l\'hôtel est requise.',
            'region.string' => 'La région de l\'hôtel doit être une chaîne de caractères.',
            'region.max' => 'La région de l\'hôtel ne peut pas dépasser 255 caractères.',
            'rue.required' => 'La rue de l\'hôtel est requise.',
            'rue.string' => 'La rue de l\'hôtel doit être une chaîne de caractères.',
            'rue.max' => 'La rue de l\'hôtel ne peut pas dépasser 255 caractères.',
            'code_postale.required' => 'Le code postal de l\'hôtel est requis.',
            'code_postale.string' => 'Le code postal de l\'hôtel doit être une chaîne de caractères.',
            'code_postale.max' => 'Le code postal de l\'hôtel ne peut pas dépasser 20 caractères.',
        ];
    }
}

