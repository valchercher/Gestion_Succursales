import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment.development';
import { ResultatCode } from '../shared/interface.produit';
import { Observable } from 'rxjs';
import { Lister, RequestProduit } from '../shared/interface.AddProduit';

@Injectable({
  providedIn: 'root'
})
export class ProduitServiceService  {

  constructor(private _http:HttpClient) { }
  index():Observable<ResultatCode<Lister>>{
    return this._http.get<ResultatCode<Lister>>(`${environment.url}index/produit`)
  }
  store(data:RequestProduit):Observable<ResultatCode<Lister>>{
    return this._http.post<ResultatCode<Lister>>(`${environment.url}store/produit`,data);
  }
  pagination(page:number,pase_size?:number):Observable<ResultatCode<Lister>>{
    return this._http.get<ResultatCode<Lister>>(`${environment.url}pagination/${pase_size}?page=${page}`)
  }
}
