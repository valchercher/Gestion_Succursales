<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
            'login' => 'required|unique:users',
            'password' => 'required|string|min:6',
            // 'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'succursale_id' => 'required|exists:succursales,id', 
        ];
    }
    public function message(){
        return[
            "nom.required"=>"le nom doit être requi",
            "prenom.required"=>"le prenom doit être requi",
            "email.required"=>"le mail doit être requi",
            "password.required"=>"le mot de pass doit être requi",
            "photo"=>"la photo doit être requi",
        ];

    }
}
