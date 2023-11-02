<?php

namespace App\Models;

use App\Models\User;
use App\Models\Paiement;
use App\Models\ProduitSuccursale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=[];

    protected $with=[
        'produitsuccursales',
    ];

    public function produitsuccursales(){
        return $this->belongsToMany(ProduitSuccursale::class,'commande_produit_succursales' ,'commande_id','produit_succursale_id')->withPivot(['prix','quantite','reduction']);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function paiement(){
        return $this->hasMany(Paiement::class);
    }
    
}
