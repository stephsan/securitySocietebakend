<style>
    @page {
        margin: 0;
    }
    
    body {
        margin: 0;
        padding: 0;
    }
    
    .carte {
        position: relative;
        border: 2px solid #003366;
        padding: 2px;
        box-sizing: border-box;
        overflow: hidden;
    }
    
    /* FILIGRANE */
    .filigrane {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    
        display: flex;
        justify-content: center;
        align-items: center;
    
        font-size: 35px;
        font-weight: bold;
        color: #000;
        opacity: 0.07;
    
        transform: rotate(-30deg);
        z-index: 0;
    }
    .header {
            background: #003366;
            color: white;
            text-align: center;
            padding: 2px;
            font-weight: bold;
        }
        .photo {
            width: 150px;
            height: 70px;
            object-fit: cover;
            float: right;
        }
    .contenu {
        position: relative;
        z-index: 1;
    }
    </style>
    
    <div class="carte">
    
        <div class="filigrane">
            CARTE OFFICIELLE
        </div>
        <div class="contenu">

        <div class="header">
            CARTE PROFESSIONNELLE
        </div>
            @if($person->image)
                <img src="{{'uploads/image_personne/'.$person->image }}" class="photo" >
            @endif
            <p><strong>Matricule :</strong> {{ $person->matricule }}</p>
            <p><strong>Nom :</strong> {{ $person->nom }}</p>
            <p><strong>Prénom :</strong> {{ $person->prenom }}</p>
            <p><strong>Poste :</strong> {{ $person->poste }}</p>
        </div>
    
    </div>