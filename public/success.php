<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background: white;
            padding: 40px 60px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .checkmark {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
        }

        .checkmark:after {
            content: '';
            position: absolute;
            width: 25px;
            height: 15px;
            background: transparent;
            top: 15px;
            left: 15px;
            border: 5px solid #4CAF50;
            border-top: none;
            border-right: none;
            transform: rotate(-45deg);
            animation: checkmark 0.5s ease-in-out 0.2s;
            animation-fill-mode: forwards;
        }

        @media (max-width: 475px) {
            .container {
                margin: 15px;
            }
        }

        @keyframes checkmark {
            0% {
                width: 0;
                height: 0;
                opacity: 0;
            }

            40% {
                width: 25px;
                height: 15px;
                opacity: 1;
            }

            100% {
                width: 25px;
                height: 15px;
            }
        }

        .confetti {
            position: fixed;
            top: -10px;
            z-index: 999;
            opacity: 0.7;
            animation: fall linear forwards;
        }

        @keyframes fall {
            to {
                transform: translate3d(var(--x), 100vh, 0);
            }
        }

        .rect {
            width: 10px;
            height: 5px;
            background-color: var(--color);
        }

        .circle {
            width: 7px;
            height: 7px;
            background-color: var(--color);
            border-radius: 50%;
        }

        .long {
            width: 15px;
            height: 3px;
            background-color: var(--color);
        }

        .stefan_face {
            width: 50%;
            height: 50%;
            z-index: -5;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="checkmark"></div>
        <h1>Zahlung erfolgreich!</h1>
        <p>Ihre Zahlung wurde erfolgreich verarbeitet.</p>
        <p><a href="index.php">Startseite</a></p>
        <!--<img class="stefan_face" src="uploads\happy_stefan.jpeg">-->
    </div>
</body>
<script>
    function createConfettiPiece() {
        const confetti = document.createElement('div');
        confetti.classList.add('confetti');

        const shapes = ['rect', 'circle', 'long'];
        const shape = shapes[Math.floor(Math.random() * shapes.length)];
        confetti.classList.add(shape);

        confetti.style.setProperty('--color', `hsl(${Math.random() * 360}, 100%, 50%)`);
        confetti.style.setProperty('--x', Math.random() * 100 + 'vw');
        confetti.style.animationDuration = Math.random() * 3 + 2 + 's';
        confetti.style.left = Math.random() * 100 + 'vw';

        document.body.appendChild(confetti);

        setTimeout(() => confetti.remove(), 5000);
    }

    setInterval(createConfettiPiece, 200);
</script>

</html>

<?php

$delete_cart_status = isset($_GET['status']) ?? false;

//set superglobal is cart set to false
$_SESSION['shopping_cart_visited'] = false;

//delete cookies once all items of shopping cart got bought - only case if user not logged in, and if he has shopping_cart cookies
if ($delete_cart_status) {

    if (!isset($_SESSION['CustomerID'])) {

        if (isset($_COOKIE['shopping_cart'])) {

            setcookie('shopping_cart', '', time() - 3600, '/');
            unset($_COOKIE['shopping_cart']);
        }
    }
}
