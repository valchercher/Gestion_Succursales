
import { Component, Input, OnInit, ViewChild } from '@angular/core';
import { CommandeService } from '../commande.service';
import { Commande, CommandeRequest, Panier, ProduitResponse, Response, ResultatCode, Root, postId } from '../shared/interface.produit';
import { ProduitComponent } from './produit/produit.component';
import { FormlistComponent } from './formlist/formlist.component';
import { FormArray, FormBuilder } from '@angular/forms';
import { Dial } from 'flowbite';
import { FactureComponent } from './facture/facture.component';

@Component({
  selector: 'app-commande',
  templateUrl: './commande.component.html',
  styleUrls: ['./commande.component.css']
})
export class CommandeComponent implements OnInit {
Response:ProduitResponse[]=[];
Resultat!:Root;
idProduitsuccursale!:number;
tableaux:Panier[]=[];
loading:boolean=true;
donneeCommande:any;
hidden:boolean=true;
@ViewChild(FormlistComponent,{static:false},) forme=<FormlistComponent>{};
@ViewChild(FactureComponent,{static:false},) formeFacture=<FactureComponent>{}
  constructor(private service:CommandeService,private fb:FormBuilder){}
  ngOnInit(): void {
     
    
  }
  resultSearch(event:number){
    this.service.search(event,1).subscribe({
      next:(response:ResultatCode<Root>)=>{
        if(response){ 
         this.Resultat=response.data
         console.log(response);
         
        }else{
          console.log("le produit n'est pas trouver");      
        }
      }
    }) 
  }
  commandeVente(event:Commande){
    console.log();
    const data:Panier={
      produit_succursale_id:event.produit_succursale_id,
      libelle:event.libelle,
      quantite:event.quantite,
      prix:event.prixVente,
      total:event.total,
    } 
    const taub=localStorage.getItem('dataCommandes')?.toString();
    console.log(taub);
    
    if(!taub){
      this.tableaux.push(data);
      localStorage.setItem('dataCommandes',JSON.stringify(this.tableaux));
      this.forme.commandes.push(this.fb.group(data));
    }else{
      this.tableaux=JSON.parse(taub!);

      const valeur= this.tableaux.filter(element => {return element.libelle===data.libelle})
      console.log(valeur);
      if(valeur.length>0){
        alert('ce produit existe deja vous pouvez changer laquntite')
        return
      }
     
      this.tableaux.push(data);
        this.forme.commandes.push(this.fb.group(data));
        localStorage.setItem('dataCommandes',JSON.stringify(this.tableaux))
    }
    console.log(taub);
    
  }
  Vente(event:CommandeRequest){
    console.log(event);
    this.service.store(event).subscribe({
      next:((response)=>{
        if(response.status){
          console.log("la commande est terminer avec succès ");
          localStorage.removeItem('dataCommandes')
          this.forme.commandes.removeAt(0);
          this.forme.formeFormulaire.reset();
          this.forme.message=response.message
          setTimeout(()=>{
            this.forme.message=""
          },5000)
          console.log(response);
          
        }
        
      })
    })
  }
  faireCommande(event:any){
    console.log(event);
    
    this.donneeCommande=event.commandes
    this.formeFacture.montant=event.montant;
    this.formeFacture.donneeCommandes.push(this.fb.group(
      event.commandes,
    ))
    console.log(this.donneeCommande);
    
  }
}
