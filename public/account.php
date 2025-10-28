<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontoinformation ändern</title>
    <link rel="stylesheet" href="css/account/formStyle.css">
</head>

<body>

    <style>

    </style>
    <?php
    include('../templates/includes/navbar.php');
    ?>
    <div class="content">

        <?php

        if (!isset($_SESSION['CustomerID'])) {
            echo "<div style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;'>";
            echo "<div style='background-color: #f1f1f1; padding: 20px; border-radius: 10px;'>";
            echo "<p style='margin-bottom: 10px;'>Sie sind derzeit nicht angemeldet.</p>";
            echo "<p style='margin-bottom: 10px;'>Wenn Sie sich anmelden möchten, besuchen Sie diesen Link:</p>";
            echo "<p><a href='login2.php'>Anmelden</a></p>";
            echo "</div>";
            echo "</div>";
            exit();
        }

        echo "<h1 class='titleAccount-change' id='titleSection'>Kontoinformation ändern</h1>";


        include("../src/db/database_handler/dbh.classes.php");


        $customerID = $_SESSION['CustomerID'];
        $dbh = new Dbh();
        $conn = $dbh->connect();

        $sql = "SELECT DOB, Name, username, UserPassword, Address FROM custinfo WHERE CustomerID = :customerID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $dob = $result['DOB'];
        $name = $result['Name'];
        $username = $result['username'] ?? exit();
        $address = $result['Address'];
        $hashedPWD = $result['UserPassword'];
        ?>
        <form class="retype-info-form" action="../src/db/changeAccount/applyChanges.php" method="post">
            <label for="dob">Geburtsdatum:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>"><br>

            <label for="name">Vollständiger Name:</label>
            <input type="text" id="name" placeholder="Geben Sie Ihren vollständigen Namen ein (optional)" name="name" value="<?php echo $name; ?>"><br>

            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br>

            <label for="address">Adresse:</label>
            <textarea id="address" placeholder="Geben Sie Ihre Adresse an, wenn Sie dies wünschen (optional)" name="address"><?php echo $address; ?></textarea><br>

            <label for="newPassword">Neues Passwort:</label>
            <input type="password" placeholder="Geben Sie ein neues Passwort ein (optional)" id="newPassword" name="newPassword"><br>

            <input type="hidden" name="hashedPassword" value="<?php echo $hashedPWD; ?>">

            <input type="hidden" name="customerID" value="<?php echo $customerID; ?>">

            <label for="currentPassword">Aktuelles Passwort:</label>
            <input type="password" placeholder="Geben Sie Ihr aktuelles Passwort ein, um Änderungen vorzunehmen" id="currentPassword" name="currentPassword" required>
            <input type="submit" name="submit" value="Änderungen übernehmen">
        </form>

    </div>
    <?php
    include('../templates/includes/footer.php');
    ?>

    <script src="js\toogle_password_script.js"></script>
</body>

</html>