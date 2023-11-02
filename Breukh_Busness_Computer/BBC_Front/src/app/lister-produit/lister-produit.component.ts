import { Caracteristique, Marque, ProduitResponse, ResultatCode } from './../shared/interface.produit';
import { Component, OnInit, ViewChild } from '@angular/core';
import { ProduitServiceService } from '../service/produit-service.service';
import { Lister } from '../shared/interface.AddProduit';
import { AddProduitComponent } from './add-produit/add-produit.component';
import { Route, Router } from '@angular/router';

@Component({
  selector: 'app-lister-produit',
  templateUrl: './lister-produit.component.html',
  styleUrls: ['./lister-produit.component.css']
})
export class ListerProduitComponent  implements OnInit{

  listerProduit!:ProduitResponse[];
  marques:Marque[]=[]
  categories:Marque[]=[]
  visible:boolean=true;
  visibleded:boolean=false;
  caracteristiques:Caracteristique[]=[]
  @ViewChild(AddProduitComponent,{static:false},) forme=<AddProduitComponent>{}
  constructor(private servieList:ProduitServiceService,private router:Router){}
  ngOnInit(): void {
  
  }
  
  visibled(event:boolean){
this.visible=event
this.visibleded=true
this.router.navigateByUrl('produit/addProduit')
  }
}
