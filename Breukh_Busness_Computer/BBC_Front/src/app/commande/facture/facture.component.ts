import * as pdfMake from 'pdfmake/build/pdfmake'
import * as pdfFonts from 'pdfmake/build/vfs_fonts'
import { Component, Input, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup } from '@angular/forms';
(pdfMake as any).vfs=pdfFonts.pdfMake.vfs
@Component({
  selector: 'app-facture',
  templateUrl: './facture.component.html',
  styleUrls: ['./facture.component.css']
})
export class FactureComponent implements OnInit{
  
  facture:FormGroup;
  montant:number=0;
  constructor(private fb:FormBuilder){
    this.facture=this.fb.group({
      montant:[],
      donneeCommande:this.fb.array([])
    })
  }
  ngOnInit(): void {
    
  }
  get donneeCommandes():FormArray{
    return this.facture.get('donneeCommande') as FormArray;
  }
  generatePdf(){
    let docDefinition={
      content:[
        'this is a sample PDF printed with pdfMake'
      ]
    }
    pdfMake.createPdf(this.facture.value).download();
  }
}
