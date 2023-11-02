<?php

namespace App\Models;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caracteristique extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    public function produits(){
        return $this->belongsToMany(Produit::class,'caracteristique_produits')->withPivot('valeur');
    }

}
