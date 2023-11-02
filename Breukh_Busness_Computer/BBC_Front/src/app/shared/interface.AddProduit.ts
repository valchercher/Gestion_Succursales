import { Caracteristique, Marque, ProduitResponse, Root } from "./interface.produit"

export interface ListProduit{
    message:string
    status:number
    data:Lister[]
}
export interface Lister{
    produit:ProduitResponse[]
    marque:Marque[]
    categorie:Marque[]
    caracteristiques:Caracteristique[]
    uniter:Marque[]
}
export interface RequestProduit{
    libelle:string
    photo:string
    marque_id:number
    categorie_id:number
    succursales:Succursales[]
    caracteristiques:Caracterists[]
}
export interface Succursales{
    succursale_id:number
    prix:number
    quantiteStock:number
}
export interface Caracterists{
    caracteristique_id:number
    valeur:string
    unite_id:number
    
}


