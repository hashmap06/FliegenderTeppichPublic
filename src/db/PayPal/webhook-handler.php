<?php

use Carbon\Carbon;

// Grabbing the raw POST data from the input stream
$raw_post_data = file_get_contents('php://input');
if (!$raw_post_data) {
    error_log("No data received in webhook");
    exit();
}

// Appending the received data to a log file
file_put_contents('webhook-log.txt', $raw_post_data . PHP_EOL, FILE_APPEND);
$json_data = json_decode($raw_post_data);

// Checking for JSON decoding errors
if ($json_data === null && json_last_error() !== JSON_ERROR_NONE) {
    error_log("JSON decoding error: " . json_last_error_msg());
    exit();
}

// Exiting script if event type is not what we expect
if ($json_data->event_type != "CHECKOUT.ORDER.APPROVED") {
    echo ("Exit Script, as webhook doesnt complete yet, as its not: PAYMENT.CAPTURE.APPROVED.");
    exit();
} else {
    echo "WEBHOOK HANDLER PHP SCRIPT GETS RUN; IF NO ANSWER TILL END; SOMETHING WRNG WITH ID <br>";
}

// Double-checking for null JSON data
if ($json_data === null) {
    echo "ReCEIVED WRONG DATA; SCRIPT TERMINATED NOW. (json data is null)";
    error_log("Invalid JSON data in webhook");
    exit();
}

// Extracting necessary data from webhook
$shipping_address = $json_data->resource->purchase_units[0]->shipping->address ?? null;
$payer_info = $json_data->resource->payer ?? null;
$capture_details = $json_data->resource->purchase_units[0]->payments->captures[0] ?? null;

if (!$shipping_address || !$payer_info) {
    echo "Problem arising with incomplete data extracted of webhook, script is exited now.";
    error_log("Incomplete data in webhook");
    exit();
}

// Address Data
$shipping_address_street_name = $json_data->resource->purchase_units[0]->shipping->address->address_line_1; // Example: "1 Main St"
$shipping_address_city_name = $json_data->resource->purchase_units[0]->shipping->address->admin_area_2; // Example: "San Jose"
$shipping_address_state_name = $json_data->resource->purchase_units[0]->shipping->address->admin_area_1 ?? "DE"; // Example: "CA"
$shipping_address_postal_code_name = $json_data->resource->purchase_units[0]->shipping->address->postal_code; // Example: "95131"
$shipping_address_country_name = $json_data->resource->purchase_units[0]->shipping->address->country_code; // Example: "US"

// Extracting basic information
$event_type = $json_data->event_type; // Example: "CHECKOUT.ORDER.APPROVED"
$order_id = $json_data->resource->id; // Example: "9E738879M3047813N"
$order_status = $json_data->resource->status; // Example: "COMPLETED"
$payment_amount = $json_data->resource->purchase_units[0]->amount->value; // Example: "12.40"
$paymentOption = $json_data->resource_type; // Example: "checkout-order"
$order_date = $json_data->create_time; //Example: "2024-07-25T19:12:11.848Z"

// Extracting payer information
$payer_name = $json_data->resource->payer->name->given_name; // Example: "John"
$payer_surname = $json_data->resource->payer->name->surname; // Example: "Doe"
$payer_email = $json_data->resource->payer->email_address; // Example: "sb-h5txw27944810@personal.example.com"

$payer_full_name = $payer_name . ' ' . $payer_surname; // "John Doe"


//...

$data2 = "Street Name: " . ($shipping_address->address_line_1 ?? 'N/A') . ", City Name: " . ($shipping_address->admin_area_2 ?? 'N/A') .
    ", State Name: " . ($shipping_address->admin_area_1 ?? 'DE') . ", Postal Code: " . ($shipping_address->postal_code ?? 'N/A') .
    ", Country Name: " . ($shipping_address->country_code ?? 'N/A');
$data2 .= ", Event Type: $event_type, Order ID: $order_id, Order Status: $order_status, Payment Amount: $payment_amount, Payment Option: $paymentOption";
$data2 .= ", Payer Name: " . ($payer_info->name->given_name ?? 'N/A') . ", Payer Surname: " . ($payer_info->name->surname ?? 'N/A') .
    ", Payer Email: " . ($payer_info->email_address ?? 'N/A');
$data2 .= ", Capture ID: " . ($capture_details->id ?? 'N/A') . ", Capture Status: " . ($capture_details->status ?? 'N/A') .
    ", Capture Time: " . ($capture_details->create_time ?? 'N/A');
$data2 .= ", Gross Amount: " . ($capture_details->seller_receivable_breakdown->gross_amount->value ?? 'N/A') .
    ", Paypal Fee: " . ($capture_details->seller_receivable_breakdown->paypal_fee->value ?? 'N/A') .
    ", Net Amount: " . ($capture_details->seller_receivable_breakdown->net_amount->value ?? 'N/A');
$data2 .= ", Capture Self Link: " . ($capture_details->links[0]->href ?? 'N/A') . ", Refund Link: " . ($capture_details->links[1]->href ?? 'N/A');


file_put_contents('log-1.log', $data2 . PHP_EOL, FILE_APPEND);

echo ("paypal Order id received form webhook is: " . $order_id);

//try to import vendor autoload, which is important to use a new Predis client
try {
    require '../../vendor/autoload.php';
    $redis = new Predis\Client();
} catch (Exception $e) {
    error_log("Redis operation failed: " . $e->getMessage());
    exit();
}

// name of queue in servers RAM
$queueName = "ajax_verified_order_clientside_details";

$queueItems = $redis->lrange($queueName, 0, -1);

//iterate through each queue in Servers RAM
foreach ($queueItems as $item) {
    $data = json_decode($item, true);
    //if queue field paypalOrderID, which is unique is same as webhook order_id:
    //decode, extract and delete the queue
    if ($data['paypalOrderID'] === $order_id) {

        //extract updated item from redis; new procedure defined in process_payment.php, new variable names encoded
        $name = $data['name'];
        echo "Name: $name\n";
        $email = $data['email'];
        echo "Email: $email\n";
        $address_line_1 = $data['address_line_1'];
        echo "Address Line 1: $address_line_1\n";
        $city = $data['city'];
        echo "City: $city\n";
        $postal_code = $data['postal_code'];
        echo "Postal Code: $postal_code\n";
        $country_code = $data['country_code'];
        echo "Country Code: $country_code\n";
        $totalBookPrice = $data['totalBookPrice'];
        echo "Total book price: $totalBookPrice\n";
        $customerID = $data['customerID'];
        echo "Customer ID: $customerID\n";
        $paymentID = $data['paymentID'];
        echo "Payment ID: $paymentID\n";
        $paypalOrderID = $data['paypalOrderID'];
        echo "PayPal Order ID: $paypalOrderID\n";
        $clientsideTimestamp = $data['clientsideTimestamp'];
        echo "Client-Side Timestamp: $clientsideTimestamp\n";
        $updateOrders = $data['from_shopping_cart_adm_by_db'];
        echo "Does the order have to be created or searched through and updated: True->updated; False->created::: $updateOrders";

        //as book is an array field inside queue, iterate through each book item, and extract / save data to hashmap structure
        foreach ($data['books'] as $book) {
            $booksArray[] = (object)[
                'ISBN' => $book['ISBN'],
                'quantity' => $book['quantity'],
                'price' => $book['price'],
                'correctPrice' => $book['correctPrice']
            ];
        }

        //second hashmap with values of the other fields, for later comparison with webhook data
        $hashmap = [
            'name' => $name, //is John Doe, so $name has to be compared to $payer_name . ' ' . $payer_surname; // "John Doe" of webhook data
            'email' => $email, //is equal to $payer_email of webhook data
            'address_line_1' => $address_line_1, //is equal to $shipping_address_street_name of webhook data
            'city' => $city, // same as $shipping_address_city_name
            'postal_code' => $postal_code, // same as $shipping_address_postal_code_name
            'country_code' => $country_code, // dame as $shipping_address_state_name
            'total_book_price' => $totalBookPrice, //original displayed price in shop, should be equal to $payment_amount (not sure though)
            'paypalOrderID' => $paypalOrderID, //is equal to $order_id of webhook data
        ];

        //delete queue entity from RAM
        $redis->lrem($queueName, 0, $item);
        break;
    }
}

if (!isset($hashmap)) {
    error_log("There is no redis queue element with the same paypalorderID, this is probably due to a price mismatch (faulty)! ");
    exit();
}

//include the mail SMTP script, see if it is possible to include
try {
    include("mailBotNotify.php");
} catch (Exception $e) {
    error_log("Error including mailBotNotify.php: " . $e->getMessage());
    exit();
}

//try writing an email to admin, notifying over new order processed, if outside of germany, notify differently
try {
    if ($shipping_address_country_name !== "DE") {
        $title = "International Order Alert - FliegenderTeppich";
        $recipient = "ute.k.schuler@gmail.com";
        $content = "Dear Ute, <br><br>Just a heads-up, we've received an international book order. 😟<br><br>" .
            "The order details are as follows:<br>" .
            "<ul>" .
            "<li><strong>Buyer</strong>: $payer_name $payer_surname</li>" .
            "<li><strong>Email</strong>: $payer_email</li>" .
            "</ul>" .
            "Could you please reach out to $payer_name $payer_surname and inform them about international shipping at FliegenderTeppich? <br>" .
            "We apologize for the inconvenience. For more order details, see the attached file.<br><br>" .
            "Thank you for your understanding and support.<br><br>" .
            "Best regards,<br>" .
            "The FliegenderTeppich Team";
        $emailSender = new EmailSender($title, $content, $recipient, $json_data);
        $emailSender->sendEmail();
    } else {
        $title = "A book got bought! - Alert FliegenderTeppich";
        $recipient = "ute.k.schuler@gmail.com";
        $content = "Dear Ute, <br><br>Great news from FliegenderTeppich! 🎉<br><br>" .
            "We're excited to share that a new book purchase has been made! The details are as follows:<br>" .
            "<ul>" .
            "<li><strong>Buyer</strong>: $payer_name $payer_surname</li>" .
            "<li><strong>Email</strong>: $payer_email</li>" .
            "</ul>" .
            "For more details on this order, please find the attached file with all the necessary information.<br><br>" .
            "Remember, this is an automated notification, but we're always here to provide the best service.<br><br>" .
            "Warm regards,<br>" .
            "The FliegenderTeppich Team";
        $emailSender = new EmailSender($title, $content, $recipient, $json_data);
        $emailSender->sendEmail();
    }
} catch (Exception $e) {
    error_log("Email sending failed: " . $e->getMessage());
}

//Also try writing an email to the buyer, informing him over a successfull purchase
try {
    $title = "Vielen Dank für Ihre Bestellung!";
    $title_encoded = mb_encode_mimeheader($title, "UTF-8");

    $recipient = $payer_email;

    //extend bookslist hahsmap to also book title, by fetching the title from the database for each one
    //include database connector PDO
    include('../database_handler/dbh.classes.php');

    $db = new Dbh(); // Using the Dbh class
    $pdo = $db->connect();

    foreach ($data['books'] as &$book) { // Use reference to update the original array
        $isbnToUse = $book['ISBN'];

        $query = "SELECT BookName FROM bookinfo WHERE ISBN = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$isbnToUse]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $bookName = $result['BookName'];
            $book['title'] = $bookName; // Add the book name as a new column
        } else {
            error_log("BookName not found for ISBN: $isbnToUse");
            continue; // Skip this book if the title is not found
        }
    }

    // Buchdetails
    $booksList = '';
    foreach ($data['books'] as $book) {
        $booksList .= "<li>{$book['quantity']} x {$book['title']} - ISBN: {$book['ISBN']} - Preis jeweils: {$book['price']} EUR</li>";
    }

    // Versandadresse
    $shippingAddress = "
        <p><strong>Adresse:</strong><br>
        {$shipping_address_street_name}, {$shipping_address_city_name}, {$shipping_address_state_name} {$shipping_address_postal_code_name}, {$shipping_address_country_name}</p>";


    $date = Carbon::parse($order_date);
    $date->setTimezone('Europe/Berlin');
    $formatted_date = $date->format('F j. Y H:i');

    // Email Inhalt
    $content = "
    <html>
    <head>
        <title>$title</title>
    </head>
    <body>
        <p>Sehr geehrte/r Herr/Frau $payer_surname,</p>
        <p>vielen Dank für Ihre Bestellung bei FliegenderTeppich!</p>
        <p>Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Bestellung erfolgreich bearbeitet wurde. Hier sind die Details Ihrer Bestellung:</p>
        <ul>
            <li><strong>Bestellnummer:</strong> $order_id</li>
            <li><strong>Bestellzeit:</strong> $formatted_date</li>
            <li><strong>Kunde:</strong> $payer_full_name</li>
            <li><strong>Email:</strong> $payer_email</li>
        </ul>
        <p><strong>Bestellte Bücher:</strong></p>
        <ul>$booksList</ul>
        $shippingAddress
        <p>Der Gesamtbetrag Ihrer Bestellung beträgt: <strong>$payment_amount EUR</strong>.</p>
        <p><small><em>Hinweis: Wenn der Gesamtbetrag Ihrer Bestellung höher ist als erwartet, liegt dies am zusätzlichen Standardversand innerhalb Deutschlands für jeweils 2,99 EUR, welcher erst ab einem Bestellwert von 29 EUR entfällt.</em></small></p>
        <p>Sie erhalten eine Benachrichtigung, sobald Ihre Bestellung versendet wird. Die Lieferung sollte innerhalb von maximal 3 Tagen erfolgen.</p>
        <p>Bei Fragen zur Bestellung können Sie uns gerne kontaktieren: ute.k.schuler@gmail.com.</p>
        <p>Mit freundlichen Grüßen,<br>Das FliegenderTeppich Team</p>
    </body>
    </html>";
    $emailSenderToBuyer = new EmailSender($title_encoded, $content, $recipient, 0);
    $emailSenderToBuyer->sendEmail();
} catch (Exception $e) {
    error_log("Email sending failed: " . $e->getMessage());
}


//include database connector PDO
//include('../database_handler/dbh.classes.php'); -> update, already included up there in try catch block

echo "Payment ID: " . $paymentID . "<br>";
echo "Customer ID: " . $customerID . "<br>";
echo "Client-Side Timestamp: " . $clientsideTimestamp . "<br>";
echo "Order Status: " . $order_status . "<br>";

//algorithm to compare different hasmaps of value, to check theyre same with webhook data
function compareAndValidateData($hashmap, $json_data)
{
    $errors = [];

    $full_name = $json_data->resource->payer->name->given_name . ' ' . $json_data->resource->payer->name->surname;

    //create identical hashmap of webhook data for later comparison
    $mapping = [
        'name' => $full_name,
        'email' => $json_data->resource->payer->email_address,
        'address_line_1' => $json_data->resource->purchase_units[0]->shipping->address->address_line_1,
        'city' => $json_data->resource->purchase_units[0]->shipping->address->admin_area_2,
        'postal_code' => $json_data->resource->purchase_units[0]->shipping->address->postal_code,
        'country_code' => $json_data->resource->purchase_units[0]->shipping->address->country_code,
        //'total_book_price' => $json_data->resource->purchase_units[0]->amount->value, price inclusive shipping
        'total_book_price' => $json_data->resource->purchase_units[0]->amount->breakdown->item_total->value,
        'paypalOrderID' => $json_data->resource->id
    ];

    //compare each by iterating through hashmap
    foreach ($hashmap as $key => $expectedValue) {
        $actualValue = $mapping[$key] ?? null;

        if ($actualValue === null) {
            $errors[] = "Missing value for $key in webhook data.";
            continue;
        }
        if ($key === 'total_book_price' && abs(floatval($expectedValue) - floatval($actualValue)) > 0.01) {
            $errors[] = "Mismatch in $key: Expected $expectedValue, got $actualValue";
        } elseif ($key !== 'total_book_price' && $expectedValue != $actualValue) { //actualValue = shipping + expectedValue
            $errors[] = "Mismatch in $key: Expected $expectedValue, got $actualValue";
        }
        if ($key == 'email' && !filter_var($actualValue, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format: $actualValue";
        }
        if ($key == 'postal_code' && !ctype_digit($actualValue)) {
            $errors[] = "Invalid postal code format: $actualValue";
        }
        if ($key == 'price' && (!is_numeric($actualValue) || $actualValue <= 0)) {
            $errors[] = "Invalid price: $actualValue";
        }
        if ($key == 'name' && (strlen($actualValue) < 3 || strlen($actualValue) > 50)) {
            $errors[] = "Name length is not within the valid range: $actualValue";
        }
        if ($key == 'country_code' && !preg_match('/^[A-Z]{2}$/', $actualValue)) {
            $errors[] = "Invalid country code: $actualValue";
        }
        if ($key == 'paypalOrderID' && !preg_match('/^\w+$/', $actualValue)) {
            $errors[] = "Invalid PayPal Order ID format: $actualValue";
        }
    }

    return $errors;
}

// Usage of the function
$errors = compareAndValidateData($hashmap, $json_data);
if (!empty($errors)) {
    foreach ($errors as $error) {
        error_log($error);
    }
    exit('Data validation failed: ' . $error);
} else {
    echo "Full data validaton success! ";
}

//upload now verified values to the orderinfo table to the database 8all with status "COMPLETED"
class UploadOrderWebhook extends Dbh
{
    public function uploadWebhook($paymentID, $quantity, $price, $customerID, $ISBN, $clientsideTimestamp, $order_status, $shipping_address_country_name, $shipping_address_city_name, $shipping_address_postal_code_name, $shipping_address_street_name, $updateOrders)
    {
        $bookID = null;

        //if $updateOrders = true and not false, we search for the records in the db where the status = "PENDING", and where CustomerID = $customerID
        try {
            $query = "SELECT BookID FROM bookinfo WHERE ISBN = ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([$ISBN]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $bookID = $result['BookID'];
            } else {
                error_log("No book found with ISBN: $ISBN");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database error in book lookup: " . $e->getMessage());
            return false;
        }

        //no existing orders as updateOrders is false, so insert instead of update fields inside db
        if (!$updateOrders) {
            try {
                $clientsideTimestamp = new DateTime($clientsideTimestamp);
                $formattedTimestamp = $clientsideTimestamp->format('Y-m-d H:i:s');

                $query = "INSERT INTO orderinfo (PaymentID, Quantity, Total, CustomerID, BookID, OrderDate, status, delivery_country, delivery_city, delivery_postal_code, delivery_street_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                $stmt = $this->connect()->prepare($query);

                if (!$stmt) {
                    throw new PDOException("Query preparation failed: " . $this->connect()->errorInfo()[2]);
                }

                $result = $stmt->execute([$paymentID, $quantity, $price, $customerID, $bookID, $formattedTimestamp, $order_status, $shipping_address_country_name, $shipping_address_city_name, $shipping_address_postal_code_name, $shipping_address_street_name]);

                if (!$result) {
                    throw new PDOException("Query failed: " . $stmt->errorInfo()[2]);
                }

                return $result;
            } catch (PDOException $e) {
                error_log("Database error in order insertion: " . $e->getMessage());
                return false;
            }
        }
        //in else, as both shopping cart values and real orders are saved in table orderinfo, but have different status, the correct shopping cart records are updated to real orders, therefore, shipping address and status is created / modified
        else {
            try {
                $totalPrice = $price;
                $clientsideTimestamp = new DateTime($clientsideTimestamp);
                $formattedTimestamp = $clientsideTimestamp->format('Y-m-d H:i:s');

                $query = "UPDATE orderinfo SET OrderDate = ?, status = ?, delivery_country = ?, delivery_city = ?, delivery_postal_code = ?, delivery_street_address = ?, Total = ? WHERE CustomerID = ? AND status = 'PENDING' AND BookID = ?;";
                $stmt = $this->connect()->prepare($query);

                if (!$stmt) {
                    throw new PDOException("Query preparation failed: " . $this->connect()->errorInfo()[2]);
                }

                $result = $stmt->execute([$formattedTimestamp, $order_status, $shipping_address_country_name, $shipping_address_city_name, $shipping_address_postal_code_name, $shipping_address_street_name, $totalPrice, $customerID, $bookID]);

                if (!$result) {
                    throw new PDOException("Query failed: " . $stmt->errorInfo()[2]);
                }

                return $result;
            } catch (PDOException $e) {
                error_log("Database error in order update: " . $e->getMessage());
                return false;
            }
        }
    }
}

//implement complete single cart item process comparison... [12]

$uploadOrder = new UploadOrderWebhook();
//all ordered items (books) are iterated over from the received paypal webhook, so webhook data is used to upload all data in database
$items = $json_data->resource->purchase_units[0]->items;

//iterate over webhook items JSON
foreach ($items as $item) {

    //call the uploader method each time, to upload a new order
    $ISBN = $item->name;
    $quantity = intval($item->quantity);
    $price = floatval($item->unit_amount->value);
    $totalPrice = $quantity * $price;

    $result = $uploadOrder->uploadWebhook($paymentID, $quantity, $totalPrice, $customerID, $ISBN, $clientsideTimestamp, $order_status, $shipping_address_country_name, $shipping_address_city_name, $shipping_address_postal_code_name, $shipping_address_street_name, $updateOrders);

    if ($result) {
        echo "Successfully uploaded order for ISBN: $ISBN\n";
    } else {
        echo "Failed to upload order for ISBN: $ISBN\n";
    }
}

//finally, pass result to webhook back, if everything works as expected, and no errors occur, 1 is passed
echo ("Result is: $result\n");
