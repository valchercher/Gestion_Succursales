<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
class SuccursaleRequest extends FormRequest
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
        $id=$this->route('id');
        return [
            "nom"=>"required",
            "telephone"=>[
                "required",
                "numeric",
                "unique:succursales,telephone".$id,
                "regex:/^(77|76|78|70|33|75)[0-9]{7}$/",
            ],
            "adresse"=>"required|string",
            'reduction' => 'nullable|numeric'
            
        ];
    }
    public function FailValidator(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success"=>false,
            "error"=>true,
            "message"=>"erreur de validation",
            "errorList"=>$validator->errors()
        ]));
    }
    public function message(){
        return[
          
            "nom.required"=>"le nom et l'adresse ne doit pas être unique",
            "telephone.numeric"=>"le telephone doit être numerique",
            "telephone.regex"=>"le telephone doit commencer par 77,78,76,75,70,33",
            "telephone.required"=>"le numero de telephone doit être requi",
            "adresse.required"=>"l'adresse doit être requi",
            "adresse.string"=>"le doit être des caractères",
        ];
    }
}
