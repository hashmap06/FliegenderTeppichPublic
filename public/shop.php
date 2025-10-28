<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300&display=swap" rel="stylesheet">
    <title>Shop</title>
    <link rel="stylesheet" href="css\shop\Grid.css">
</head>
<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    include('../src/db/database_handler/dbh.classes.php');
    ?>
    <div class="content">
        <div class="ImageBanner">
            <h1 class="ShopBanner">
                Willkommen im Shop
            </h1>
        </div>
        <div class="BookPhpGrid">
            <?php
                include('../src/db/database_handler/Book/bookHtmlGenerator.classes.php');
            ?>
        </div>
    </div>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>
</body>
</html>
