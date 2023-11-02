<?php

namespace App\Models;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
