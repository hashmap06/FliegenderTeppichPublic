<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About this Site</title>
    <link rel="stylesheet" href="css/about-this-page/versand.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    //$currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>

    <div class="content">
        <div class="versandInfos">
            <h2>
                Allgemeine Informationen zum Versand:
            </h2>
            <p>
                Bitte nach Bestellung das gewünschte Motiv benennen.
                Expressversandoptionen bitte per email anfragen:
                <br>
                <a href="mailto:ute.k.schuler@gmail.com?bcc=fliegenderteppichverlag@gmail.com&body=Schreiben Sie hier Ihre Fragen zu FliegenderTeppichs Shop und Versandinformationen.">Kontaktiere uns für Versandinformationen</a>
            </p>
            <h2>
                Spezielle Hinweise zum Versand ins Ausland:
            </h2>
            <p>
                Bei Lieferungen in das Ausland können Zölle, Steuern und Gebühren anfallen, die im angezeigten Gesamtpreis nicht enthalten sind.
            </p>
            <h2>
                Länder, in die versendet wird:
            </h2>
            <p><b>Standart Versandkosten:</b></p>
            <hr>

            <p class="shippingPriceField">
                Deutschland <span class="priceTag"><b>2,99 &euro;</b></span>
            </p>
            <h2>Bezahlmethoden:</h2>
            <div class="paymentOptionsList">
                <ul>
                    &bull; <span style="font-weight: bold;">PayPal (Kreditkarte, Lastschrift, Überweisung)</span>
                    <br>Bei Auswahl dieser Zahlungsart erfolgt im nächsten Schritt die Weiterleitung zu PayPal. Wenn dort die erforderlichen Daten eingetragen worden sind, geht es automatisch zurück in diesen Shop, um die Bestellung abzuschließen.
                </ul>
                <br>
                <br>
                <ul>
                    &bull; <span style="font-weight: bold;">Zahlung per E-Mail</span>
                    <br>Bei Auswahl dieser Zahlungsart erhalten Sie eine E-Mail mit den Zahlungsinformationen. Bitte senden Sie Ihre Anfrage an ute.k.schuler@gmail.com.
                </ul>
            </div>
            <br>
            <hr>
            <div class="moreQuestionsLink">
                <h2>Mehr Fragen?</h2>
                <form action="contact.php">
                    <button type="submit" class="submitButton">Hinterlassen Sie eine Nachricht</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    include('../templates/includes/footer.php');
    ?>
</body>

</html>