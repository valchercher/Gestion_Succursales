<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracteristiqueProduit extends Model
{
    use HasFactory;
    public function unite(){
        return $this->belongsTo(\App\Models\Unite::class,'caracteristique_produits');
    }
}
