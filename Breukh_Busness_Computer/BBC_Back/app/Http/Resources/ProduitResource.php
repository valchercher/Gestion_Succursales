<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\MarqueResource;
use App\Http\Resources\CategorieResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProduitSuccursaleResource;

class ProduitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "libelle"=>$this->libelle,
            "photo"=>$this->photo,
            "code"=>$this->code,
            "marque"=>MarqueResource::make($this->marque),
            "categorie"=>CategorieResource::make($this->categorie),
            "succursales"=>ProduitSuccursaleResource::collection($this->succursales),
            "caracteristiques"=>CaracteristiqueResource::collection($this->caracteristiques),
            
        ];
    }
}
