<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caracteristique;

class CaracteristiqueController extends Controller
{
    public function store(Request $request)
    {
        $caracteristique= Caracteristique::create([
            "libelle"=>$request->libelle,                
        ]);
        return response()->json([
            "status"=>200,
            "message"=>"caracteristique inserait avec succès",
            "data"=>$caracteristique
        ]);
    }
}
