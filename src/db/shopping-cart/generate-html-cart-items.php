<?php

// Including the database handler class
require_once(__DIR__ . '/../database_handler/dbh.classes.php');

class FetchBook extends Dbh {
    // Fetches book data based on the shopping cart contents
    public function FetchBookData() {
        $books = [];
        // Check if there's a shopping cart cookie
        if (isset($_COOKIE['shopping_cart'])) {
            // Decode the JSON-encoded shopping cart cookie
            $cart = json_decode($_COOKIE['shopping_cart'], true);
            // Loop through the cart items
            foreach ($cart as $ISBN => $quantity) {
                try {
                    // Connect to the database
                    $db = $this->connect();
                    // Prepare the query to get book details
                    $query = "SELECT * FROM bookinfo WHERE ISBN = ?";
                    $stmt = $db->prepare($query);
                    $stmt->execute([$ISBN]);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // If there are results, add them to the books array
                    if ($result) {
                        $books[] = array_merge($result[0], ['TotalQuantity' => $quantity]);
                    }
                    $db = null;
                } catch (PDOException $e) {
                    // Print the error message if something goes wrong
                    print "Fehler!: " . $e->getMessage() . "<br/>";
                    die();
                }
            }
        }
        return $books;
    }
}

// Create an instance of FetchBook and fetch book data
$fetchBook = new FetchBook();
$bookInfo = $fetchBook->FetchBookData();
$bookPrinter = new bookPrint($bookInfo);

class bookPrint {
    // Constructor takes bookInfo and prints book details
    public function __construct($bookInfo) {
        // Loop through each book and print its details
        foreach ($bookInfo as $book) {
            // Extracting book details
            $BookID = $book['BookID'];
            $Price = $book['Price'];
            $Author = $book['Author'];
            $BookName = $book['BookName'];
            $ISBN = $book['ISBN'];
            // Default quantity to 1 if not set
            $Quantity = $book['TotalQuantity'] ?? 1;
            // Remove spaces from ISBN
            $ISBN = intval(str_replace(' ', '', $ISBN));

            // Print the book in HTML format
            echo '
                <div class="item">

                    
                    <div class="image">
                        <img src="' . htmlspecialchars($book['filepath']) . '" alt="' . htmlspecialchars($BookName) . '" width="60px" height="60px" style="border-radius: 4px;"/>
                    </div>
                    
                    <div class="description">
                        <span>' . htmlspecialchars($BookName) . '</span>
                        <span>' . htmlspecialchars($Author) . '</span>
                        <span id="bookPriceNormal">&euro;' . number_format($Price, 2) . '</span>
                    </div>
                    
                    <div class="quantity" id="' . htmlspecialchars($ISBN) . '">


                        <button class="minus-btn" type="button" name="button" onclick="decrementQuantity(' . htmlspecialchars($ISBN) . ')">
                            <div class="minus-btn-inside">
                                <h2>&minus;</h2>
                            </div>
                        </button>


                        <input id="2 ' . htmlspecialchars($ISBN) . '" type="text" name="name" value="' . htmlspecialchars($Quantity) . '" onkeydown="updateQuantity(event, ' . htmlspecialchars($ISBN) . ')">


                        <button class="plus-btn" type="button" name="button" onclick="augumentQuantity(' . htmlspecialchars($ISBN) . ')">
                            <div class="plus-btn-inside">
                                <h2>&plus;</h2>
                            </div>
                        </button>


                    </div>

                    <div class="books-metadata" style="display: none;">' . htmlspecialchars($BookID) . 'AND' . htmlspecialchars($ISBN) . '</div>

                    <div class="total-price" id="' . htmlspecialchars($BookID) . '" >&euro;' . number_format(($Price), 2) . '</div>
                </div>';
        }
    }
}