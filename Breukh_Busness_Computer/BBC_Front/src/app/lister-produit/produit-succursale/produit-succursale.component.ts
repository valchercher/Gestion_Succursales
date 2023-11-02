import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { PageEvent } from '@angular/material/paginator';
import { ProduitServiceService } from 'src/app/service/produit-service.service';
import { Lister } from 'src/app/shared/interface.AddProduit';
import { ProduitResponse, ResultatCode } from 'src/app/shared/interface.produit';

@Component({
  selector: 'app-produit-succursale',
  templateUrl: './produit-succursale.component.html',
  styleUrls: ['./produit-succursale.component.css']
})
export class ProduitSuccursaleComponent implements OnInit {
@Input('visibled') visibled:boolean=true;
   listerProduit!:ProduitResponse[];
   page:number=1;
   page_size:number=3;
   total?:number;
   code:number=0;
   produitSuccursale:FormGroup;
   libelle:string="";
  @Output('visible')  visabled= new EventEmitter<boolean>();
  constructor(private serviceList:ProduitServiceService,private fb:FormBuilder){
    this.produitSuccursale=this.fb.group({
      search:[],
    })
  }
  ngOnInit(): void {
   this.getindex(this.page,this.page_size);
  }
  afficheAddProduit(){
    this.visabled.emit(false);
  }
  getindex(page:number,page_size?:number){
    this.serviceList.pagination(page,page_size).subscribe({
      next:((response:ResultatCode<Lister>)=>{
        if(response.status==200){
          console.log(response);   
          this.listerProduit=response.data.produit  
          this.total=response.paginate.total 
          console.log(this.total);
          
        }
      })
    })
  }
  onChangePage(event:PageEvent){
    this.page=event.pageIndex+1;
    console.log(event);
    
    this.page_size=event.pageSize;
    this.getindex(this.page,this.page_size);
   
  }
  selectedOption(event:Event){
    const select=(event.target as HTMLSelectElement).value;
    this.libelle=select;

  }
  rechercher(){
    this.code=this.produitSuccursale.get('search')?.value  
  }
}
