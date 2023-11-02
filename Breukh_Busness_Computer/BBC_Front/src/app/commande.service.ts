import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment.development';
import { CommandeRequest, ProduitResponse, Response, ResultatCode, Root } from './shared/interface.produit';

@Injectable({
  providedIn: 'root'
})
export class CommandeService {

  constructor(private _http:HttpClient ) {}

  index():Observable<Response<ProduitResponse>>{
    return this._http.get<Response<ProduitResponse>>(`${environment.url}index/produit`);
  }
  search(code:number,id:number):Observable<ResultatCode<Root>>{
    return this._http.get<ResultatCode<Root>>(`${environment.url}search/produit/${code}/succursale/${id}`);
  }
  getIdProduitSuccursales(idproduit?:number,idsuccursale?:number):Observable<number>{
    return this._http.get<number>(`${environment.url}prodSucc/${idproduit}/${idsuccursale}`);
  }
  store(data:CommandeRequest):Observable<Response<CommandeRequest>>{
    return this._http.post<Response<CommandeRequest>>(`${environment.url}store/commande`,data)
  }
}
