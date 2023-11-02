<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Succursale extends Model
{
    use HasFactory;
    protected $guarded=[
        'id'
    ];
    public function user(){
        return $this->hasMany(User::class);
    }
    public function produits()
    {
        return $this->belongsToMany(Produit::class)->withPivot(['quantiteStock','prix']);
    }
    public static function mesAmis($id)
    {
        return  DB::table('succursale_amies')->where('type', 'confirmer')
            ->where('succursale_id', $id)
            ->orWhere('amie_id', $id)
            ->get();
    }

    public function scopeMyFriends(Builder $builder , $id){

        return  $builder->from('succursale_amies')
        ->where('succursale_id', $id)
        ->orWhere('amie_id', $id)
        ->where('type' , 'confirmer')
        ->get();
    }
    public function scopeWait(Builder $builder , $id){

        return  $builder->from('succursale_amies')->where(['type' => 'EnAttente' , 'amie_id' => $id])->get();
    }

    public function scopeOthers(Builder $builder , $id){
        $mesAmis = $this->mesAmis($id)->pluck('id');
        return $builder->from('succursale_amies')->whereNotIn('id' , $mesAmis);
    }
}
