<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'login' => 'required',
            'password' => 'required|string',
        ];
    }

    public function failedvalidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'message' => 'erreur de validation ',
            'errorsList' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'login.required' => 'Le champ login est requis.',
            'login.email' => 'Le champ login est email.',
            'password.required' => 'Le champ mot de passe est requis.',
        ];
    }
}
