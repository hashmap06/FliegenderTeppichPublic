<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\navbar\LoginDropDown.css">
    <link rel="stylesheet" href="css\login\login2.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <title>Anmelden</title>
</head>
<body>
    <?php
    include('../templates/includes/navbar.php');
    ?>
    <div class="background-login2-style">
        <div class="content">
            <div class="login2-form-shade">
                <form class="login2-form" method="post" action="../src/db/database_handler/login.inc.php">
                    <div class="container">

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="uname" name="uname" required>
                            <label class="mdl-textfield__label" for="uname">Benutzername</label>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" id="psw" name="psw" required>
                            <label class="mdl-textfield__label" for="psw">Passwort</label>
                        </div>

                        <button class="btn btn-background-slide" type="submit" name="submit">ANMELDEN</button>
                        <a href="login.php" class="sign-up-button">Kein Benutzerkonto vorhanden &quest;</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include('../templates/includes/footer.php');
    ?>
</body>
</html>