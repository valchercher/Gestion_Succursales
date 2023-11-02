import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CommandeComponent } from './commande/commande.component';
import { AuthentificationComponent } from './authentification/authentification.component';
import { NavbarComponent } from './navbar/navbar.component';
import { ListerProduitComponent } from './lister-produit/lister-produit.component';
import { ProduitComponent } from './commande/produit/produit.component';
import { AddProduitComponent } from './lister-produit/add-produit/add-produit.component';
import {  authGuard } from './auth.guard';
import { ProduitSuccursaleComponent } from './lister-produit/produit-succursale/produit-succursale.component';
import { FactureComponent } from './commande/facture/facture.component';

const routes: Routes = [
  {path:'',component:AuthentificationComponent },
  {path:'produit',component:ListerProduitComponent,canActivate:[authGuard],
  children:[
    {path:'ajouter',component:AddProduitComponent},
    {path:'lister',component:ProduitSuccursaleComponent}
  ],
    data:{
      role:'Admin'
    }
  },
  {path:'commande',component:CommandeComponent,canActivate:[authGuard]},
  {path:'navbar',component:NavbarComponent,canActivate:[authGuard]},
  {path:'facture',component:FactureComponent,canActivate:[authGuard]},
  {path:'**',redirectTo:'',pathMatch:'full'},
  
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  
})
export class AppRoutingModule { }
