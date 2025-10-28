<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/shopping-cart/shoppingCart.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo getenv('PAYPAL_CLIENT_ID') ?: 'REPLACE_ME'; ?>&currency=EUR"></script>
</head>
<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>
    <div class="content">
        <div class="shopping">
            <div class="shopping-cart">
                <div class="title">
                    <h3>
                        Einkaufswagen (Versandkostenfrei ab einem Bestellwert von 29€)
                    </h3>
                </div>

                <?php
                    include("../src/db/shopping-cart/generate-html-cart-items.php");
                ?>
                
                <div class="outer-total-price">

                    <div class="inner-total-price">
                        <h3 class="total-price-title">
                            Gesamtpreis aller Bücher:
                        </h3>
                        <h3 id="total-price-value"></h3>
                    </div>
                    
                    <div class="with_shipping_field">
                        <h3 id="Shipping_calculate_price">
                            Zuzüglich +2.99€ Versand:
                        </h3>
                        <h3 id="total-price-value-shipping-included"></h3>
                    </div>

                </div>
                <div class="paypalPaymentField" id="paypal"></div>
            </div>

        </div>
    </div>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>
    <script src="js/shopping-cart.js"></script>
</body>
</html>
