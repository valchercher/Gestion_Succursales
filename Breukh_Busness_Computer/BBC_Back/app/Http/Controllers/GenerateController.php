<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CommandeResource;

class GenerateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($commande,$request,$total)
    {
        if(Storage::directoryMissing('vue')){
            Storage::makeDirectory('vue');
        }
       return Pdf::loadView('index',['commande'=>CommandeResource::make($commande),'request'=>$request,'total'=>$total])->download('facture.pdf');
        // pour le telecharger 
        // return Pdf::loadView('index',['commande'=>$commande])->download('facture.pdf');
        // pour l'afficher
        // return Pdf::loadView('index',['commande'=>$commande])->stream();
        // pour sauvegarder
        // return Pdf::loadView('index',['commande'=>$commande])
        // ->save(Storage::path('vue').DIRECTORY_SEPARATOR.$commande->id.'.pdf')
        // ->stream();
        //pour le recuperer au niveau de la base de données
        // Pdf::loadView('index',['commande'=>$commande])
        // ->save($filename= Storage::path('vue').DIRECTORY_SEPARATOR.$commande->id.'.pdf');
        // return response()->file($filename);
    }
}
