
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>a book name</title>
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
                    <div id="bookID" style="display: none;">"653 763 721 098 2"</div>
                    <div class="TitleContent">
                        <img class="dynamicDissapearImage" src="uploads/MaxHoltSprudel.jpg" alt="a book name.jpg">
                        <div class="TextInfoSubpageColumn">
                            <h1>a book name</h1>
                            <p>von <a href="about-me.php">sophia</a> (Autor, Illustrator) &#124; Format: realBook</p>
                            <img class="dynamicAppearImage" src="uploads/MaxHoltSprudel.jpg" alt="a book name.jpg">
                            <p class="DescriptionTextBook" id="descriptionText">
                                in this normal book, something happens
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
                                2023
                            </h3>
                            <hr>
                            <p>
                                Typ:
                            </p>
                            <h3>
                                realBook
                            </h3>
                            <hr>
                            <p>
                                Preis:
                            </p>
                            <h3>
                                14.99 &euro;
                            </h3>
                        </div>
                    </div>
                    <?php
                        include('../templates/includes/footer.php');
                    ?>
                </div>
            </body>
            </html>
        