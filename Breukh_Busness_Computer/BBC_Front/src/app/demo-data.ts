// import { ProduitResponse } from "./shared/interface.produit";

import { Root } from "./shared/interface.produit";

// export const data:ProduitResponse= {
//   id: 8,
//   libelle: "MACBook Business Laptop",
//   photo: "https://cqpm.fr/wp-content/uploads/2022/03/ordinateur-puissant.jpg",
//   code: 26934543,
//   succursales: [
//       {
//           id: 1,
//           nom: "Global",
//           telephone: 330110202,
//           adresse: "Kaolack",
//           prix: 750000,
//           prixGlobal: 7200000,
//           quantiteStock:2
//       },
//   ],
//   caracteristiques:[
//       {
//           id: 1,
//           libelle: "Disque SSD",
//           description: "intel UHD Graphics",
//           valeur: "32 Go",
         
//       },
//       {
//           id: 3,
//           libelle: "Couleur",
//           description: "'",
//           valeur: "gray",
         
//       }
//   ]
// }
export const data:Root={
        produit: {
            id: 8,
            libelle: "MACBook Business Laptop",
            photo: "https://cqpm.fr/wp-content/uploads/2022/03/ordinateur-puissant.jpg",
            code: 26934543,
            marque: {
                id: 2,
                libelle: "LENOVO"
            },
            categorie: {
                id: 1,
                libelle: "Ordinateur portable"
            },
            succursales: [
                {
                    id: 1,
                    nom: "Global",
                    telephone: 330110202,
                    adresse: "Kaolack",
                    produit_succursale_id:1,
                    prix: 750000,
                    prixGlobal: 7200000,
                    quantiteStock: 0
                }
            ],
            caracteristiques: [
                {
                    id: 1,
                    libelle: "Disque SSD",
                    valeur: "32 Go",
                    uniter: null
                },
                {
                    id: 3,
                    libelle: "Couleur",
                    valeur: "gray",
                    uniter: null
                }
            ]
        },
        succursale_produit: [
            {
                id: 15,
                succursale_id: 1,
                produit_id: 8
            },
            {
                id: 16,
                succursale_id: 2,
                produit_id: 8
            },
            {
                id: 17,
                succursale_id: 5,
                produit_id: 8
            },
            {
                id: 18,
                succursale_id: 7,
                produit_id: 8
            }
        ]
    }

    export const couleurs=["rouge","vert","bleu","jaune","gris","noir","blanc","viollet","rose"]
    export const uniter=["GO","MO","KO","MG","T"];
    export const valeurs=["16","32","64","112","145","256","500"];