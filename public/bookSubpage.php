<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bookSubpage/normalGridStyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="js/bookSubpage.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo getenv('PAYPAL_CLIENT_ID') ?: 'REPLACE_ME'; ?>"></script>
    <script src="js/paypalAPI.js"></script>

</head>

<body>
    <?php
    include('../templates/includes/navbar.php');
    ?>
    <div class="content">
        <div class="TitleContent">
            <img class="dynamicDissapearImage" src="../uploads/JohanneFühltSichUngerechtBehandelt.jpg" alt="BookBanner.jpg">

            <div class="TextInfoSubpageColumn">
                <h1>
                    Johanna fühlt sich ungerecht behandelt
                </h1>
                <p>
                    von <a href="../../../about-me.php">Ute Kristin Schuler</a> (Autor, Illustrator) &#124; Format: Kindle Ausgabe
                </p>
                <img class="dynamicAppearImage" src="../uploads/JohanneFühltSichUngerechtBehandelt.jpg" alt="BookBanner.jpg">
                <p class="DescriptionTextBook" id="descriptionText">
                    Johanna versteht die Welt nicht mehr: es scheint wie ein böser Zauber: Alle Missgeschicke und Ungerechtigkeiten der jüngsten Zeit treffen immer nur eine: sie selbst.
                    Sie wird bestraft, nachdem eine Mitschülerin sie zum Reden im falschen Augenblick provoziert hat. Kaum hat Johanna diese Ungerechtigkeit verdaut, ist da die Klassenarbeit, bei der ihr Lehrer ausgerechnet ihre Arbeit früher als die der anderen zur Korrektur einzieht -- was Johanna ein selten schlechtes Ergebnis beschert. Eine Woche später dann kopiert eine Klassenkameradin im Kunstunterricht Johannas Bild. Während Johanna selbst von der Vertretungslehrerin des Abmalens beschuldigt wird, genießt die Abmalerin unverdiente Anerkennung.

                    Johanna hadert mit diesen Vorkommnissen - und sucht Rat bei ihrer Familie. Dort sind die Ansichten und Ratschläge durchaus unterschiedlich, wie Johanna sich am besten verhalten sollte. Aber die Gespräche helfen ihr, sich die Ursachen und Grenzen dieser Ungerechtigkeiten bewusst zu machen, und ermutigen sie dazu, selbst Lösungen zu finden.

                    Diese Geschichte ist in vier Kapitel gegliedert und enthält fünf Farbabbildungen.

                    In der Reihe "Sei Du selbst" sind weitere Geschichten zu ähnlichen Themen erschienen.
                </p>
                <hr>
                <div class="paypalPaymentField" id="paypal">
                </div>
            </div>
            <div class="InformationenSpalte">
                <hr>
                <p>
                    Lesealter:
                </p>
                <h3>
                    8-12 Jahre
                </h3>
                <hr>
                <p>
                    Originalsprache:
                </p>
                <h3>
                    Deutsch
                </h3>
                <hr>
                <p>
                    Erscheinungsdatum:
                </p>
                <h3>
                    14. Januar 2016
                </h3>
                <hr>
                <p>
                    Typ:
                </p>
                <h3>
                    eBook
                </h3>
                <hr>
                <p>
                    Preis:
                </p>
                <h3>
                    10.00 &euro;
                </h3>
            </div>
        </div>
        <?php
        include('../templates/includes/footer.php');
        ?>
    </div>
</body>

</html>