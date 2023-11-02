<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
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
            'libelle' => 'required|string|unique:produits',
            // 'description' => 'required|string',
            // 'photo' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'caracteristiques'=>"required|array",
            'succursales'=>'required|array'

        ];

    }
    public function messages()
    {
        return [
            'libelle.required' => 'Le champ libelle doit être requis.',
            'libelle.string' => 'Le champ libelle doit être une chaîne de caractères.',
            'libelle.unique' => 'Ce libelle existe déjà dans la base de données.',
            // 'description.required' => 'Le champ description doit être requis.',
            // 'description.string' => 'Le champ description doit être une chaîne de caractères.',
            'photo.required' => 'Le champ photo doit être requis.',
            'photo.image' => 'Le champ photo doit être une image.',
            'photo.mimes' => 'Le champ photo doit avoir une extension autorisée (jpeg, png, jpg, gif).',
            'photo.max' => 'Le champ photo ne doit pas dépasser 2 Mo.',
            'libelleCaracteristique.required' => 'Le champ libelleCaracteristique  doit être requis.',
            'libelleCaracteristique.string' => 'Le champ libelle de caracteristique doit être une chaîne de caractères.',
            'descriptionCaracteristique.required' => 'Le champ descriptionCaracteristique  doit être requis.',
            'descriptionCaracteristique.string'=>'Le champ descrition de caracteristique doit être une chaîne de caractères.',
            'valeur.required' => 'La valeur  doit être requis.',
            'unite_id.required' => 'L\'id de l\'uniter  doit être requis.',
            'unite_id.exists' => 'L\'id de l\'uniter  n\'existes pas.'
        ];
    }

}
