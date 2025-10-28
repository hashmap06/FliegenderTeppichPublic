<?php
// gets called when book gets added to shopping cart via 'Einkaufswagen' button
// accesses the shopping_cart cookie, and updates the value, by either creating a new field with new book isbn as key, or by augumenting quantity of book, by accessing already existing isbn key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON format. JSON Error: ' . json_last_error_msg()]);
        exit;
    }

    $ISBN = $data['ISBN'] ?? null;
    if (!$ISBN) {
        http_response_code(400);
        echo json_encode(['error' => 'ISBN not provided in the request.']);
        exit;
    }

    // Cookie name
    $cookieName = 'shopping_cart';

    // Check if cookie already exists
    if (isset($_COOKIE[$cookieName])) {
        $cart = json_decode($_COOKIE[$cookieName], true);
    } else {
        $cart = [];
    }

    // Update the quantity of the book in the cart
    if (isset($cart[$ISBN])) {
        $cart[$ISBN] += 1;
    } else {
        $cart[$ISBN] = 1;
    }

    // Set or update the cookie
    setcookie($cookieName, json_encode($cart), time() + 86400 * 30, "/"); // Cookie expires in 30 days

    // Prepare the response
    $response = "ISBN $ISBN added to the shopping cart.";

    header('Content-Type: application/json');
    echo json_encode(['message' => $response]);
} else {
    http_response_code(405);
    echo json_encode(['error' => "Invalid request method"]);
}