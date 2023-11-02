<?php

namespace App\Http\Controllers;

use App\Models\Succursale;
use Illuminate\Http\Request;

class AmisController extends Controller
{
    public function listeSuccursalesFriends($id){
            
    }
    public function listeSuccursalesOthers($id){
           return Succursale::others($id)->get();
    }
    public function listeSuccursalesWait($id){
           return Succursale::wait($id);
    }
}
