

import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavbarComponent } from './navbar/navbar.component';
import { FormlistComponent } from './commande/formlist/formlist.component';
import {MatSelectModule} from '@angular/material/select'
import { MatFormFieldModule} from '@angular/material/form-field';
import { MatIconModule} from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar'
import { ReactiveFormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgxMatSelectSearchModule } from 'ngx-mat-select-search';
import { ProduitComponent } from './commande/produit/produit.component';
import { CommandeComponent } from './commande/commande.component';
import {  HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { FiltrePipe } from './pipe/filtre.pipe';
import { AddProduitComponent } from './lister-produit/add-produit/add-produit.component';
import { AuthentificationComponent } from './authentification/authentification.component';
import { ListerProduitComponent } from './lister-produit/lister-produit.component';
import { authGuard } from './auth.guard';
import { ProduitSuccursaleComponent } from './lister-produit/produit-succursale/produit-succursale.component';
import { AuthInterceptor, AuthInterceptorProvider } from './auth.interceptor';
import { PublicComponent } from './public/public.component';
import { NgxPaginationModule } from 'ngx-pagination';
import {  MatPaginatorModule } from '@angular/material/paginator';
import { FactureComponent } from './commande/facture/facture.component';
@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    FormlistComponent,
    ProduitComponent,
    CommandeComponent,
    FiltrePipe,
    AddProduitComponent,
    AuthentificationComponent,
    ListerProduitComponent,
    ProduitSuccursaleComponent,
    PublicComponent,
    FactureComponent,
   
   
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    BrowserAnimationsModule,
    MatSelectModule,
    MatFormFieldModule,
    MatIconModule,
    MatToolbarModule,
    NgxMatSelectSearchModule,
    HttpClientModule,
    MatPaginatorModule
    

 
    
  ],
  providers: [AuthInterceptorProvider],
  bootstrap: [AppComponent]
})
export class AppModule { }
