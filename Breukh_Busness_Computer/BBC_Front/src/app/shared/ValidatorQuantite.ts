import { AbstractControl } from "@angular/forms";

 export function validationQuantite(control:AbstractControl):{[key:string]:string}|null{
    const qte=control.value;
    const qteDisponible=control.parent?.get('quantiteStock')?.value;
    if(qte && qteDisponible){
      const diff=qteDisponible-qte;
      if(diff<0){
        return {'error':`Quantite  disponible: ${qteDisponible}`}
      }
    }
    return null;
  }