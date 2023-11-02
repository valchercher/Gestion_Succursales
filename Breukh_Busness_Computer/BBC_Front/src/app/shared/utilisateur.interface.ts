import { Succursale } from "./interface.produit"

export interface utilisateur{
    email:string
    password:string
}
export interface response{
    status:number
    token:string
    message?:string,
    user:User
}
export interface User{
    id:number
    nom:string
    prenom:string
    email:string
    photo:string
    role:string
    succursale:Succursale
}