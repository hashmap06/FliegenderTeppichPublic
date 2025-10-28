<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>
    <div class="content">
        <h1>
            Here you can checkout and pay
        </h1>
    </div>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>
</body>

</html>