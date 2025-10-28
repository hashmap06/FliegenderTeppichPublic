<?php
session_start(); // Start the session


include('../src/db/database_handler/dbh.classes.php');

class reUpdateBook extends Dbh {

    public function deleteData() {
        try {
            $db = $this->connect();
            $query = "DELETE FROM orderinfo WHERE status = 'PENDING' AND CustomerID = ?;";
            $stmt = $db->prepare($query);
            if ($stmt->execute([$_SESSION['CustomerID']])) {
                $this->cookieDBUpload(); // Call cookieDBUpload only if DELETE is successful
            }
            return $stmt;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    

    private function cookieDBUpload() {
        try {
            $db = $this->connect();
    
            $cart = isset($_COOKIE['shopping_cart']) ? json_decode($_COOKIE['shopping_cart'], true) : [];
    
            foreach ($cart as $ISBN => $quantity) {
                $stmt = $db->prepare("
                    INSERT INTO orderinfo (PaymentID, Quantity, Total, CustomerID, BookID, OrderDate, status)
                    SELECT :PaymentID, :Quantity, bookinfo.Price * :Quantity, :CustomerID, bookinfo.BookID, :OrderDate, 'PENDING'
                    FROM bookinfo
                    WHERE bookinfo.ISBN = :ISBN
                ");
                
                $paymentID = 1;
                $stmt->bindParam(':PaymentID', $paymentID);
                $stmt->bindParam(':Quantity', $quantity);
                $stmt->bindParam(':CustomerID', $_SESSION['CustomerID']);
                $orderDate = new DateTime('now', new DateTimeZone('Europe/Berlin'));
                $orderDate = $orderDate->format('Y-m-d H:i:s');
                $stmt->bindParam(':OrderDate', $orderDate);
                $stmt->bindParam(':ISBN', $ISBN);
    
                // Execute the query
                $stmt->execute();
            }
    
            $db = null;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

if (isset($_SESSION["username"])) {
    $fetchBackToDB = new reUpdateBook();
    $uploadCookie = $fetchBackToDB->deleteData();
}


// if user is logged in...
if (isset($_SESSION["username"])) {
    // Unset session variables (all)
    session_unset();

    // Destroy session after unsetting variables
    session_destroy();
}

header("Location: index.php");
exit();
?>