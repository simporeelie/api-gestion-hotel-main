<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation de Réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
        }
        p {
            margin: 0 0 1em;
        }
        ul {
            padding-left: 20px;
            margin: 0 0 1em;
        }
        a {
            color: #0056b3;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .confirmation-number {
            font-size: 1.5em;
            font-weight: bold;
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Bonjour <span>{{ $reservation->nom . ' ' . $reservation->prenom }}</span>,</p>
        <p>Le groupe hôtelier Whaakinyan vous remercie d'avoir effectué une réservation dans l'un de nos hôtels. Voici les détails de votre réservation :</p>

        <ul>
            <li>Hôtel : {{ $reservation->hotel->nom }}</li>
            <li>Chambres :
                <ul>
                    @foreach ($reservation->chambres as $chambre)
                        <li>{{ $chambre->typeChambre->libelle }} - {{ number_format($chambre->prix(), 2, ',', ' ') }} €</li>
                    @endforeach
                </ul>
            </li>
            <li>Date d'arrivée : {{ date('d/m/Y', strtotime($reservation->dateArrive)) }}</li>
            <li>Date de départ : {{ date('d/m/Y', strtotime($reservation->dateDepart)) }}</li>
            <li>Nombre d'enfants : {{ $reservation->nb_enfant }}</li>
            <li>Nombre d'adultes : {{ $reservation->nb_adulte }}</li>
        </ul>

        <p>Le montant total de votre réservation est de {{ number_format($reservation->chambres->sum(function($chambre) { return $chambre->prix(); }), 2, ',', ' ') }} $.</p>
        <p>Vous pouvez consulter votre réservation sur notre site web en cliquant sur le lien ci-dessous :</p>
        <p><a href="#">Voir ma réservation</a></p>

        <p>Voici votre numéro de confirmation :</p>
        <p class="confirmation-number">{{ $reservation->numConfirmation }}</p>

        <p>Merci pour votre confiance. Nous avons hâte de vous accueillir bientôt.</p>
    </div>
</body>

</html>
