<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function store(Request $request){
        $marque=Marque::create([
            "libelle"=>$request->libelle,
        ]);
        return $marque;
    }
}
