<?php
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $username = $_POST["username"];
    $address = $_POST["address"];
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $hashedPassword = $_POST["hashedPassword"];
    $customerID = $_POST["customerID"];
    $newPWD = false;

   

    //general input validation
    if (!password_verify($currentPassword, $hashedPassword) || $currentPassword === null || $hashedPassword === null) {
        header("Location: ../../account.php?error=invalidCredentials");
        exit();

    } else if (strlen($newPassword) > 3 && $newPassword !== null) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_ARGON2I);
        $newPWD = true;
    }
    else if ($newPassword === $currentPassword) {
        echo("This is the same Password, your password therefore has not been changed.");
        exit();
    }
    else if (strlen($newPassword) >= 1) {
        echo("The new password entered was too short, please try again:");
        echo "<br><a href='../../account.php'>Try again</a>";
        exit();
    }

    if ($address !== null && preg_match('/^[A-Za-z0-9\s,.\-äöüß]{1,75}$/', $address)) {
        $newAddress = true;
    }
    else {
        $newAddress = false;
    }

    if ($username === null || strlen($username) < 4 || !ctype_alnum($username)) {
        $oldUsername = true;
    }
    else {
        $oldUsername = false;
    }

    if ($dob === null || !strtotime($dob) || date('Y-m-d', strtotime($dob)) !== $dob) {
        $newDOB = false;
    }
    else {
        $newDOB = true;
    }


    if (empty($name) || !preg_match('/^[A-Za-z\s]{2,50}$/', $name)) {
        $newName = false;
    }
    else {
        $newName = true;
        $_SESSION["name"] = $newName;
    }

    include("../database_handler/dbh.classes.php");

    //$applyChanges->updateUser($customerID, $name, $dob, $username, $address, $hashedPassword, $newName, $newDOB, $oldUsername, $newAddress, $newPWD);


    class applyChanges extends Dbh {
        public function updateUser($customerID, $name, $dob, $username, $address, $newHashedPassword, $newName, $newDOB, $oldUsername, $newAddress, $newPWD) {
            $conn = $this->connect();
    
            if ($newPWD) {
                $sqlQueryWithPassword = "UPDATE custinfo SET UserPassword = :password";
            }
            else {
                $sqlQueryWithPassword = "UPDATE custinfo SET";
            }            
            if ($newName) {
                $sqlQueryWithPassword .= ", Name = :name";
            }
            if ($newDOB) {
                $sqlQueryWithPassword .= ", DOB = :dob";
            }
            if ($newAddress) {
                $sqlQueryWithPassword .= ", Address = :address";
            }
            if (!$oldUsername) {
                $sqlQueryWithPassword .= ", username = :username";
            }
            
            $sqlQueryWithPassword .= " WHERE CustomerID = :customerID;";

            $sqlQueryWithPassword = str_replace('SET,', 'SET', $sqlQueryWithPassword);

            if ($sqlQueryWithPassword === "UPDATE custinfo SET WHERE CustomerID = :customerID;") {
                header("Location: ../../account.php?error=NoChangesDetected");
                exit();
            }

            
            $stmt = $conn->prepare($sqlQueryWithPassword);

            if ($newPWD) {
                $stmt->bindParam(':password', $newHashedPassword);

            }
            if ($newName) {
                $stmt->bindParam(':name', $name);
            }
            if ($newDOB) {
                $stmt->bindParam(':dob', $dob);
            }
            if ($newAddress) {
                $stmt->bindParam(':address', $address);
            }
            if (!$oldUsername) {
                $stmt->bindParam(':username', $username);
            }

            $stmt->bindParam(':customerID', $customerID);
    
            $stmt->execute();
            $stmt->closeCursor();
        }
    }


    // execution of classes and redireciton
    
    $applyChanges = new applyChanges();
    $applyChanges->updateUser($customerID, $name, $dob, $username, $address, $newHashedPassword, $newName, $newDOB, $oldUsername, $newAddress, $newPWD);

    header("Location: ../../account.php?success=changesApplied");
    exit();
}
