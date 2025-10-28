<?php
class subPageCreator
{
    public function createSubpage(
        $ISBN,
        $Price,
        $Author,
        $Genre,
        $Name,
        $PublishYear,
        $Description,
        $Type,
        $FilePath
    ) {
        $filename = preg_replace('/[^a-zA-Z0-9]/', '_', $Name);
        // Original variable value
        $originalValue = "../../../about-me.php";

        $FilePath = str_replace("../../../", "", $FilePath);

        if (strtolower($Author) != ("ute schuler")) {
            $authorSearch = urlencode($Author);
            $authorLink = "https://www.google.com/search?q=" . $authorSearch;
        } else {
            $authorLink = "about-me.php";
        }



        $subpageContent = "
            <!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <title>{$Name}</title>
                <link rel=\"stylesheet\" href=\"css/bookSubpage/normalGridStyle.css\">
                <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
                <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
                <link href=\"https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap\" rel=\"stylesheet\">
                <link href=\"https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap\" rel=\"stylesheet\">

                <script src=\"js/bookSubpage.js\"></script>
                <script src=\"https://www.paypal.com/sdk/js?client-id=<?php echo getenv('PAYPAL_CLIENT_ID') ?: 'REPLACE_ME'; ?>&currency=EUR&locale=de_DE\"></script>
                <script src=\"js/paypalAPI.js\"></script>
            </head>
            <body>
                <?php
                    include('includes/navbar.php');
                ?>
                <div class=\"content\">
                    <div id=\"bookID\" style=\"display: none;\">\"{$ISBN}\"</div>

                    <div class=\"TitleContent\">
                        <img class=\"dynamicDissapearImage\" src=\"{$FilePath}\" alt=\"{$Name}.jpg\">
                        <div class=\"TextInfoSubpageColumn\">
                            <h1>{$Name}</h1>
                            <p>von <a href=\"{$authorLink}\">{$Author}</a> (Autor, Illustrator) &#124; Format: {$Type}</p>
                            <img class=\"dynamicAppearImage\" src=\"{$FilePath}\" alt=\"{$Name}.jpg\">
                            <p class=\"DescriptionTextBook\" id=\"descriptionText\">
                                {$Description}
                            </p>
                            <hr>
                            <div class=\"paypalPaymentField\" id=\"paypal\">
                            </div>
                        </div>
                        <div class=\"InformationenSpalte\">
                            <p>
                                <button id=\"addToCartButton\" onclick=\"showNotification()\">Einkaufswagen</button>
                            </p>
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
                                {$PublishYear}
                            </h3>
                            <hr>
                            <p>
                                Typ:
                            </p>
                            <h3>
                                {$Type}
                            </h3>
                            <hr>
                            <p>
                                Preis:
                            </p>
                            <h3 id=\"price\">
                                {$Price} &euro;
                            </h3>
                            <hr>
                            <div id=\"notification\" class=\"hidden\">Das Buch wurde zum Einkaufswagen hinzugefügt</div>

                        </div>
                    </div>
                </div>
                <?php
                    include('includes/footer.php');
                ?>
            </body>
            </html>
        ";

        $rootFolder = $_SERVER['DOCUMENT_ROOT'];

        $subpagePath = $rootFolder . '/' . $filename . '.php';

        file_put_contents($subpagePath, $subpageContent);


        $subpagePath = basename($subpagePath);

        return $subpagePath;
    }
}
