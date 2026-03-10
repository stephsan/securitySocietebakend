<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture</title>
    <style>
         @page {
        margin-top: 0;
        } 
        body { font-family: DejaVu Sans; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { border:1px solid #000; padding:8px; text-align:left; }
        .total { text-align:right; font-weight:bold; }
        .entete{
            margin-top:90px;
            text-align: center;
            color:rgb(10, 138, 40);
            font-weight: blod;
            margin-bottom: 55px;
        }
        .enteteGauche{
            margin: 0;
            float: left;
            width: 50%;
            text-align: left;
        }
        .entetedroite{
            margin: 0;
            float: right;
            width: 50%;
            text-align: right;
        }
        .adresse_boxe{
           width: 100%;
            border: 1px solid black;
            float:left;

        }
        .ligne_adresse{
            margin: 0 2px;
            font-weight: 600;
        }
        .titre_ligne_adresse{
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="entete">
        <div class="entetedroite">
            <img src="uploads/image_personne/img_contact_protect_sur.png" alt="" width="150" height="100">
        
        </div>
        <div class="enteteGauche">
            <img src="logo_protect_sur.png" alt="" width="150" height="100">
        </div>
    </div>


<div>
    <h3>FACTURE N° {{ $facture->numero_facture }} du {{ $facture->date_debut }} au {{ $facture->date_fin }}</h3>
</div>
<p><span>Doit : </span><span>{{  $facture->contrat->client->denomination }}</span></p>
<div class="adresse_boxe">
    <p class="ligne_adresse"><span>RCCM : </span><span>{{  $facture->contrat->client->numero_rccm }}</span></p>
    <p class="ligne_adresse"><span>IFU : </span><span>{{  $facture->contrat->client->numero_ifu }}</span></p>
    <p class="ligne_adresse"><span>REGIME D’IMPOSITION REGIME D’IMPOSITION : </span><span>{{  $facture->contrat->client->regime_fiscal }}</span></p>
    <p class="ligne_adresse"><span>DIVISION FISCALE : </span><span>{{  $facture->contrat->client->division_fiscale }}</span></p>
    <p class="ligne_adresse"><span>ADRESSE SIEGE : </span><span>{{  $facture->contrat->client->adresse_siege }}</span></p>
    <p class="ligne_adresse">  {{ $facture->contrat->client->section }}</span></p>
    <p class="ligne_adresse"><span>BOITE POSTALE : </span><span>{{  $facture->contrat->client->boite_postale }}</span></p>
    <p class="ligne_adresse"><span>TELEPHONE FIXE : </span> <span>{{  $facture->contrat->client->telephone }}</span><span>TELEPHONE Mobile : </span><span>{{  $facture->contrat->client->telephone_mobile }}</span></p>
    <p class="ligne_adresse"><span>E- maiL : </span><span>{{  $facture->contrat->client->email }}</span></p>


</div>

<p>
    Client : {{ $facture->contrat->client->denomination }} <br>

</p>

<table>
    <thead>
        <tr>
            <th>Prestation</th>
            <th>Quantité</th>
            <th>Montant</th>
            <th>Nombre Jrs</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facture->lignes as $ligne)
        <tr>
            <td>{{ $ligne->prestation->nature->libelle }}</td>
            <td>{{ $ligne->quantite }}</td>
            <td>{{ $ligne->montant }}</td>
            <td>{{ $ligne->nombre_de_jour_facture }}</td>
            <td style="width: 20%">{{ $ligne->montant_total}}</td>
        </tr>
       
        @endforeach
    </table>
<table style="margin-top: 0px">
        <tr>
            <td style="width: 80%">MONTANT TOTAL Hors Taxes</td>
            
            <td style="width: 20%">{{ $facture->montant_total }}</td>
          
        </tr>
        <tr>
            
            <td style="width: 80%">Retenue à la source 5%</td> 
            <td style="width: 20%">{{ $facture->montant_total * 5/100 }}</td>
        </tr>
        <tr>
            <td style="width: 80%">MONTANT A PAYER</td> 
            <td style="width: 20%">{{ $facture->montant_total - $facture->montant_total * 5/100 }}</td> 
        </tr>
    </tbody>
</table>

<p class="total">
    <span >Arrêter la présente facture définitive à la somme de  :</span> <span>{{ int2str($facture->montant_total -  $facture->montant_total*5/100) }} ({{ $facture->montant_total -  $facture->montant_total*5/100}}) FCFA TTC</span> 
</p>
<div>
    <div class="enteteGauche">
        <img src="data:image/png;base64,{{ $qrCode }}" width="120">
    </div>
    <div class="entetedroite">
            <p>RAF </p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p> Mme TRAORE/KABORE Angélique</p>

        </div>
</div>

</div>
{{-- <div style="text-align:right;">
    <img src="data:image/png;base64,{{ $qrCode }}" width="120">
</div> --}}
</body>
</html>