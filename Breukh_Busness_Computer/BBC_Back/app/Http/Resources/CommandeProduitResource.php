<?php

namespace App\Http\Resources;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Resources\ProduitResource;
use App\Http\Resources\SuccursaleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeProduitResource extends JsonResource
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
            "prix"=>$this->prix,
            "prixGlobal"=>$this->prixGlobal,
            "prixVente"=>$this->pivot->prix,
            "quantite"=>$this->pivot->quantite,
            "reduction"=>$this->pivot->reduction,
            "quantiteStock"=>$this->quantiteStock,
            "succursale"=>SuccursaleResource::make($this->succursale),
            "produit"=>ProduitResource::make(Produit::find($this->produit_id)),
        ];
    }
}
