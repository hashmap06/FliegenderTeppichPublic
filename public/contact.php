<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="css/contact/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <script src="js/contact.script.js"></script>

</head>

<body class="contact-page">
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>
    <div class="content">
        <div class="OberesBanner">
            <h1>
                Kontakt FliegenderTeppich
            </h1>
        </div>

        <?php
        if (isset($_SESSION['CustomerID'])) {
            $username = $_SESSION["name"];
            $UID = $_SESSION["CustomerID"];
        ?>

            <div class="LoginFormContainer">
                <form action="../src/db/database_handler/comment.classes.php" method="post">
                    <div class="SmallInputElements">
                        <label for="fname">Name</label>
                        <input type="text" id="fname" name="firstname" placeholder="Dein Name.." value="<?php echo htmlspecialchars($username); ?>" required pattern="[a-zA-Z0-9_]{3,15}" title="Dein Name muss 3-15 Zeichen lang sein und darf nur Buchstaben, Zahlen und Unterstriche enthalten">
                    </div>

                    <textarea id="subject" name="subject" placeholder="Schreibe etwas..." style="height:200px" required minlength="15"></textarea>

                    <!-- Add a hidden input field to send UID as POST parameter -->
                    <input type="hidden" name="UID" value="<?php echo $UID; ?>" required>

                    <input type="submit" value="ABSENDEN" name="submit">
                </form>
            </div>

        <?php
        } else {
        ?>

            <div class="LoginFormContainer">
                <form action="../src/db/database_handler/normalComment.classes.php" method="post">

                    <div class="SmallInputElements">
                        <label for="fname">Name</label>
                        <input type="text" id="fname" name="firstname" placeholder="Dein Name.." required pattern="[a-zA-Z0-9_]{3,15}" title="Dein Name muss 3-15 Zeichen lang sein und darf nur Buchstaben, Zahlen und Unterstriche enthalten">

                        <label for="Email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Deine Email-Addresse.." required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Bitte gib eine gültige E-Mail-Adresse ein (z.B. name@example.com)">
                        <label for="phone number">Telefon Nummer</label>
                        <input type="tel" id="phone" name="phone" placeholder="Deine Telefon Nummer (Optional).." pattern="[\+]?[\d\s()-]{7,20}" title="Bitte gib eine gültige Telefonnummer ein (z.B. +49 1234567890)">
                    </div>

                    <label class="BetreffTitel" for="subject">Betreff</label>
                    <textarea id="subject" name="subject" placeholder="Schreibe etwas..." style="height:200px" required minlength="15"></textarea>

                    <input type="submit" value="ABSENDEN" name="submit">

                </form>
            </div>
        <?php
        }
        ?>
    </div>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>

    <script>
        // JavaScript für die Validierung der Textarea
        document.getElementById('myForm').addEventListener('submit', function(event) {
            const textarea = document.getElementById('subject');
            const pattern = /^[a-zA-Z0-9_ ]{10,500}$/; // Angepasster Regex für die Nachricht

            if (!pattern.test(textarea.value)) {
                alert("Deine Nachricht muss mindestens 10 Zeichen lang sein und darf nur Buchstaben, Zahlen und Unterstriche enthalten");
                event.preventDefault();
            }
        });

        function validateForm() {
            var message = document.getElementById('subject').value;
            if (message.length < 15) {
                alert('Geben Sie bitte mindestens 15 Zeichen ein');
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
