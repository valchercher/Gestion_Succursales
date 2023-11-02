<?php

namespace App\Http\Resources;

use App\Http\Resources\SuccursaleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'login' => $this->login,
            'role'=>$this->role,
            'photo' => $this->photo,
            'succursale_id' =>new SuccursaleResource($this->succursale),
        ];
    }
}
