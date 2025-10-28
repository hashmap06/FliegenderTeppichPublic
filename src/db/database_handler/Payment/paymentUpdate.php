<?php
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    exit('Invalid request method');
}

header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$commandData = json_decode($inputJSON);

if ($commandData->command == "SEND FETCHED DB DETAILS") {
    include('../dbh.classes.php');

    class fetchPaymentOrderDetails extends Dbh
    {

        public function getOrderDetails()
        {

            try {
                $sql = "SELECT 
                o.OrderNumber, 
                o.PaymentID, 
                o.Quantity, 
                o.Total, 
                o.OrderDate, 
                o.status, 
                b.BookName, 
                b.Price, 
                b.ifReal, 
                c.Name, 
                c.username as CustomerName, 
                c.EmailAddress,
                c.CustomerID,
                o.OrderNumber,
                o.delivery_country,
                o.delivery_city,
                o.delivery_postal_code,
                o.delivery_street_address
                FROM 
                orderinfo o
                INNER JOIN 
                bookinfo b ON o.BookID = b.BookID
                INNER JOIN 
                custinfo c ON o.CustomerID = c.CustomerID
                WHERE 
                o.status = 'COMPLETED' OR o.status = 'APPROVED';";

                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();

                $results = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $row;
                }
                return $results;
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                return [];
            }
        }
    }

    $fetchDetails = new fetchPaymentOrderDetails();
    $orderDetails = $fetchDetails->getOrderDetails();

    echo json_encode($orderDetails);
    exit;
} elseif ($commandData->command == "CHANGE DETAILS TO DELIVERING") {
    include('../dbh.classes.php');
    $OrderID = $commandData->orderId;

    class updateOrders extends Dbh
    {
        public function updateSpecificOrder($OrderID)
        {
            try {
                $sql = "UPDATE orderinfo SET status = 'DELIVERING' WHERE OrderNumber = ?;";
                $stmt = $this->connect()->prepare($sql);

                $stmt->execute([$OrderID]);
                return $stmt->rowCount();
            } catch (\Throwable $th) {
                error_log($th->getMessage());
                return false;
            }
        }
    }

    $updateDetails = new updateOrders();
    $Update = $updateDetails->updateSpecificOrder($OrderID);
    if ($Update) {
        echo json_encode(["success" => "Order updated"]);
        http_response_code(200);
    } else {
        echo json_encode(["error" => "Failed to update order"]);
        http_response_code(400);
    }


    exit;
} elseif ($commandData->command == "FETCH ALL ORDERS") {
    include('../dbh.classes.php');

    class fetchAllOrders extends Dbh
    {

        public function fetchAll()
        {

            try {
                $sql = "SELECT 
                o.OrderNumber, 
                o.PaymentID, 
                o.Quantity, 
                o.Total, 
                o.OrderDate, 
                o.status, 
                b.BookName, 
                b.Price, 
                b.ifReal, 
                c.username as CustomerName, 
                c.Name, 
                c.EmailAddress,
                c.CustomerID,
                o.OrderNumber,
                o.delivery_country,
                o.delivery_city,
                o.delivery_postal_code,
                o.delivery_street_address
                FROM 
                orderinfo o
                INNER JOIN 
                bookinfo b ON o.BookID = b.BookID
                INNER JOIN 
                custinfo c ON o.CustomerID = c.CustomerID;";

                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();

                $results = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $row;
                }
                return $results;
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                return [];
            }
        }
    }

    $fetchDetails = new fetchAllOrders();
    $orderDetails = $fetchDetails->fetchAll();

    echo json_encode($orderDetails);
    exit;
} elseif ($commandData->command == "ONLY FETCH DELIVERING") {
    include('../dbh.classes.php');

    class fetchAllOrders extends Dbh
    {

        public function fetchAll()
        {

            try {
                $sql = "SELECT 
                o.OrderNumber, 
                o.PaymentID, 
                o.Quantity, 
                o.Total, 
                o.OrderDate, 
                o.status, 
                b.BookName, 
                b.Price, 
                b.ifReal, 
                c.username as CustomerName, 
                c.Name, 
                c.EmailAddress,
                c.CustomerID,
                o.OrderNumber,
                o.delivery_country,
                o.delivery_city,
                o.delivery_postal_code,
                o.delivery_street_address
                FROM 
                orderinfo o
                INNER JOIN 
                bookinfo b ON o.BookID = b.BookID
                INNER JOIN 
                custinfo c ON o.CustomerID = c.CustomerID
                WHERE 
                o.status = 'DELIVERING';";

                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();

                $results = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $row;
                }
                return $results;
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                return [];
            }
        }
    }

    $fetchDetails = new fetchAllOrders();
    $orderDetails = $fetchDetails->fetchAll();

    echo json_encode($orderDetails);
    exit;
} elseif ($commandData->command == "NOTIFY SENDER") {
    // Extracting data
    $CustomerName = $commandData->customerName ?? "Customer";
    $ProductName = $commandData->customerProduct;
    $DateOfOrder = $commandData->OrderDate;
    $ShippingAddress = $commandData->ShippingAddress;
    $PriceOfBook = $commandData->Price;
    $EmailOfCustomer = $commandData->EmailAddress;

    include("../../PayPal/mailBotNotify.php");

    // Construct email
    $title = "Your Order has been shipped - FliegenderTeppich";
    $recipient = $EmailOfCustomer;
    $content = "Dear $CustomerName, <br><br>Just a heads-up, your book order has been shipped.<br><br>" .
        "The order details are as follows:<br>" .
        "<ul>" .
        "<li><strong>Your Name</
                strong>: $CustomerName</li>" .
        "<li><strong>Email</strong>: $EmailOfCustomer</li>" .
        "<li><strong>Order Date</strong>: $DateOfOrder</li>" .
        "<li><strong>Price</strong>: $PriceOfBook</li>" .
        "<li><strong>Book</strong>: $ProductName</li>" .
        "<li><strong>Shipping Address</strong>: $ShippingAddress</li>" .
        "</ul>" .
        "Your order should arrive in 3 to 4 days.<br>" .
        "Have a nice day.<br><br>" .
        "Best regards,<br>" .
        "FliegenderTeppich";
    $emailSender = new EmailSender($title, $content, $recipient, 0);
    $emailSender->sendEmail();
} elseif ($commandData->command == "DELETE CUSTOMERID") {
    include('../dbh.classes.php');
    $CustomerID = $commandData->CustomerID;

    class deleteCustomer extends Dbh
    {
        public function deleteSpecificCustomer($CustomerID)
        {
            try {
                $sql = "DELETE FROM custinfo WHERE CustomerID = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$CustomerID]);
                return $stmt->rowCount();
            } catch (\Throwable $th) {
                error_log($th->getMessage());
                return false;
            }
        }
    }

    $deleteCust = new deleteCustomer();
    $Update = $deleteCust->deleteSpecificCustomer($CustomerID);
    if ($Update) {
        echo json_encode(["success" => "Customer deleted"]);
        http_response_code(200);
    } else {
        echo json_encode(["error" => "Failed to delete customer"]);
        http_response_code(400);
    }

    exit;
} elseif ($commandData->command == "GROUP FETCH BY BOOK NON RELATED") {
    include('../dbh.classes.php');

    class fetchAllOrders extends Dbh
    {

        public function fetchAll()
        {

            try {
                $sql =
                    "
                SELECT 
                    b.BookID, 
                    o.PaymentID, 
                    SUM(o.Quantity) as TotalQuantity, 
                    b.BookName, 
                    b.Price, 
                    b.ifReal, 
                    c.username as CustomerName, 
                    c.Name, 
                    c.EmailAddress,
                    c.CustomerID,
                    o.OrderNumber,
                    o.delivery_country,
                    o.delivery_city,
                    o.delivery_postal_code,
                    o.delivery_street_address
                FROM 
                    orderinfo o
                INNER JOIN 
                    bookinfo b ON o.BookID = b.BookID
                INNER JOIN 
                    custinfo c ON o.CustomerID = c.CustomerID
                WHERE 
                    o.status = 'COMPLETED'
                GROUP BY 
                    b.BookID, o.PaymentID, c.CustomerID, o.OrderNumber, o.delivery_country, o.delivery_city, o.delivery_postal_code, o.delivery_street_address;
                ";

                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();

                $results = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $row;
                }
                return $results;
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                return [];
            }
        }
    }

    $fetchDetails = new fetchAllOrders();
    $orderDetails = $fetchDetails->fetchAll();

    echo json_encode($orderDetails);
    exit;
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid command"]);
    exit;
}
