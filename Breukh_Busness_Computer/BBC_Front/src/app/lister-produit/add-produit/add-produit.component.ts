import { Marque, ProduitResponse } from './../../shared/interface.produit';
import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
import { ProduitServiceService } from 'src/app/service/produit-service.service';
import { Lister, RequestProduit } from 'src/app/shared/interface.AddProduit';
import { Caracteristique, ResultatCode } from 'src/app/shared/interface.produit';

@Component({
  selector: 'app-add-produit',
  templateUrl: './add-produit.component.html',
  styleUrls: ['./add-produit.component.css']
})
export class AddProduitComponent implements OnInit {
  formAddProd:FormGroup;
  listerProduit!:ProduitResponse[];
 marques?:Marque[]
 categories?:Marque[]
caracteristiques:Caracteristique[]=[]
caracterists:Caracteristique[]=[]
valeurs:string[][]=[]
DisqueItem: boolean[] = [];
BaterieItem:boolean[]=[];
RadioItem:boolean[]=[]
textContent:string[][]=[]
unites:string[][]=[];
message:string="";
erreur:string="";
index:number=0;
inputValue:string=""
tab:Caracteristique[]=[];
Resultcaracteristiques:Caracteristique[]=[];
caracts:Caracteristique[]=[]
constructor(private form:FormBuilder,private serviceList:ProduitServiceService){
    this.formAddProd=this.form.group({
      libelle:[],
      prix:[],
      quantite:[],
      marque:[],
      description:[],
      code:[],
      categorie:[],
      caracteristiques:[],
      photo:['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6HyBqrZSEKnO-pOEcBOgKnxVGObrOHocW-A&usqp=CAU'],
      produit:this.form.array([
       
      ]),
    })  
  }
  ngOnInit(): void {
    this.getindex()
    // this.caracterists[this.index]=this.caracteristiques;
  }
  getindex(){
    this.serviceList.index().subscribe({
      next:((response:ResultatCode<Lister>)=>{
        if(response.status==200){
          console.log(response.data.categorie);
          this.listerProduit=response.data.produit   
          this.marques=response.data.marque;
          this.categories=response.data.categorie
          this.caracteristiques=response.data.caracteristiques;
          this.caracterists=this.caracteristiques
                  
        }
      })
    })
  }
  createItem(){
   return this.form.group({
      libelle:[],
      valeur:[],
      caracteristique:[],
      uniter:[]
    })
  }
  get produits():FormArray{
    return this.formAddProd.get('produit') as FormArray
  }
  addItem(){
    this.produits.push(this.createItem())
  }
  revoteItem(i:number){
    this.produits.removeAt(i)
  }
  get photos(){
    return this.formAddProd.get('photo')
  }
  onChangeSelect(event:Event,i:number){
    this.index=this.index+1;
    const selectValue=event.target as HTMLSelectElement;
    let select=selectValue.options[selectValue.selectedIndex].text;
    let caract=this.caracteristiques.find(ele=>ele.libelle==select);
    this.valeurs[i]=[];
    this.unites[i]=[];
    this.textContent[i]=[]
    this.DisqueItem[i]=false
    this.BaterieItem[i]=false
    this.RadioItem[i]=false;
    this.produits.at(i).reset
    if(caract?.valeur===null && caract?.uniter!==null)
    {
     this.BaterieItem[i]=true
     this.unites[i].push(...caract?.uniter?.toString().split(',')!)
    }
    else if(caract?.valeur!==null && caract?.uniter!==null)
    { 
      this.unites[i].push(...caract?.uniter?.toString()?.split(',')!)
      this.valeurs[i].push(...caract?.valeur?.toString()?.split(',')!); 
      this.DisqueItem[i]=true
    }else if(caract?.valeur.toString().split(',')?.length==2 && caract.uniter===null)
    {
      this.textContent[i]=caract?.valeur.toString().split(',')
      this.RadioItem[i]=true
    }else if(caract?.valeur.toString().split(',')?.length! >2 && caract.uniter===null)
    {  
      this.valeurs[i].push(...caract?.valeur?.toString()?.split(',')!); 
      this.DisqueItem[i]=true
    }
    
    this.tab.push(caract!);
    this.caracterists=this.compareTab(this.caracteristiques,this.tab);
    
    
    console.log(this.caracterists);
   
     // console.log(this.Resultcaracteristiques);
    // this.caracterists=this.Resultcaracteristiques  
    
  }
  private compareTab(tab1:Caracteristique[],tab2:Caracteristique[]):Caracteristique[]{
    return tab1.filter(element => !tab2.some(item => this.someComparisonFunction(item, element)));
  }
  private someComparisonFunction(item1: Caracteristique, item2: Caracteristique): boolean {
    return item1.id === item2.id;
  }
  
  onChangeImage(event:Event){
    const image=event.target as HTMLInputElement;
    if(image.files && image.files.length>0){
      let reader=new FileReader();   
      reader.onload=()=>{
        const imageBase_64:string = reader.result as string
        this.formAddProd.get('photo')?.setValue(imageBase_64);
      }
      reader.readAsDataURL(image.files[0]);
    }
  }
  onSubmit(){
    const valeur=this.formAddProd.value
   const data:RequestProduit={
    libelle:valeur.libelle,
    photo:valeur.photo,
    marque_id:valeur.marque.id,
    categorie_id:valeur.categorie.id,
    succursales:[
      {
        succursale_id:1,
        prix:valeur.prix,
        quantiteStock:valeur.quantite
      }
    ],
    caracteristiques:this.produits.value.map((element:any)=>{
      return {
        valeur:element.valeur,
        caracteristique_id:element.libelle.id,
        uniter:element.uniter
      }
    })
   }
   console.log(data);
  this.serviceList.store(data).subscribe({
    next:(response=>{
      console.log(response);
      this.message=response.message
      this.formAddProd.reset();
      this.produits.removeAt(0);    
    })
  })
  }
  verifyArticleExiste(event :Event){
    let inputValue=(event.target as HTMLInputElement).value
    this.formAddProd.get('code')?.setValue('')
   const data =this.listerProduit.find(element=>element.libelle.toLowerCase()===inputValue.toLowerCase());
   this.erreur=data?.libelle! 
   let value=this.listerProduit.sort((a,b)=>a.code -b.code);
  let code=value[value.length-1]
   if(inputValue){
    this.formAddProd.get('code')?.setValue(code.code+1)
   }
  }
  toogleValue(event:Event){
    let input=(event.target as HTMLInputElement).value;
    this.inputValue=input
  }
}
