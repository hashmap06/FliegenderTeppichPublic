
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Atomic Habits</title>
                <link rel="stylesheet" href="css/bookSubpage/normalGridStyle.css">
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
                <script src="js/bookSubpage.js"></script>
                <script src="https://www.paypal.com/sdk/js?client-id=<?php echo getenv('PAYPAL_CLIENT_ID') ?: 'REPLACE_ME'; ?>&currency=EUR&locale=de_DE"></script>
                <script src="js/paypalAPI.js"></script>
            </head>
            <body>
                <?php
                    include('../templates/includes/navbar.php');
                ?>
                <div class="content">
                    <div id="bookID" style="display: none;">"9781847941831"</div>

                    <div class="TitleContent">
                        <img class="dynamicDissapearImage" src="uploads/atomichabitsbookcover.jpg" alt="Atomic Habits.jpg">
                        <div class="TextInfoSubpageColumn">
                            <h1>Atomic Habits</h1>
                            <p>von <a href="https://www.google.com/search?q=James+Clear">James Clear</a> (Autor, Illustrator) &#124; Format: realBook</p>
                            <img class="dynamicAppearImage" src="uploads/atomichabitsbookcover.jpg" alt="Atomic Habits.jpg">
                            <p class="DescriptionTextBook" id="descriptionText">
                                People think that when you want to change your life, you need to think big. But world-renowned habits expert James Clear has discovered another way. He knows that real change comes from the compound effect of hundreds of small decisions: doing two push-ups a day, waking up five minutes early, or holding a single short phone call.

He calls them atomic habits.

In this ground-breaking book, Clears reveals exactly how these minuscule changes can grow into such life-altering outcomes. He uncovers a handful of simple life hacks (the forgotten art of Habit Stacking, the unexpected power of the Two Minute Rule, or the trick to entering the Goldilocks Zone), and delves into cutting-edge psychology and neuroscience to explain why they matter. Along the way, he tells inspiring stories of Olympic gold medalists, leading CEOs, and distinguished scientists who have used the science of tiny habits to stay productive, motivated, and happy.
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
                                2018
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
                            <h3 id="price">
                                17.09 &euro;
                            </h3>
                            <hr>
                            <p>
                                <button id="addToCartButton" onclick="showNotification()">Einkaufswagen</button>
                            </p>
                            <div id="notification" class="hidden">Das Buch wurde zum Einkaufswagen hinzugefügt</div>

                        </div>
                    </div>

                </div>
                <?php
                    include('../templates/includes/footer.php');
                ?>
            </body>
            </html>
        