<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\RequestUtilisateur;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $user=User::paginate(6);
        return response()->json([
            "status"=>Response::HTTP_OK,
            "message"=>"paginate all success",
            "data"=>UserResource::collection($user),
        ]);

    }
    public function store(UserRequest $request){
        return \DB::transaction(function () use ($request) {
            $user=User::create([
                "nom"=>$request->nom,
                "prenom"=>$request->prenom,
                "email"=>$request->email,
                "login"=>$request->login,
                "password"=>$request->password,
                "photo"=>$request->photo,
                "role"=>$request->role,
                "succursale_id"=>$request->succursale_id
            ]);
            return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"l'utiliser est ajouter avec succès",
                "data"=>UserResource::make($user),
            ]);
        });
    }
    public function update(Request $request ,$id)
    {
        return \DB::transaction(function () use ($request,$id) {
            $user=User::find($id);
            $data=$request->only(["nom","prenom","email","login","password","photo","succursale_id"]);
            if($user){
                $user->update($data);
                return response()->json([
                    "status"=>Response::HTTP_OK,
                    "message"=>"l'utiliser est mise en jour avec succès",
                    
                ]);
            }
        });
    }
    public function delete($id){
        $user=User::find($id);
        if($user){
            $user->delte();
            return response()->json([
                "status"=>Response::HTTP_OK,
                "message"=>"l'utiliser est supprimer avec succès",
                
            ]);
        }
    }
    public function load($libelle)
    {
        $user= User::where('nom','like'.'%',$libelle.'%')->get();
        return response()->json([
            "status"=>Response::HTTP_OK,
            "message"=>"load succès",
            "data"=>UserResource::collection($user),
        ]);
    }
    public function seConnecter(RequestUtilisateur $request){
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user=Auth::user();
            $token=$user->createToken('MON_TOKEN')->plainTextToken;
            $cookie=cookie('token',$token,24*60);
            return response()->json([
                "status"=>Response::HTTP_OK,
                "token"=>$token,
                "user"=>UserResource::make($user)
            ])->withCookie($cookie);
        }
        return response()->json([
            "message"=>"email ou mot de passe est incorrecte",
        ],Response::HTTP_UNAUTHORIZED);
    }
    public function user(Request $request){

        return $request->user();
    }
    public function logout(Request $request){ 
    $user = Auth::user();
    $token=$request->cookie('token');
    if ($token) {
        
        $user->currentAccessToken()->delete();
        $token =Cookie::forget('token');

        return response()->json([
            "message" => "L'utilisateur $user->prenom $user->nom est déconnecté avec succès"
        ], Response::HTTP_OK);
    } else {
        return response()->json([
            "message" => "Token introuvable"
        ], Response::HTTP_NOT_FOUND);
    }
}

}
