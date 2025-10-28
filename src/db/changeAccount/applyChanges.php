<?php

session_start();

if (isset($_POST["submit"])) {
    // Check if user is logged in
    if (!isset($_SESSION['customerID'])) {
        header("Location: ../../public/login2.php?error=notLoggedIn");
        exit();
    }

    $customerID = $_SESSION['customerID'];
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $username = $_POST["username"];
    $address = $_POST["address"];
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $newPWD = false;

    include("../database_handler/dbh.classes.php");

    // Connect to the database
    $dbh = new Dbh();
    $conn = $dbh->connect();

    // Fetch user's current hashed password from the database
    $stmt = $conn->prepare('SELECT UserPassword FROM custinfo WHERE CustomerID = :id');
    $stmt->execute(['id' => $customerID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the current password
    if (!$row || !password_verify($currentPassword, $row['UserPassword'])) {
        header("Location: ../../public/account.php?error=invalidCredentials");
        exit();
    }

    // Validate and hash the new password if provided
    if (!empty($newPassword)) {
        if (strlen($newPassword) < 3) {
            echo("The new password entered was too short, please try again:");
            echo "<br><a href='../../public/account.php'>Try again</a>";
            exit();
        }
        if ($newPassword === $currentPassword) {
            echo("This is the same Password, your password therefore has not been changed.");
            exit();
        }
        $newHashedPassword = password_hash($newPassword, PASSWORD_ARGON2I);
        $newPWD = true;
    } else {
        $newHashedPassword = null;
    }

    // Validate other user inputs
    $newAddress = ($address !== null && preg_match('/^[A-Za-z0-9\s,.\-äöüß]{1,75}$/', $address));
    $oldUsername = !($username !== null && strlen($username) >= 4 && ctype_alnum($username));
    $newDOB = ($dob !== null && strtotime($dob) && date('Y-m-d', strtotime($dob)) === $dob);
    $newName = !(empty($name) || !preg_match('/^[A-Za-z\s]{2,50}$/', $name));

    if ($newName) {
        $_SESSION["name"] = $name;
    }

    // Class to apply changes
    class applyChanges extends Dbh {
        public function updateUser($customerID, $name, $dob, $username, $address, $newHashedPassword, $newName, $newDOB, $oldUsername, $newAddress, $newPWD) {
            $conn = $this->connect();
            
            $sqlParts = [];
            $params = [];

            if ($newPWD) {
                $sqlParts[] = "UserPassword = :password";
                $params[':password'] = $newHashedPassword;
            }
            if ($newName) {
                $sqlParts[] = "Name = :name";
                $params[':name'] = $name;
            }
            if ($newDOB) {
                $sqlParts[] = "DOB = :dob";
                $params[':dob'] = $dob;
            }
            if ($newAddress) {
                $sqlParts[] = "Address = :address";
                $params[':address'] = $address;
            }
            if (!$oldUsername) {
                $sqlParts[] = "username = :username";
                $params[':username'] = $username;
            }

            if (empty($sqlParts)) {
                header("Location: ../../public/account.php?error=NoChangesDetected");
                exit();
            }

            $sql = "UPDATE custinfo SET " . implode(", ", $sqlParts) . " WHERE CustomerID = :customerID;";
            $params[':customerID'] = $customerID;

            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $stmt->closeCursor();
        }
    }

    // Execute the update
    $applyChanges = new applyChanges();
    $applyChanges->updateUser($customerID, $name, $dob, $username, $address, $newHashedPassword, $newName, $newDOB, $oldUsername, $newAddress, $newPWD);

    header("Location: ../../public/account.php?success=changesApplied");
    exit();
}