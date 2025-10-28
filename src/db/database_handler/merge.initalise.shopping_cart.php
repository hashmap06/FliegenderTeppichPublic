<?php

class FetchBook extends Dbh {
    // Merges the shopping cart data from cookies and database
    public function mergeData() {
        // Check if the user is logged in
        if (isset($_SESSION['CustomerID'])) {

            // Mark that the user visited the shopping cart
            $_SESSION['shopping_cart_visited'] = true;
    
            // Load the cart from the cookie, or create a new one if it doesn't exist
            $cart = isset($_COOKIE['shopping_cart']) ? json_decode($_COOKIE['shopping_cart'], true) : [];
    
            // Fetch the cart data from the database
            $dbCart = $this->fetchDatabaseCartData();
            $dbCart = json_decode($dbCart, true);

    
            // Merge the database cart with the cookie cart
            foreach ($dbCart as $ISBN => $dbQuantity) {
                if (isset($cart[$ISBN])) {
                    // Update the quantity with the maximum value
                    $cart[$ISBN] = max($cart[$ISBN], $dbQuantity);
                } else {
                    // Add the item to the cart
                    $cart[$ISBN] = $dbQuantity;
                }
            }

            // Try setting the updated cart back into the cookie
            try {
                $cookieSet = setcookie('shopping_cart', json_encode($cart), time() + 3600 * 24 * 30, '/');
                
                return $cookieSet;
            } catch (Exception $e) {
                // If setting the cookie fails, return false
                error_log("Failed to set the shopping_cart cookie: " . $e->getMessage());
                return false;
            }
        }
    }

    // Fetches the cart data from the database
    private function fetchDatabaseCartData() {
        $dbData = [];
        try {
            // Connect to the database
            $db = $this->connect();
            // Prepare the query to fetch cart data
            $query = "SELECT b.ISBN, o.Quantity FROM orderinfo o JOIN bookinfo b ON o.BookID = b.BookID WHERE o.CustomerID = ? AND o.status = 'PENDING';";
            $stmt = $db->prepare($query);
            $stmt->execute([$_SESSION['CustomerID']]);
    
            $dbData = [];
            // Loop through the results and add them to the cart
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (isset($dbData[$row['ISBN']])) {
                    // If the item already exists in the cart, increment the quantity
                    $dbData[$row['ISBN']] += $row['Quantity'];
                } else {
                    // Otherwise, add the new item to the cart
                    $dbData[$row['ISBN']] = $row['Quantity'];
                }
            }
            $db = null;
            // Return the cart data as a JSON string
            return json_encode($dbData);
        } catch (PDOException $e) {
            // Print the error message and stop the script
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
