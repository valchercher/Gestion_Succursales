import { Pipe, PipeTransform } from '@angular/core';
import { ProduitResponse } from '../shared/interface.produit';

@Pipe({
  name: 'filtre'
})
export class FiltrePipe implements PipeTransform {

  transform(value: ProduitResponse[], search:number|string,text:string|number):ProduitResponse[]{
    if(!value){
      return [];
    }
    if(!search){
      return value;
    }
    return value?.filter((element:any)=>{ 
      if(element && element[text]){     
        return element[text].includes(search)
      }
      return false;
    })
  }

}
