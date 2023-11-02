<?php


namespace App\Http\Controllers;
use App\Models\Commande;
use App\Models\Paiement;
use Nette\Utils\DateTime;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProduitSuccursale;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommandeRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CommandeResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\GenerateController;

class CommandeController extends Controller
{
    public function index()
    {
       
        $commande=Commande::all();
      
        return response()->json([
            "status"=>Response::HTTP_OK,
            "message"=>"paginate all pagination",
            "data"=>CommandeResource::collection($commande)
        ]);
    }

    public function __invoke($commande, $request,$total)
    {
        if(Storage::directoryMissing('vue')){
            Storage::makeDirectory('vue');
        }
       return Pdf::loadView('index',['commande'=>CommandeResource::make($commande),'request'=>$request,'total'=>$total])->download('facture.pdf');
    }
    public function store(CommandeRequest $request)
    {  
        return DB::transaction(function () use($request) {
            $commande=Commande::create([
                "date"=>new dateTime(),
                "reduction"=>$request->reduction,
                "user_id"=>$request->user_id,
                "montant"=>$request->montant,
                "client_id"=>$request->client_id,
            ]);
            $commande->produitsuccursales()->attach($request->produit_succursales);
            $paiement=Paiement::create([
                "date"=>new dateTime(),
                "montant"=>$request->aPayer,
                "commande_id"=>$commande->id,
            ]);
            $total=0;
            foreach($request->produit_succursales as $key=>$value){
                $produitsuccursale=DB::table('produit_succursales')
                    ->where('id',$value['produit_succursale_id'])
                    ->first();
                if($produitsuccursale){
                DB::table('produit_succursales')
                    ->where('id',$value['produit_succursale_id'])
                    ->decrement('quantiteStock', $value['quantite']);
                }
                $total += $value['prix'] * $value['quantite'];
            }
            
          $pdf=$this($commande,$request, $total);    
          return $pdf;
         return Pdf::loadView('index',['commande'=>CommandeResource::make($commande),'request'=>$request,'total'=>$total])->download('facture.pdf');
           return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"Commande enregistré avec succès",
                "data"=>[
                    "commande"=>new CommandeResource($commande),
                    "paiement"=>$paiement,
                    
                ],
            ]);
        });
    }
    public function update(Request $request, $id)
    {

    }
    public function delete($id)
    {

    }
    public function load($libelle)
    {

    }
}
