<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SuccursaleController;
use App\Http\Controllers\CaracteristiqueController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(UserController::class)->prefix('BBC')->group(function(){
    Route::post('store/user','store');
    Route::put('update/user/{id}','update');
    Route::delete('delete/user/{id}','delete');
    Route::get('load/user/{libelle}','load');
    Route::get('index/user','index');
    Route::post('user','seConnecter');
})->name('users');
Route::controller(SuccursaleController::class)->prefix('BBC')->group(function(){
    Route::post('store/succursale','store');
    Route::put('update/succursale/{id}','update');
    Route::delete('delete/succursale/{id}','delete');
    Route::get('load/succursale/{libelle}','load');
    Route::get('index/succursale','index');
})->name('succursales');

Route::controller(CommandeController::class)->prefix('BBC')->group(function(){
    Route::post('store/commande','store');
    Route::put('update/commande/{id}','update');
    Route::delete('delete/commande/{id}','delete');
    Route::get('load/commande/{libelle}','load');
    Route::get('index/commande','index');
    
})->name('commandes');

// Route::controller(ProduitController::class)->prefix('BBC')->group(function(){
//     Route::post('store/produit','store');
//     Route::put('update/produit/{id}','update');
//     Route::delete('delete/produit/{id}','delete');
//     Route::get('load/produit/{libelle}','load');
//     Route::get('index/produit','index');
//     Route::post('upload','upload');
//     Route::get('search/produit/{code}/succursale/{id}','search');
//     Route::get('prodSucc/{produit}/{succursale}','produitSuccursaleId');
// })->name('produits');

Route::controller(CaracteristiqueController::class)->prefix('BBC')->group(function(){
    Route::post('store/caracteristique','store');
    Route::put('update/caracteristique/{id}','update');
    Route::delete('delete/caracteristique/{id}','delete');
    Route::get('load/caracteristique/{libelle}','load');
    Route::get('index/caracteristique','index');
});

Route::controller(PaiementController::class)->prefix('BBC')->group(function(){
    Route::post('store/paiement','store');
    Route::put('update/paiement/{id}','update');
    Route::delete('delete/paiement/{id}','delete');
    Route::get('load/paiement/{libelle}','load');
    Route::get('index/paiement','index');
});
Route::controller(MarqueController::class)->prefix('BBC')->group(function(){
    Route::post('store/marque','store');
});
Route::controller(CategorieController::class)->prefix('BBC')->group(function(){
    Route::post('store/categorie','store');
});
Route::middleware('auth:sanctum')->prefix('BBC')->group( function () {
    
    Route::get('connexion',[UserController::class,'user']);
    Route::post('logout',[UserController::class,'logout']);
    Route::controller(ProduitController::class)->group(function()
    {
        Route::post('store/produit','store');
        Route::put('update/produit/{id}','update');
        Route::get('pagination/{size?}','pagination');
        Route::delete('delete/produit/{id}','delete');
        Route::get('load/produit/{libelle}','load');
        Route::get('index/produit','index');
        Route::post('upload','upload');
        Route::get('search/produit/{code}/succursale/{id}','search');
        Route::get('prodSucc/{produit}/{succursale}','produitSuccursaleId');
    })->name('produits');
    
});
