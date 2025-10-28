<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css\login\login.style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>
    <form action="../src/db/database_handler/signup.inc.php" method="post">

        <div class="content">
            <div class="outer_signup_positioning_container">
                <div id="signup-form-container">
                    <label for="uname"><b>Benutzername</b></label>
                    <input type="text" placeholder="Geben Sie Ihren Benutzernamen ein" name="uname" required pattern="[a-zA-Z0-9_]{5,15}" title="Benutzername muss 5-15 Zeichen lang sein und darf nur Buchstaben, Zahlen und Unterstriche enthalten">

                    <label for="email"><b>Email</b></label>
                    <input type="email" placeholder="Geben Sie Ihre Email-Adresse ein" name="email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Bitte geben Sie eine gültige E-Mail-Adresse ein (z.B. name@example.com)">

                    <label for="psw"><b>Passwort</b></label>
                    <input type="password" placeholder="Geben Sie Ihr Passwort ein" name="psw" required>

                    <label for="psw_repeat"><b>Passwort wiederholen</b></label>
                    <input type="password" placeholder="Wiederholen Sie Ihr Passwort" name="psw_repeat" required>



                    <button class="SubmitButton" type="submit" name="submit">Benutzerkonto erstellen</button>

                    <div id="signup-form-buttons" style="background-color:#f1f1f1">
                        <a href="index.php">
                            <button type="button" class="cancelbtn">Abbrechen</button>
                        </a>
                    </div>
                    <div class="bereits_account">
                        <a href="login2.php">Sie haben bereits ein Benutzerkonto?</a>
                    </div>
                </div>
            </div>


    </form>
    </div>
    </div>

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>
</body>

</html>