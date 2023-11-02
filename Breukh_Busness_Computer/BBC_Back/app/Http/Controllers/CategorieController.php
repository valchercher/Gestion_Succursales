<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function store(Request $request){
        $marque=Categorie::create([
            "libelle"=>$request->libelle,
        ]);
        return $marque;
    }
}
