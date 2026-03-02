<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Carte Professionnelle</title>

<style>

/* FORMAT EXACT */
@page {
    size: 85.6mm 54mm;
    margin: 0;
}
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

html, body {
    width: 85.6mm;
    height: 54mm;
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
}

 .card {
    position: relative;
    width: 85.6mm;
    height: 54mm;
    background: linear-gradient(145deg, #ffffff 0%, #f5f5f5 100%);
    border-radius: 8px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.3), 0 6px 6px rgba(0,0,0,0.2);
    overflow: hidden;
    padding: 12px 15px;
    display: flex;
    flex-direction: column;
    border: 1px solid #ddd;
} 
.carte::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 70px 70px 0; /* Taille du triangle */
            border-color: transparent #f57c00 transparent transparent;
            z-index: 1;
}
.infos {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

/* ANGLE ORANGE HAUT DROIT */
.corner {
    position: absolute;
    top: 0;
    right: 0;
    width: 18mm;
    height: 18mm;
    background: #f47c20;
    clip-path: polygon(100% 0, 0 0, 100% 100%);
}

/* PREMIERE LIGNE */
/* .top-line {
    /* display: flex; */
    justify-content: space-between;
    align-items: flex-start;
/* }  */

.top-left {
    width: 70%;
    float: left;
    /* flex: 1; */
   /* min-width: 0; */
}

.top-left h1 {
    margin: 0;
    font-size: 5mm;
    font-weight: 900;
}

.sub {
    font-size: 2.1mm;
    line-height: 1.3;
}

.top-right {
    width: 30%;
    float: right;
}

.logo {
    width: 18mm;
}

.slogan {
    font-size: 2mm;
    font-style: italic;
    margin-top: 1mm;
}

/* BADGE */
.badge {
    background: #f47c20;
    color: #fff;
    font-weight: bold;
    font-size: 3.5mm;
    /* padding: 1mm 2mm; */
    /* margin: 2mm 0; */
    display: inline-block;
}

/* CONTENU */
/* .main {
    display: flex;
    justify-content: space-between;
} */

.left {
    float: left;
}

.right {
    float: right;
}

.container::after {
    content: "";
    display: block;
    clear: both;
}

.signature-text {
    text-decoration: underline;
    font-style: italic;
}



.photo {
    width: 27mm;
    /* height: 32mm; */
    object-fit: cover;
    border: 2px solid #f47c20;
}

.matricule {
    margin-top: 1mm;
    font-size: 3mm;
    font-weight: bold;
    color: #f47c20;
}

/* CACHEt */
.cachet {
    position: absolute;
    bottom: 8mm;
    left: 60mm;
    width: 18mm;
    opacity: 0.9;
}

/* SIGNATURE IMAGE */
.signature-img {
    position: absolute;
    bottom: 10mm;
    left: 45mm;
    width: 25mm;
}

/* BANDE ORANGE BAS */
.footer-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 4mm;
    background: #f47c20;
}
.top-left {
    float: left;
}

.top-right {
    float: right;
}

.top-container::after {
    content: "";
    display: block;
    clear: both;
}
.container::after {
    /* content: "";
    display: block;
    clear: both; */
}
.contenu {
            flex: 1;
            display: flex;
            flex-direction: column;
            z-index: 2;
            position: relative;
        }
        .ligne-info {
            display: flex;
            font-size: 10px;
        }
        .label {
            width: 70px;
            font-weight: 700;
            color: #555;
        }

        .valeur {
            font-weight: 600;
            color: #1a2b3c;
        }

        .dates {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 9px;
            background: #eef2f5;
            padding: 6px 8px;
            border-radius: 4px;
        }

        .date-item {
            display: flex;
            flex-direction: column;
        }

        .date-label {
            font-weight: 700;
            color: #f57c00;
            font-size: 8px;
            text-transform: uppercase;
        }

        .date-valeur {
            font-weight: 600;
            color: #1a2b3c;
            font-size: 9px;
        }
        .photo-droite {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .photo-agent {
            width: 100%;
            height: 50px;
            background: #e0e0e0;
            border: 2px dashed #f57c00;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #666;
            text-align: center;
            font-weight: bold;
        }


</style>
</head>

<body>

<div class="card">

    <div class="corner"></div>

    <!-- PREMIERE LIGNE -->
    <div class="top-container">
        <div class="top-left"><h1>PROTEC-SÛR</h1>
            <div class="sub">
                Arrêté N 2021-0428/MSECU/CAB/DR du 31 Mai 2021<br>
                Secteur 30, Ouagadougou, BURKINA FASO<br>
                Tel : (+226) 71 07 09 09 / 76 34 12 12
            </div>
        </div>
        <div class="top-right">  
            <img src="{{ asset('images/logo.png') }}" class="logo">
            <div class="slogan">La protection par la vigilance</div></div>
    </div>
    <div class="badge" style="width: 100%">CARTE PROFESSIONNELLE</div> 

     <div class="contenu">
            <div class="infos">
                <div class="ligne-info">
                    <span class="label">Nom :</span>
                    <span class="valeur">{{ $person->nom }}</span>
                </div>
                <div class="ligne-info">
                    <span class="label">Prénom :</span>
                    <span class="valeur">{{ $person->prenom }}</span>
                </div>
                <div class="ligne-info">
                    <span class="label">Téléphone :</span>
                    <span class="valeur">{{ $person->telephone}}</span>
                </div>
                <div class="ligne-info">
                    <span class="label">Poste :</span>
                    <span class="valeur">{{ $person->poste}}</span>
                </div>
        <div class="right" style="border: 1px solid black">
            <img src="{{ asset($person->photo) }}" class="photo">
            <div class="matricule">
                N° {{ $person->matricule }}
            </div>
            
        </div>
        </div>
        <div class="dates">
            <div class="date-item">
                <span class="date-label">Délivrée le</span>
                <span class="date-valeur">29/11/2025</span>
            </div>
            <div class="date-item">
                <span class="date-label">Expire le</span>
                <span class="date-valeur">28/11/2026</span>
            </div>
            <div class="date-item">
                <span class="date-label">Signature</span>
                <span class="date-valeur"></span>
            </div>
        </div>
        <div class="photo-droite">
            <div class="photo-agent">
                PHOTO<br>AGENT
            </div>
        </div>

    </div>
    

    
    </div>
    {{-- <div class="container">
        <div class="left">
            <div><strong>Nom :</strong> {{ $person->nom }}</div>
            <div><strong>Prénom (s) :</strong> {{ $person->prenom }}</div>
            <div><strong>Qualité :</strong> {{ $person->poste }}</div>
            <div><strong>Téléphone :</strong> {{ $person->telephone }}</div>
            <div><strong>Délivrée le :</strong> {{ $person->date_delivrance }}</div>
            <div><strong>Expire le :</strong> {{ $person->date_expiration }}</div>
            <div class="signature-text">Signature</div>
        </div>

        <div class="right">
            <img src="{{ asset($person->photo) }}" class="photo">
            <div class="matricule">
                N° MATRICULE {{ $person->matricule }}
            </div>
        </div>

    </div> --}}

    <!-- SIGNATURE & CACHET -->

    {{-- <img src="{{ asset('images/signature.png') }}" class="signature-img">
    <img src="{{ asset('images/cachet.png') }}" class="cachet">

    <div class="footer-bar"></div> --}}

</div>

</body>
</html>