import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Subject, debounceTime, map } from 'rxjs';
import { data } from 'src/app/demo-data';
import { validationQuantite } from 'src/app/shared/ValidatorQuantite';
import { Commande, ProduitResponse, Root, Succursale, postId } from 'src/app/shared/interface.produit';

@Component({
  selector: 'app-produit',
  templateUrl: './produit.component.html',
  styleUrls: ['./produit.component.css']
})
export class ProduitComponent implements OnInit {
  produitForme:FormGroup;
  @Input('Response')  Response:ProduitResponse[]=[];
  @Input() resultCode?:Root;
  result:number=0
  cheched:boolean=false;
  AutreSuccursale?:Succursale;
  active:boolean=false;
  succursales?:Succursale;
  private searchTerms = new Subject<string>();
  @Output('referenceCode') referenceCode:EventEmitter<number> =new EventEmitter<number>();
  @Output('commandeVente') commandeVente:EventEmitter<Commande> =new EventEmitter<Commande>();
  @Output('getIdProduitSuccursale') getIdProduitSuccursale:EventEmitter<postId> = new EventEmitter<postId>();
  constructor(private form:FormBuilder){
    this.produitForme=this.form.group({
      code:['',],
      prixVente:[,[Validators.required,this.validatorPrix ]],
      quantite:[,[Validators.required,validationQuantite]],
      libelle:[],
      prix:[],
      produit_succursale_id:[],
      prixGlobal:[],
      quantiteStock:[],
      total:[]
    })
  }
  ngOnInit(): void {
     this.resultCode=data 
    if(this.resultCode?.produit.succursales[0].quantiteStock===0){
      this.active=true;
      // console.log(this.succursales.quantiteStock);
      return
    }
    if(this.AutreSuccursale?.prixGlobal){
      this.active=false;
      console.log(this.AutreSuccursale.quantiteStock);
      
     
    }
  }
  get codes(){
    return this.produitForme.get('code')?.value
  }
  searchReference(event:Event){
   const input=event.target as HTMLInputElement;
   this.searchTerms.next(input.value);
   if(input.value){
    this.result=+input.value
     this.referenceCode.emit(+input?.value);
   }
  }
  toggle(succurcale:Succursale){
     this.AutreSuccursale=succurcale
     this.active=false
  }
  // addPanier(sucursale:Succursale){
  //   console.log(sucursale);
    
  // }
  ajouterPanier(){
    
    console.log(this.resultCode);
   if(this.resultCode?.succursale_produit){
    const tab= this.resultCode?.produit.succursales.filter(ele=>{
      return this.resultCode?.succursale_produit.some(succ_prod=>succ_prod.succursale_id==ele.id)
    })
    console.log(tab);
   }
   if(this.AutreSuccursale){
      this.produitForme.get('produit_succursale_id')?.setValue(this.AutreSuccursale.produit_succursale_id)
      this.produitForme.get('prix')?.setValue(this.AutreSuccursale.prix)
        this.produitForme.get('quantiteStock')?.setValue(this.AutreSuccursale.quantiteStock);
        this.produitForme.get('prixGlobal')?.setValue(this.AutreSuccursale.prixGlobal);
      return
    }
    this.resultCode?.produit?.succursales.forEach(ele=>{
      this.produitForme.get('produit_succursale_id')?.setValue(ele.produit_succursale_id)
      this.produitForme.get('prix')?.setValue(ele.prix)
      this.produitForme.get('quantiteStock')?.setValue(ele.quantiteStock);
      this.produitForme.get('prixGlobal')?.setValue(ele.prixGlobal); 
      this.succursales=ele;
    })
    
  }
  validatorPrix(control:AbstractControl):{[key:string]:string}|null {
    const prixVente=control.value;

    const prix=control.parent?.get('prix')?.value
    if(prixVente){
    
      if(prixVente && prix){
        if(prixVente<prix){
          return {'error':"red"}
        }
        if(prixVente==prix){
          return{'error':"black"}
        }
        if(prixVente>prix){
          return {'error':"green"}
        }
      }
    }
    return null;
  }
 
  finishCommande(){ 
    this.produitForme.get('libelle')?.setValue(this.resultCode?.produit?.libelle) 
    const prix=this.produitForme.get('prixVente')?.value;
    const quantite=this.produitForme.get('quantite')?.value;
    this.produitForme.get('total')?.setValue(prix * quantite)
    const data=this.produitForme?.value;
    this.commandeVente.emit(data)
    
    console.log(data);
    

    
  }
}
