<?php



namespace App\Models;
use App\Models\Marque;
use App\Models\Categorie;
use App\Models\Succursale;
use App\Models\Caracteristique;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory,SoftDeletes;
   protected $fillable=[
    'libelle',
    'description',
    'code',
    'photo',
    'marque_id',
    'categorie_id'
   ];
    public function succursales()
    {
        return $this->belongsToMany(Succursale::class,'produit_succursales')->withPivot(['prix','prixGlobal','quantiteStock','id']);
    }
    public function caracteristiques(){
        return $this->belongsToMany(Caracteristique::class,'caracteristique_produits')->withPivot('valeur','uniter');
    }
    public function scopeQuantitePositive(Builder $builder , $ids , $limit , $code):Builder {
        return  $builder->with(['succursales' => function ($q) use ($ids, $limit) {
             $q->whereIn('succursale_id', $ids)->where('quantiteStock', ">", 0)->orderBy('prixGlobal', "asc")
                 ->when($limit, fn ($q) => $q->limit($limit));
         }, 'caracteristiques'])->where('code', $code);
     }
     public function marque(){
        return $this->belongsTo(Marque::class);
    }
    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
}
