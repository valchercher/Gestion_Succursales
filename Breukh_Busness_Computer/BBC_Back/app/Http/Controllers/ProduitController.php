<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use App\Models\Marque;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Succursale;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Caracteristique;
use App\Models\ProduitSuccursale;
use \Illuminate\Support\Facades\DB;
use App\Http\Requests\ProduitRequest;
use App\Http\Resources\MarqueResource;
use App\Http\Resources\UniterResource;
use App\Http\Resources\ProduitResource;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\ResourceCategorie;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ProduitSuccResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\CaracteristiqueResource;

class ProduitController extends Controller
{
    public function pagination(Request $request,$size){
        $size= $size ? $size : 4;
        $produit=Produit::with(['succursales'=>function($query) use($size){
            $query->where('succursale_id',1);
         }]
         )->paginate($size);
         $marque=Marque::all();
         $categorie=Categorie::all();
         $caracteristique=Caracteristique::all();
         $uniter=Unite::all();
         return  response()->json([
            "message"=>"succes",
            "status"=>200,
            "paginate"=>[
                "current_page" => $produit->currentPage(),
                "total" => $produit->total(),
                "per_page" => $produit->perPage(),
                "last_page" => $produit->lastPage(),
            ],
            "data"=>[
            "produit"=>ProduitResource::collection($produit),
            "marque"=>MarqueResource::collection($marque),
            "categorie"=>CategorieResource::collection($categorie),
            "caracteristiques"=>CaracteristiqueResource::collection($caracteristique),
            "uniter"=>UniterResource::collection($uniter)
            ]
        ]);
    }
    public function index()
    {
         $produit=Produit::with(['succursales'=>function($query){
            $query->where('succursale_id',1);
         }]
         )->get();
         $marque=Marque::all();
         $categorie=Categorie::all();
         $caracteristique=Caracteristique::all();
         $uniter=Unite::all();
        return  response()->json([
            "message"=>"succes",
            "status"=>200,
            // "paginate"=>[
            //     "current_page" => $produit->currentPage(),
            //     "total" => $produit->total(),
            //     "per_page" => $produit->perPage(),
            //     "last_page" => $produit->lastPage(),
            // ],
            "data"=>[
            "produit"=>ProduitResource::collection($produit),
            "marque"=>MarqueResource::collection($marque),
            "categorie"=>CategorieResource::collection($categorie),
            "caracteristiques"=>CaracteristiqueResource::collection($caracteristique),
            "uniter"=>UniterResource::collection($uniter)
            ]
        ]);
        // $produitPaginate=Produit::paginate(6);
        // return response()->json([
        //     "status"=>Response::HTTP_OK,
        //     "message"=>"le produit est ajouter avec succès",
        //     "data"=>ProduitResource::collection($produitPaginate),
           
        // ]);
    }
    public function produitSuccursaleId($produit,$succursale){
        $idproduitSuccursales=ProduitSuccursale::where('produit_id',$produit)->where('succursale_id',$succursale)->first();
        return $idproduitSuccursales->id;
    }
    public function store(ProduitRequest $request)
    {       $code=rand(10000000,99999999);
      
        return \DB::transaction(function() use ($request,$code) {
            $produit = new Produit([
                "libelle"=>$request->libelle,
                "description"=>$request->description,
                "photo"=>$request->photo,
                "code"=>$code,
                "categorie_id"=>$request->categorie_id,
                "marque_id"=>$request->marque_id,          
            ]);
            $produit->save();
            $produit->succursales()->attach($request->succursales);
            $produit->caracteristiques()->attach($request->caracteristiques);
           
            return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"le produit est ajouter avec succès",
                "data"=>new ProduitResource($produit),
               
               
            ]);
        });
    }
    // public function search($code,$id){
    // $produit = Produit::
    // where('code', '=', $code)
    // ->with(['succursales' => function  ($query) use($id) {
    //     $query->where('succursale_id', $id); 
    // }])
    // ->first();
    //     if($produit){
    //         return response()->json([
    //             "status"=>Response::HTTP_OK,
    //             "message"=>"le produit est trouver avec succès",
    //             "data"=>ProduitResource::make($produit)
    //         ]);
    //     }
    // }
    public function search(string $code,string $id)
    {


        $limit = request()->query('limit');

        $produit = Produit::where("code", $code)->first();
        $produit_succursale=ProduitSuccursale::where(['produit_id'=>$produit->id])->get();
      
        if (!$produit) {
            return response(["message" => "code introuvable"], Response::HTTP_NOT_FOUND);
        }
        $hisProduit = DB::table('produit_succursales')->where(['succursale_id' => $id, "produit_id" => $produit->id])->where('quantiteStock', '>', 0)->first();
        
            $tabIds=[];
        if (!$hisProduit) {
            $ids = Succursale::myFriends($id)->map(function ($a) use($id,$tabIds) {
                if($a->amie_id!==$id ||( $a->succursale_id===$id || $a->amie_id===$id)){
                   return $tabIds[]=$a->amie_id;
                }
                if($a->succursale_id!==$id || ( $a->amie_id===$id || $a->succursale_id===$id) ){
                    return $tabIds[]=$a->succursale_id;
                }
               return $tabIds;
            });
            return $ids;
          
            
            // $produit = Produit::with(['succursales' => function ($q) use ($ids, $limit) {
            //     $q->whereIn('succursale_id', $ids)->where('quantite', ">", 0)->orderBy('prix_gros', "asc")
            //         ->when($limit, fn ($q) => $q->limit($limit));
            // }, 'caracteristiques'])->where('code', $code)->first();
            
            $produit = Produit::quantitePositive($ids,$limit , $code)->first();
            
            return  response()->json([
                "message"=>"succes",
                "status"=>200,
                "data"=>[
                "produit"=>ProduitResource::make($produit),
               "succursale_produit"=> ProduitSuccResource::collection($produit_succursale)
                ]
            ]);
        }
        $produit = Produit::with(['succursales' => function ($q) use ($id) {
            $q->where('succursale_id', $id);
        }, 'caracteristiques'])->where('code', $code)->first();
        return  response()->json([
            "message"=>"succes",
            "status"=>200,
            "data"=>[
            "produit"=>ProduitResource::make($produit),
           "succursale_produit"=> ProduitSuccResource::collection($produit_succursale)
            ]
        ]);
    }
    public function update(Request $request,$id)
    {
        $produit=Produit::find($id);
        $data=$request->only(["libelle","description","code","photo","succursales"]);
        if($produit)
        {
            $produit->update($data);
            $produit->succursale()->sync($data->succursales);
            return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"le produit est mise en jour  avec succès",
               
            ]);
        }
    }
    public function delete($id)
    {
        $idproduit=Produit::find($id);
        if($idproduit){
            $idproduit->delete();
            $idproduit->succursales()->detach($request->succursales);
            return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"le produit est supprimer  avec succès",
               
            ]);
        }
    }

}
