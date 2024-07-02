<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTypeClientRequest extends FormRequest
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
            'libelle' => 'required|in:occasionnels,fideles,VIP',
            'nbReservation' => 'required|integer|min:0',
            'operateur' => 'required|string|in:>=,<=',
            'frequense' => 'required|integer|min:0',
            'periode' => 'required|in:jour,semaine,mois,annee',
        ];
    }
}