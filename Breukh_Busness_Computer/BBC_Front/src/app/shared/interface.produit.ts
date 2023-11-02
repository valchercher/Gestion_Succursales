export interface Interface {
}
export interface Response<T>{
    message:string
    status:number
    data:T[]
}
export interface ResultatCode<T>{
    message:string
    status:number
    paginate:Pagination
    data:T
}
export interface Pagination{
  
        current_page:number,
        total: number,
        per_page: number,
        last_page:number
}
export interface Root{
    produit:ProduitResponse
    succursale_produit:ProduitSuccursale[]
}
export interface ProduitSuccursale{
    id:number
    succursale_id:number
    produit_id:number
}
export interface ProduitResponse{
    id:number
    libelle:string
    code:number
    photo:string
    marque:Marque
    categorie:Marque
    succursales:Succursale[]
    caracteristiques:Caracteristique[]
}
export interface Marque {
    id: number,
    libelle: string
}

export interface Succursale{
    id:number
    nom:string
    adresse:string
    telephone:number,
    produit_succursale_id:number
    prix:number
    prixGlobal:number
    quantiteStock:number
}
export interface Caracteristique{
    id:number
    libelle:string
    valeur:number|string
    uniter?:string|null

}
export interface Commande{
    code:number
    prixVente:number,
    quantite:number,
    libelle:string,
    produit_succursale_id:number
    prix:number,
    prixGlobal:number,
    quantiteStock:number,
    total:number
}
export interface postId{
    idproduit?:number
    idsuccursale?:number
}
export interface CommandeRequest{
    reduction:number
    user_id:number,
    montant:number
    aPayer:number,
    client_id:number
    produit_succursales:Valeur[]
    
}
export interface Valeur{ 
    produit_succursale_id:number
    prix:number
    quantite:number
}
export interface changeQuantite{
    total:number,
    quantite:number
    libelle:string
    prix:number
    quantiteDisponible:number
}
export interface Panier{
    libelle:string
    quantite:number
    produit_succursale_id:number
    prix:number
    total:number
}