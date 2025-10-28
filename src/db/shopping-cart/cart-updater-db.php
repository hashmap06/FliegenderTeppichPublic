<?php

ini_set('display_errors', 0); // Do not display errors as part of the response
ini_set('log_errors', 1); // Log errors to the server's error log

require_once(__DIR__ . '/../database_handler/dbh.classes.php');
session_start();

header('Content-Type: application/json');

// Fetching data sent via POST
$isbn = isset($_POST['isbn']) ? $_POST['isbn'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

if (!$isbn || !$quantity) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing isbn or quantity']);
    exit; // Stop script execution
}

if (isset($_SESSION['CustomerID'])) {
    try {
        $db = (new Dbh())->connect();
        session_start();
        $customerID = $_SESSION["CustomerID"];
        $bookISBN = $_POST["isbn"];
        $quantity = $_POST["quantity"];
        $orderDate = date('Y-m-d H:i:s');
    
        // Attempt to find an existing 'PENDING' order for the given ISBN and customer
        $checkOrderSql = "SELECT o.OrderNumber, o.BookID
                          FROM orderinfo o
                          WHERE o.CustomerID = :CustomerID
                          AND o.BookID = (SELECT b.BookID
                                          FROM bookinfo b
                                          WHERE b.ISBN = :ISBN)
                          AND o.status = 'PENDING'";
        
        $stmt = $db->prepare($checkOrderSql);
        $stmt->execute([':CustomerID' => $customerID, ':ISBN' => $bookISBN]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            // Order exists, update it
            $OrderNumber = $result['OrderNumber'];
            $BookID = $result['BookID'];
    
            $updateOrderSql = "UPDATE orderinfo SET Quantity = :Quantity, OrderDate = :OrderDate, PaymentID = 1
                               WHERE OrderNumber = :OrderNumber AND CustomerID = :CustomerID";
    
            $stmt = $db->prepare($updateOrderSql);
            $stmt->execute([
                ':Quantity' => $quantity,
                ':OrderDate' => $orderDate,
                ':OrderNumber' => $OrderNumber,
                ':CustomerID' => $customerID
            ]);
    
            echo json_encode(['message' => "Order updated successfully."]);
        } else {
            // Order does not exist, insert new one
            // First, fetch the BookID based on the provided ISBN
            $fetchBookIDSql = "SELECT BookID FROM bookinfo WHERE ISBN = :bookISBN";
            $stmt = $db->prepare($fetchBookIDSql);
            $stmt->execute([':bookISBN' => $bookISBN]);
            $bookInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    
            if ($bookInfo) {
                $BookID = $bookInfo['BookID'];
    
                $insertOrderSql = "INSERT INTO orderinfo (CustomerID, BookID, Quantity, OrderDate, status, PaymentID)
                                   VALUES (:CustomerID, :BookID, :Quantity, :OrderDate, 'PENDING', 1)";
    
                $stmt = $db->prepare($insertOrderSql);
                $stmt->execute([
                    ':CustomerID' => $customerID,
                    ':BookID' => $BookID,
                    ':Quantity' => $quantity,
                    ':OrderDate' => $orderDate
                ]);
    
                echo json_encode(['message' => "New order inserted successfully."]);
            } else {
                throw new Exception("Book with the given ISBN not found.");
            }
        }
    
        http_response_code(200); // OK
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => "Database error: " . $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => $e->getMessage()]);
    }
}
else {
    http_response_code(200); // Forbidden or 400 Bad Request might be more appropriate -- not using currently tho
    echo json_encode(['error' => 'CustomerID is required for this operation.']);
}