<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .invoice {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-body {
            margin-bottom: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .invoice-total {
            margin-top: 20px;
            text-align: right;
        }
        .telephone {
            display: flex;
            justify-content: space-around;
        }

        .telephone  {
            flex: 1;
        }
        .div > p {
            display: inline-block;
            margin-right: 100px; 
        }


    </style>
</head>
<body>

    <div class="invoice">
        <div>
            <img src="./image/65044dd6c3962.png" alt="" srcset="">
        </div>
        <div class="invoice-header">
            <h2>Facture </h2>
            <p>Date:{{now()}}</p>
        </div>
        <div class="telephone">
            <div class="div" >
                <p><strong>De: </strong> {{$commande->toArray($request)['user']->toArray($request)['succursale_id']['nom']}}</p>
                <p><strong>Tel: </strong>{{$commande->toArray($request)['user']->toArray($request)['succursale_id']['telephone']}}</p>
                
            </div>
            <div class="div">
                <p><strong>À: </strong> {{$commande->user->prenom." ".$commande->user->nom}}</p>
                <p><strong>Tel: </strong> {{$commande->user->login}}</p>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @php
                $commandeItems = $commande->toArray($request)['commande'];
            @endphp
                <!-- Lignes de la facture -->
                @foreach($commandeItems as $item)
                <tr>
                        <td>{{$item->toArray($request)['produit']['libelle']}}</td>
                        <td>{{$item->toArray($request)['prixVente']}}</td>
                        <td>{{$item->toArray($request)['quantite']}}</td>
                        <td>{{$item->toArray($request)['prixVente'] * $item->toArray($request)['quantite'] }} FCFA</td>
                    </tr>
                @endforeach
               
                <!-- ... Ajoutez plus de lignes au besoin -->
            </tbody>
        </table>

        <div class="invoice-total">
            <p><strong>Total:</strong> {{$total}} FCFA</p>
        </div>
    </div>


</body>
</html>
