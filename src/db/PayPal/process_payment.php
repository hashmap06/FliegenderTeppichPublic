<?php
// check that request method is post, else terminate
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    exit('Invalid request method');
}

//extract and decode send AJAX JSON file from JavaScript file
$inputJSON = file_get_contents('php://input');
$customerInfo = json_decode($inputJSON);

//terminate with erroneous response code if sent data does not contain essential fields, such as email address of buyer
if (!isset($customerInfo->name) || !isset($customerInfo->email) || !isset($customerInfo->address)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid data format"]);
    exit();
}

$totalBookPrice = 0;

// iterate over each book of JS sent ajax JSON
foreach ($customerInfo->books as $book) {
    $isbn = $book->ISBN;
    $priceOfBook = floatval($book->priceOfBook);
    $priceOfBook = number_format($priceOfBook, 2, '.', '');
    $quantity = intval($book->quantity);
    $quantityRelatedPrice = floatval($book->quantityRelatedPrice);
    $quantityRelatedPrice = number_format($quantityRelatedPrice, 2, '.', '');
    $totalBookPrice += $priceOfBook * $quantity;

    if (abs($priceOfBook * $quantity - $quantityRelatedPrice) > 0.01) {
        echo json_encode(["Error" => "erroneous sent data, quantityRelatedPrice is false"]);
        exit();
    } 
}

//extract all data from ajax JS, and save them as variables

//rest of defining
$name = $customerInfo->name;
$email = $customerInfo->email;
$orderTime = $customerInfo->orderTime;
$paypalOrderID = $customerInfo->transactionId;


//address
$address_line_1 = $customerInfo->address->address_line_1;
$city = $customerInfo->address->admin_area_2;
$postal_code = $customerInfo->address->postal_code;
$country_code = $customerInfo->address->country_code;

//...

// grab CustomerID, if no CustomerID is found, put it to 4, which is an invalid one, and tells the db that a non-logged in user ordered book(s)
session_start();
$customerID = $_SESSION['CustomerID'] ?? 4;


//validate data which got extracted
if (isset($customerInfo->isFromShopCart) && (isset($_SESSION['CustomerID']))) {
    $from_cart = true;
} else {
    $from_cart = false;
}

$validationErrors = [];

if (empty($name)) {
    $validationErrors[] = "Name is empty";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $validationErrors[] = "Email is not valid";
}

if (empty($address_line_1)) {
    $validationErrors[] = "Address Line 1 is empty";
}

if (empty($city)) {
    $validationErrors[] = "City is empty";
}

if (empty($postal_code)) {
    $validationErrors[] = "Postal Code is empty";
}

if (empty($country_code)) {
    $validationErrors[] = "Country Code is empty";
}

//include PDO database connector
include('../database_handler/dbh.classes.php');

// validate the send AJAX data, by comparing the passed price with the one found in the db (use ISBN as key (also unique))
class ValidatePriceISBN extends Dbh {

    public function getPricesByISBNs($ISBNs) {
        $placeholders = implode(',', array_fill(0, count($ISBNs), '?'));

        try {
            $stmt = $this->connect()->prepare("SELECT Price, BookID, ISBN FROM bookinfo WHERE ISBN IN ($placeholders)");
            $stmt->execute($ISBNs);

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[$row['ISBN']] = $row;
            }
            return $results;

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}

// validate ISBN
$ISBNs = [];
foreach ($customerInfo->books as $book) {
    if (!(strlen((string)$book->ISBN) >= 10 && strlen((string)$book->ISBN) <= 13)) {
        $validationErrors[] = "ISBN length is not between 10 and 13 characters for ISBN: " . $book->ISBN;
    }
    $ISBNs[] = $book->ISBN;
}

$validatePrice = new ValidatePriceISBN();
$databasePrices = $validatePrice->getPricesByISBNs($ISBNs);
$validationErrors = [];

// iterate over customerInfo array of objects, call validate DB method for each book
// if price faulty, json encode error and print it back to user
foreach ($customerInfo->books as $book) {
    $isbn = $book->ISBN;
    $priceOfBook = number_format($book->priceOfBook, 2, '.', '');
    $quantity = intval($book->quantity);

    if (!isset($databasePrices[$isbn])) {
        $validationErrors[] = "ISBN not found in database: $isbn";
    } else {
        $correctPrice = number_format($databasePrices[$isbn]['Price'], 2, '.', '');
        if ($priceOfBook != $correctPrice) {
            $validationErrors[] = "Price mismatch for ISBN $isbn: expected $correctPrice, got $priceOfBook";
        }
    }

    if ($quantity < 1) {
        $validationErrors[] = "Quantity must be a number greater than 1 for ISBN: " . $isbn;
    }
}

// if validation has not worked for every field, and validationErrors is not null, give faulty response code (fail.php)
if (!empty($validationErrors)) {
    echo json_encode(array("errors" => $validationErrors));
    http_response_code(422);
    exit();
}




// Enqueue data to send to asynchronous webhook-handler script to compare it later with webhook data from paypal, this is due to 2 step verification of payment before uploading the order to the db
require '../../vendor/autoload.php';

$redis = new Predis\Client();

// formatting data correctly to enqueue it with redis
$bookDetails = array_map(function($book) use ($databasePrices) {
    return [
        'ISBN' => $book->ISBN,
        'quantity' => $book->quantity,
        'price' => number_format($book->priceOfBook, 2, '.', ''), // Assuming this is the price from the JSON
        'correctPrice' => isset($databasePrices[$book->ISBN]) ? number_format($databasePrices[$book->ISBN]['Price'], 2, '.', '') : null
    ];
}, $customerInfo->books);

$message = json_encode([
    'name' => $name,
    'email' => $email,
    'address_line_1' => $address_line_1,
    'city' => $city,
    'postal_code' => $postal_code,
    'country_code' => $country_code,
    'totalBookPrice' => $totalBookPrice,
    'customerID' => $customerID,
    'paymentID' => 1,
    'paypalOrderID' => $paypalOrderID,
    'clientsideTimestamp' => $orderTime,
    'books' => $bookDetails, // Array of objects with book details
    'from_shopping_cart_adm_by_db' => $from_cart,
]);


// push it onto the redis queue, on the Servers RAM for asynchonous payment processingg
$queueName = "ajax_verified_order_clientside_details";
$redis->rpush($queueName, $message);


// everything worked, give success repsonse code back to JS, (success.php)
http_response_code(200);
echo json_encode("Success -> Cart processed successfully");