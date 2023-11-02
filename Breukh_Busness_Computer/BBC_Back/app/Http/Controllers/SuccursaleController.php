<?php


namespace App\Http\Controllers;
use Validator;
use App\Models\Succursale;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SuccursaleRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Http\Resources\SuccursaleResource;

class SuccursaleController extends Controller
{
    public function index(){
        $succursale=Succursale::paginate(5);
        return response()->json([
            "status"=>Response::HTTP_OK,
            "message"=>"succés",
            "data"=>SuccursaleResource::collection($succursale)
        ]); 
    }


    
    public function store(SuccursaleRequest $request)
    {

        return \DB::transaction(function() use ($request) {
            $exists = \DB::table('succursales')
                ->where('nom', $request->nom)
                ->where('adresse', $request->adresse)
                ->exists();
                if($exists){
                    return response()->json([
                        "status"=>Response::HTTP_NO_CONTENT,
                        "message"=>"La combinaison nom/adresse existe déjà."
                    ]);
                }
                $succursale=Succursale::create([
                "nom"=>$request->nom,
                "telephone"=>$request->telephone,
                "adresse"=>$request->adresse,
                // "reduction"=>$request->reduction,
            ]);
            return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"vous avez créé une succursale avec succés",
                "data"=>SuccursaleResource::make($succursale)
            ]);
        });
    }
    public function update(Request $request,$id)
    {
       return \DB::transaction(function() use ($request,$id) {
        $data=$request->only(["telephone","nom","adresse","reduction"]);
        $validator = Validator::make($data,[
            'telephone' => 'required|numeric|unique:succursales,telephone,'. $id,
            'adresse' => 'required|string',
            'reduction' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Erreur de validation",
                "errors" => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        $succursal=Succursale::find($id);
        if($succursal){                
            $succursal->update($data);
            }
        });
        return response()->json([
            "status"=>Response::HTTP_OK,
            "message"=>"le succursale est mis en jour avec succès"

        ],Response::HTTP_OK);
    }
    public function delete($id){
        $idSupp=Succursale::find($id);
        if($idSupp){
            $idSupp->delete();
            return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"Ce succursale est supprimer avec succès",
            ],Response::HTTP_OK);
        }
    }
    public function load($libelle)
    {
        $search=Succursale::where('nom','like'.'%',$libelle.'%')->get();
        return response()->json([
            "status"=>Response::HTTP_OK,
            "message"=>"resultat",
            "data"=>$search
        ],Response::HTTP_OK);
    }
}
