<?php
class Login extends Dbh {
    // Method to authenticate a user
    protected function getUser($uid, $pwd) {
        // Preparing SQL statement to prevent SQL injection
        $stmt = $this->connect()->prepare('SELECT * FROM custinfo WHERE username = ? OR EmailAddress = ?;');

        // Execute the statement and handle any potential errors
        if (!$stmt->execute(array($uid, $uid))) {
            header("location: /index.php?error=stmtfailed");
            exit();
        }

        // Check if user exists in the database
        if ($stmt->rowCount() == 0) {
            header("location: /index.php?error=usernotfound");
            exit();
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data

        // Verifying the password
        $hashedPassword = $user["UserPassword"]; 
        $checkPWD = password_verify($pwd, $hashedPassword);

        // Redirecting based on password verification
        if ($checkPWD == false) {
            header("location: /index.php?error=wrongpswd");
            exit();
        } elseif ($checkPWD == true) {
            // Setting secure session cookie parameters
            session_set_cookie_params([
                'lifetime' => 3600,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            
            session_start();

            // Storing essential user info in the session
            $_SESSION["CustomerID"] = $user["CustomerID"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["Admin"] = $user["Admin"]; // Admin status
            $_SESSION["name"] = $user["Name"];

            // Handling admin users
            if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
                header('Location: /dashboard.startmenu.php?welcome=' . $_SESSION['CustomerID']);
                require_once 'weekDayAccess.classes.php';
                $wochentageDb = new WochentageDb();
                $wochentageDb->updateWochentage(true); // User logged in
                exit();
            } else {
                // call script which updates JSON file on server of todays weekday, so value behind weekday key can be augumented by one
                // used for graph which shows how many clicks and logins this week were (dashboard.startmenu.php)
                require_once 'weekDayAccess.classes.php';
                $wochentageDb = new WochentageDb();
                $wochentageDb->updateWochentage(true); // User logged in

                // Merge shopping cart data
                include('merge.initalise.shopping_cart.php');
                $merge_fetch_book = new FetchBook();
                $merge_book_data = $merge_fetch_book->mergeData();

                header('Location: /shop.php?success=login');
                exit();
            }            
        }
    }
}
