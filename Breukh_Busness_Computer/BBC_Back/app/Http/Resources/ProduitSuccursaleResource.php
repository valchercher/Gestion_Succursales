<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitSuccursaleResource extends JsonResource
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
            "nom"=>$this->nom,
            "telephone"=>$this->telephone,
            "adresse"=>$this->adresse,
            "produit_succursale_id"=>$this->pivot->id,
            "prix"=>$this->pivot->prix,
            "prixGlobal"=>$this->pivot->prixGlobal,
            "quantiteStock"=>$this->pivot->quantiteStock,
        ];
    }
}
