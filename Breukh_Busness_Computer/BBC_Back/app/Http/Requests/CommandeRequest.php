<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommandeRequest extends FormRequest
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
            "reduction"=>'nullable',
            "montant"=>'required',
            "produit_succursales"=>"required"
        ];
    }
    public function message(){
        return [
            "produit_succursales.required"=>'le produit_succursales doit être requi',
            "montant.required"=>'le montant doit être requi',
        ];
    }
}
