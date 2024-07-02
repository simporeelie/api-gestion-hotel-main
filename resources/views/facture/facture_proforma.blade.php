<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h1>{{ $title }}</h1>
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                               {{ $reservation->hotel->libelle}}
                            </td>
                            <td>
                                {{ $reservation->hotel->ville }}, le {{ $date }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ $reservation->hotel->rue }}<br>
                                {{ $reservation->hotel->code_postale }} {{ $reservation->hotel->ville }}<br>
                                Téléphone : {{ $reservation->hotel->telephone }}<br>
                                Courriel : {{ $reservation->hotel->email }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Facture N° {{ $reservation->id }}
                </td>
                <td>
                    Qté
                </td>
                <td>
                    PU TTC
                </td>
                <td>
                    Montants
                </td>
            </tr>
            <tr class="item">
                <td>
                    Nuitées du {{ $reservation->dateArrive }} au {{ $reservation->dateDepart }}
                </td>
                <td>
                    {{ $reservation->qteNuite() }}
                </td>
                <td>
                    {{ $reservation->prixU_NuiteTTC() }}
                </td>
                <td>
                    {{ $reservation->prixT_NuiteTTC() }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td>
                    Total TTC:
                </td>
                <td>
                    {{ $reservation->totalTT() }} $
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr class="heading">
                <td>Total TVA à {{ $tva }} % :</td>
            </tr>
        </table>
        <p>Paiement au {{ $date }}</p>
    </div>
</body>

</html>
