<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CommandeProduitResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->when($this->id !== null, $this->id),
            "date"=>$this->date,
            "commande"=>CommandeProduitResource::collection($this->produitsuccursales),
            "user"=>UserResource::make($this->user),
        ];
    }
}
