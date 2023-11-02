<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestUtilisateur extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [      
                "email"=>'required|email',
                "password"=>'required'
        ];
    }
    public function messages(){
        return [
            "email.required"=>"l'email doit être requis",
            "email.email"=>" l'email doit contenir qu'une adresse email",
            "password.required"=>"le mot de passe doit être requis",
        ];
    }
}
