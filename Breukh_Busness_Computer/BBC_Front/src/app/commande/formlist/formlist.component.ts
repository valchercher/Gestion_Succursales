
import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { AbstractControl, FormArray, FormBuilder,  FormGroup, Validators } from '@angular/forms';
import { data } from 'src/app/demo-data';
import { validationQuantite } from 'src/app/shared/ValidatorQuantite';
import {CommandeRequest, Panier, ProduitResponse, Valeur, changeQuantite } from 'src/app/shared/interface.produit';

@Component({
  selector: 'app-formlist',
  templateUrl: './formlist.component.html',
  styleUrls: ['./formlist.component.css']
})
export class FormlistComponent implements OnInit{
formeFormulaire:FormGroup;
succursale:ProduitResponse=data.produit
montantApayer:number= 0;
produit_succursale_id:number[]=[];
total?:number
message:string="";
@Output('VenteCommmande') VenteCommmande:EventEmitter<CommandeRequest> = new EventEmitter<CommandeRequest>();
@Output('faireCommande') faireCommande:EventEmitter<any> =new EventEmitter<any>()
constructor(private fb:FormBuilder){
  this.formeFormulaire=this.fb.group({
    reduction:['',Validators.pattern('^[0-9]{1,3}$')],
    montant:[],
    quantiteStock:[],
    aPayer:[,[Validators.required,this.validationApayer]],
    user_id:[1],
    client_id:[1],
    commandes:this.fb.array([     
    ]),
  })
}
  ngOnInit() {
    this.localStorageResult();
  }
  localStorageResult(){
    const dataResult=localStorage.getItem('dataCommandes')?.toString();
    let dat=[];
    const totaux:any=[];
        if(dataResult){
           dat=JSON.parse(dataResult);
           dat.forEach((element:Panier) => {
             this.commandes.push(this.fb.group(element))
             totaux.push(element.total)
           });
        }
      if(totaux){
        this.total=totaux.reduce((a:number,b:number)=>a+b);
        this.formeFormulaire.get('montant')?.setValue(this.total);
      }
  }
  createItem(){
    return  this.fb.group({
            libelle:['',[]],
            produit_succursale_id:[],
            quantite:['',[Validators.required,validationQuantite]],
            prix:[],
            total:[]          
    })
  }
  validationApayer(control:AbstractControl):{[key:string]:number}|null{
    let Apayer=control.value;
    let montant=control.parent?.get('montant')?.value;
    if(Apayer && montant){
      let value=Apayer -montant;  
        return{ 'error':value}
    }
    return null
  }
  get commandes(){
    return this.formeFormulaire.get('commandes') as FormArray
  }
  addItem(){
    this.commandes.push(this.createItem())
  }
  removeItem(i:number,item:AbstractControl){
    this.commandes.removeAt(i)
    console.log(this.formeFormulaire.get('commandes')?.value);
     localStorage.setItem('dataCommandes', JSON.stringify(this.formeFormulaire.get('commandes')?.value));
   localStorage.removeItem(item.value)
   

  }
  montantTotal(montant:number){
    let mont=montant
    let totalMont=this.formeFormulaire.get('montant')?.value;
    let value=totalMont + mont;
    return this.formeFormulaire.get('montant')?.setValue(value)
  }
  // reductionCommande(event:Event){
  //   const tab=localStorage.getItem('dataCommandes')
  //   let inputReduct=event.target as HTMLInputElement;
  //   const value=parseInt(inputReduct.value);
  //   let val=inputReduct.value;
  //   if(isNaN(value)){
  //     this.formeFormulaire.get('reduction')?.setValue(' '); 
  //   }
  //   else if(val.length>=2){
  //    if(+val.charAt(0)===0 && +val.charAt(1)===0){
  //     this.formeFormulaire.get('reduction')?.setValue(val.slice(0,1));
  //    }
  //     if(+val.charAt(1)!==0){
  //       this.formeFormulaire.get('reduction')?.setValue(val.slice(0,2));     
  //     }
  //     if(val.length===3){
  //       if(+val.charAt(0)!==1){
  //         this.formeFormulaire.get('reduction')?.setValue(val.slice(0,2));
  //       }
  //       if(+val.charAt(2)!==0){
  //         this.formeFormulaire.get('reduction')?.setValue(val.slice(0,2));  
  //       }
  //     }
  //     if(inputReduct.value.length>3){   
  //      this.formeFormulaire.get('reduction')?.setValue(inputReduct.value.slice(0,3))    
  //     }
  //   }
  //   let montant=this.formeFormulaire.get('montant')?.value;
  //   let valeur=inputReduct.value
  //   if(valeur && montant){
  //     let val=(montant * +valeur)/100;
  //     this.formeFormulaire.get('montant')?.setValue(montant - val)
  //   }
  // }
  reductionCommande(event: Event) {
    let val = (event.target as HTMLInputElement).value.trim();
    let montant = this.formeFormulaire.get('montant')?.value;
    if(val){
      const isNumeric = !isNaN(parseFloat(val)) && isFinite(+val);
      const isInRange = isNumeric && +val >= 1 && +val <= 100;
    
      if (!isInRange) {
          this.formeFormulaire.get('reduction')?.setValue(val.slice(0,2));
      } else {
          const valeur = val.length > 2 ? val.slice(0, 3) : val;
          this.formeFormulaire.get('reduction')?.setValue(valeur);
          const reduction = parseFloat(valeur);
          const reductionAmount = (montant * reduction) / 100;
          this.formeFormulaire.get('montant')?.setValue(montant - reductionAmount);
      }
    }
   else{
    this.formeFormulaire.get('montant')?.setValue(montant)
   }
  }
  TerminerCommande(){
    console.log(this.formeFormulaire.value);
     this.montantApayer= this.formeFormulaire.get('montant')?.value
  }
  TerminerVente(){
    const data=this.formeFormulaire.value;
    data.commandes=this.commandes.value.map((ele:Valeur)=>{
      return{
        produit_succursale_id:ele.produit_succursale_id,
        prix:ele.prix,
        quantite:ele.quantite
      }
    })
      const dataRequest=  this.formeFormulaire.value
       const Request= { 
                        reduction:dataRequest.reduction,
                        montant:dataRequest.montant,
                        aPayer:dataRequest.aPayer,
                        user_id:dataRequest.user_id,
                        client_id:dataRequest.client_id,
                        produit_succursales:dataRequest.commandes
      }
      console.log(Request);   
      this.VenteCommmande.emit(Request)    
  }
  onChangeQuantite(event:Event,i:number)
  {
    console.log(this.formeFormulaire.get('commandes')?.value); 
    const inputQuantite=event.target as HTMLInputElement;
    if(inputQuantite.value){
      let prix=this.commandes.at(i).get('prix')?.value
      let total=+inputQuantite.value * prix;
      this.commandes.at(i).get('total')?.setValue(total)     
      let tab:number[]=[] 
      let totaux=0;
      const data=this.formeFormulaire.value.commandes.forEach((element:changeQuantite) => {
        tab.push(element.total);
      });
        totaux=tab.reduce((a,b)=>a+b);
       this.formeFormulaire.get('montant')?.setValue(totaux)
       
    }
  }
  faireFacture(){
   this.faireCommande.emit(this.formeFormulaire.value)
    
  }
}
