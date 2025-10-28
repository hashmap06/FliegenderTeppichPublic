<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\Dashboard\bookAdd.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    $currentPage2 = basename($_SERVER['PHP_SELF']);
    $currentPage = 'dashboard.startmenu.php';
    include('../templates/includes/sidenavbar.php');
    ?>
    <?php
    
    if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
        // Display this HTML code if the 'CustomerID' session variable is set
        ?>
        <div class="content">
            <div class="MessagesDashboard">
                <div class="InputContainer">
                    <span class="AddBookTitle"><h1>Buch hinzufügen</h1></span>

                    <form action="../src/db/database_handler/Book/bookadd.inc.php" method="POST" enctype="multipart/form-data">

                        <input type="text" id="isbn" name="isbn" placeholder="Geben Sie einen 10- bis 13-stelligen numerischen Code ein, der Ihr Buch eindeutig identifiziert, es darf NUR Zahlen eingegeben werden, kein -/, oder Leerzeichen." required><br>
                        
                        <input type="text" id="price" name="price" placeholder="Preis bitte bis auf 2 Nachkommastellen eingeben, mit '.' als Komma, z.B. '17.09'" required><br>

                        <input type="text" id="author" name="author" placeholder="Autor" required><br>

                        <input type="text" id="genre" name="genre" placeholder="Genre" required><br>

                        <input type="text" id="bookName" name="bookName" placeholder="Buchtitel" required><br>

                        <input type="text" id="publishYear" name="publishYear" placeholder="Erscheinungsjahr, es darf nur das Jahr eingegeben werden, z.B. '2018'" required><br>

                        <textarea id="description" name="description" placeholder="Beschreibung" rows="10" style="width: 100%;"></textarea><br>

                        <select id="ebookType" name="ebookType">
                            <option value="ebook">eBook</option>
                            <option value="realBook">Gedrucktes Buch</option>
                            <option value="both">eBook & Gedrucktes Buch</option>
                        </select>

                        <label for="image">Laden Sie Ihr Buchcover hoch: </label>
                        <input type="file" name="image">

                        <input type="submit" value="ERSTELLEN" name="submit">
                    </form>

                </div>
            </div>
        </div>
        <?php
    }
    ?>
</body>
</html>