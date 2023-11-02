<?php

namespace App\Models;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProduitSuccursale extends Model
{
    use HasFactory;
    protected $fillable=[
        "quantiteStock",
    ];
    public function commandes(){
        return $this->belongsToMany(Commande::class,'commande_produit_succursales')->withPivot(['quantite','prix']);
    }
    
}
