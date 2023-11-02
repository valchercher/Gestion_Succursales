import { Injectable } from '@angular/core';
import { response, utilisateur } from '../shared/utilisateur.interface';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment.development';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  get token (){
    return localStorage.getItem('ACCESS_TOKEN');
  }
  constructor(private _http:HttpClient) { }
  public seConnecter(userInfo: utilisateur):Observable<response>{
    return this._http.post<response>(`${environment.url}user`,userInfo);
  }
  public estConnecte(){
    return localStorage.getItem('ACCESS_TOKEN') !== null;
  }
  public deconnecter(){
    localStorage.removeItem('ACCESS_TOKEN');
    return this._http.post(`${environment.url}logout`,this.token);
  }
 public getUser(){
  return localStorage.getItem('user');
 }
}
