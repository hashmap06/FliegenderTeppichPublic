<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    <script src="js/bookSubpage.js"></script>
    <link rel="stylesheet" href="css/about-me/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include('../templates/includes/navbar.php');
    ?>
    <div class="content">
        <div class="textSection1">
            <h1 class="about-meTitle">
                Über Mich:
            </h1>
            <img class="authorProfilePic" src="img/clientProfilePicture.jpg" alt="Profile Ute Schuler">
            <p id="descriptionText">
                Schon als Kind habe ich gerne geschrieben und gemalt. Mit meinen Kindern nun habe ich die Freude an Wörtern, Reimen und dem Malpinsel wiederentdeckt.
                So habe ich meine ersten Kinderbücher produziert, die nicht "perfekt" sind, aber hoffentlich trotzdem gefallen!
            </p>

            <p id="descriptionText">
                Die Sprache der Bücher mag teilweise für kleine Leser und Zuhörer fordernd sein - aber steckt nicht immer auch ein Stück Spannung in dem, was noch nicht vollständig verstanden wird?
                Der Großteil meiner Illustrationen dagegen ist bewusst "naiv" gehalten - ich liebe Kinderbilder!
                <br>
                <br>
            </p>

            <p id="descriptionText">

                Die Texte meiner Papierbücher habe ich mit einem Schmunzeln im Gesicht geschrieben - und hoffe,
                dass ich damit auch ein Schmunzeln auf die Gesichter meiner Leser zaubern kann.
                Meine e-Bücher behandeln dagegen Themen, die nachdenklich stimmen und zum Nachdenken bzw. zur Diskussion auffordern sollen.
                <br>
                <br>
                Ich wünsche viel Freude beim Lesen.
                Und freue mich über Anregungen und sonstige Kommentare!
            </p>
        </div>
    </div>
    <?php
    include('../templates/includes/footer.php');
    ?>
</body>

</html>