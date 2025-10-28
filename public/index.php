<?php
header('ngrok-skip-browser-warning: 69420');

require_once '../src/db/database_handler/weekDayAccess.classes.php';

$wochentageDb = new WochentageDb();
$wochentageDb->updateWochentage(false); // nichtangemeldet
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FliegenderTeppich Startseite</title>
    <meta name="description" content="Explore Ute Schuler's Fliegender Teppich bookshop, featuring a collection of unique, handcrafted books. Dive into the magical world of Ute Schuler's literary creations.">
    <link rel="stylesheet" href="css/index/index.style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link rel="icon" type="image/png" href="../img/png icons/FliegenderTeppich-logo1.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@500&display=swap" rel="stylesheet">
</head>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">

<body>

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>

    <div class="content">

        <div class="inner-content-overflow">

            <div class="upper-segment">
                <div class="banner">
                    <div class="typing-text">
                        <span id="welcome"></span>
                        <span id="dot">VERLAG</span>
                    </div>
                </div>
                <div class="banner-carousel-connect"></div>

            </div>

            <div class="outer-carousel-book">
                <div class="books-carousel">
                    <!-- Original set of slides -->
                    <div class="book-slide"><a href="https://www.osiander.de/shop/home/artikeldetails/A1038802374"><img src="uploads/JanMussZahlen.jpg" alt="Jan Muss Zahlen"></a></div>
                    <div class="book-slide"><a href="https://www.osiander.de/shop/home/artikeldetails/A1038796774"><img src="uploads/KarolineInDerKlemme.jpg" alt="Karoline in der Klemme"></a></div>
                    <div class="book-slide"><a href="Familiengeschichten.php"><img src="uploads/FamilienGeschichten.jpg" alt="Familiengeschichten"></a></div>
                    <div class="book-slide"><a href="https://www.thalia.de/shop/home/artikeldetails/A1038802357"><img src="uploads/JohanneFühltSichUngerechtBehandelt.jpg" alt="Johanne fühlt sich ungerecht behandelt"></a></div>
                    <div class="book-slide"><a href="Max_holt_Sprudel.php"><img src="uploads/MaxHoltSprudel.jpg" alt="Max holt Sprudel"></a></div>
                    <!-- Duplicates -->
                    <div class="book-slide"><a href="https://www.osiander.de/shop/home/artikeldetails/A1038802374"><img src="uploads/JanMussZahlen.jpg" alt="Jan Muss Zahlen"></a></div>
                    <div class="book-slide"><a href="https://www.osiander.de/shop/home/artikeldetails/A1038796774"><img src="uploads/KarolineInDerKlemme.jpg" alt="Karoline in der Klemme"></a></div>
                    <div class="book-slide"><a href="Familiengeschichten.php"><img src="uploads/FamilienGeschichten.jpg" alt="Familiengeschichten"></a></div>
                    <div class="book-slide"><a href="https://www.thalia.de/shop/home/artikeldetails/A1038802357"><img src="uploads/JohanneFühltSichUngerechtBehandelt.jpg" alt="Johanne fühlt sich ungerecht behandelt"></a></div>
                    <div class="book-slide"><a href="Max_holt_Sprudel.php"><img src="uploads/MaxHoltSprudel.jpg" alt="Max holt Sprudel"></a></div>
                    <!-- *2 -->
                    <div class="book-slide"><a href="https://www.osiander.de/shop/home/artikeldetails/A1038802374"><img src="uploads/JanMussZahlen.jpg" alt="Jan Muss Zahlen"></a></div>
                    <div class="book-slide"><a href="https://www.osiander.de/shop/home/artikeldetails/A1038796774"><img src="uploads/KarolineInDerKlemme.jpg" alt="Karoline in der Klemme"></a></div>
                    <div class="book-slide"><a href="Familiengeschichten.php"><img src="uploads/FamilienGeschichten.jpg" alt="Familiengeschichten"></a></div>
                    <div class="book-slide"><a href="https://www.thalia.de/shop/home/artikeldetails/A1038802357"><img src="uploads/JohanneFühltSichUngerechtBehandelt.jpg" alt="Johanne fühlt sich ungerecht behandelt"></a></div>
                    <div class="book-slide"><a href="Max_holt_Sprudel.php"><img src="uploads/MaxHoltSprudel.jpg" alt="Max holt Sprudel"></a></div>
                </div>
            </div>

            <div class="middle-segment">
                <div class="banner-carousel-connect-reverse"></div>
            </div>
            <div class="general-information-section">
                <section class="book-section">
                    <header class="book-header">
                        <h1>Für große und kleine Leser und Zuhörer:<br></h1>
                        <h2>Familiengeschichten</h2>
                    </header>
                    <div class="book-intro">
                        <h3>Erlebnisse aus dem Familienleben: <br>
                            Kleine Geschichten für Groß und Klein</h3>
                        <p class="book-description">
                            Liebevoll illustriert von meinen Kindern, bieten diese Geschichten Einblicke in unseren familiären Alltag. Sie eignen sich perfekt als Gutenachtgeschichten, um die Fantasie anzuregen und süße Träume zu bescheren.
                        </p>
                    </div>
                    <div class="book-age-recommendation">
                        <h5>Geeignet ab 6 Jahren, eigentlich ein Buch für die ganze Familie. Geeignet zum Vorlesen oder Selbstlesen.</h5>
                    </div>
                    <div class="book-cover">
                        <img src="uploads/FamilienGeschichten.jpg" alt="Cover of Familiengeschichten">
                    </div>
                    <div class="book-details">
                        <p>
                            Was wäre ein Familienleben ohne die kleinen Begebenheiten, die es täglich bereichern - auch dann, wenn solche Bereicherungen nicht immer sofort jedes Familienmitglied beglücken! Die Geschichten dieses Buchs beruhen auf tatsächlich Erlebtem. Und wurden mit ein paar Prisen dichterischer Freiheit abgeschmeckt...
                        </p>
                    </div>
                    <hr class="book-divider">
                    <div class="ebook-information">
                        <h3>Jetzt als e-Book erhältlich: Sammelband "Sei Du selbst"</h3>
                        <ul class="ebook-titles">
                            <li>1. "Johanna fühlt sich ungerecht behandelt"</li>
                            <li>2. "Karoline in der Klemme"</li>
                            <li>3. "Jan muss zahlen"</li>
                        </ul>
                        <p>Jetzt in Kindle- und Tolino-Formaten verfügbar, finden Sie alle Bücher auf führenden Buchplattformen wie Hugendubel.de, Osiander.de, Buch.de und Amazon.<br></p>
                        <div class="book-links">
                            &bull; <a href="https://www.amazon.de/Johanna-f%C3%BChlt-ungerecht-behandelt-selbst-ebook/dp/B01B1KJRSS/ref=sr_1_1?ie=UTF8&qid=1454146441&sr=8-1&keywords=Johanna+f%C3%BChlt+sich+ungerecht+behandelt">Johanna fühlt sich ungerecht behandelt (Amazon)</a><br>
                            &bull; <a href="https://www.amazon.de/Karoline-Klemme-Sei-Du-selbst-ebook/dp/B01B1QM7CU/ref=sr_1_1?ie=UTF8&qid=1454146508&sr=8-1&keywords=Karoline+in+der+Klemme">Karoline in der Klemme (Amazon)</a><br>
                            &bull; <a href="https://www.amazon.de/Jan-muss-zahlen-Sei-selbst-ebook/dp/B01B25PQAU/ref=sr_1_1?ie=UTF8&qid=1454146579&sr=8-1&keywords=Jan+muss+zahlen">Jan muss zahlen (Amazon)</a><br>
                            &bull; <a href="https://www.thalia.de/shop/home/artikeldetails/A1038802357">Thalia Link</a><br>
                            &bull; <a href="https://www.buecher.de/shop/ebooks/karoline-in-der-klemme-ebook-epub/schuler-ute-kristin/products_products/detail/prod_id/44502942/">Bücher.de Link</a><br>
                            &bull; <a href="https://www.osiander.de/shop/home/artikeldetails/A1038802374">Osiander Link</a>
                        </div>
                        <p class="book-target-audience">
                            Die Geschichten richten sich an Leser zwischen acht und zwölf Jahren.
                            Themenschwerpunkt ist der Umgang mit Ungerechtigkeit und Unrecht.
                            Die Erzählungen ermutigen Kinder zum bewussten Umgang mit erlebtem Unrecht:
                            Kleine Ungerechtigkeiten zu ertragen oder große ans Licht zu befördern und diese zu lösen.
                            Alle e-Bücher sind in Kapitel gegliedert und enthalten Illustrationen.<br>
                            Preis je Band: 2,99
                            Mehr in: <br>
                            <a href="https://fliegenderteppich.org/aboutShipping.php">Über Versand</a>
                            <br>
                        </p>
                    </div>
                    <hr style="width: 100%">
                    <div class="additional-book">
                        <h3><a href="Max_holt_Sprudel.php">"Max holt Sprudel"</a></h3>
                        <p class="additional-book-description">
                            Mein erstes Kinderbuch welches großformatig illustriert ist, mit Begleittext in Reimen.
                            Geeignet ab 4 Jahren (da muss dann aber noch einiges erklärt werden),
                            eigentlich ein Buch für die ganze Familie.
                        </p>
                        <div class="additional-book-cover">
                            <img src="img/MaxHoltSprudel-BeispielSeite.jpg" alt="MaxHoltSprudel-BuchSeite-Beispiel">
                        </div>
                        <p class="additional-book-story">
                            Die Wasserflasche bei Tisch ist leer. Wer soll eine neue holen?
                            Und was ist dabei zu beachten? Ein Buch für alle, die groß sein wollen - oder es schon sind...
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.books-carousel').slick({
                infinite: true, // Endlose Schleife
                slidesToShow: 6, // Anzahl der Slides, die auf großen Bildschirmen angezeigt werden
                slidesToScroll: 1, // Anzahl der Slides, die bei jedem Durchlauf gescrollt werden
                autoplay: true, // Automatisches Scrollen aktivieren
                autoplaySpeed: 0, // Setzen Sie dies auf 0 für einen kontinuierlichen Flow ohne Pause
                speed: 3000,
                cssEase: 'linear', // Art der Animationskurve
                arrows: false, // Keine Navigationspfeile
                pauseOnHover: true,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 350,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>

    <script src="js\index.script.js"></script>
</body>

</html>