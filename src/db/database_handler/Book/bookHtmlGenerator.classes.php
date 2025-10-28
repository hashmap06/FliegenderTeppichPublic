<?php

//include('../dbh.classes.php');

//-----------------------------------------------------------------------------
class FetchBook extends Dbh {
    public function FetchBookData() {
        try {
            $db = $this->connect();

            //$query = "SELECT * FROM bookinfo"; old query simple fetch bookinfos

            $query = "
            (SELECT BookID, ISBN, Price, Author, Genre, BookName, ifReal, PublishYear, filepath, subpagepath, 'Real' AS Category 
            FROM bookinfo 
            WHERE ifReal = 1)
            UNION ALL
            (SELECT BookID, ISBN, Price, Author, Genre, BookName, ifReal, PublishYear, filepath, subpagepath, 'Fictional' AS Category 
            FROM bookinfo 
            WHERE ifReal = 0)
            ORDER BY ifReal DESC, PublishYear DESC, Price DESC;"; // use of cross table parameterized SQL statement, (UNION)

            //-------------------------

            // PIVOT SQL statement cant be used, as a MySQL server is utilized

            // This SQL query utilizes the UNION ALL statement to combine real and fictional books from the 'bookinfo' table into a unified result set, distinctly categorized under 'Real' or 'Fictional' using a custom 'Category' column. 
            // It ensures that both categories are presented together, with real books appearing first, followed by fictional ones. 
            // Books within each category are further ordered by their publication year (newest first) and price (highest first), facilitating an organized display on the shop subpage that prioritizes recent and premium books. 
            // The choice of UNION ALL allows for the inclusion of all records, accommodating any overlaps without filtering out duplicates, thereby ensuring a comprehensive listing.

            //--------------------------

            $stmt = $db->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $db = null;

            return $result;

        } catch (PDOException $e) {
            print "Fehler!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

$fetchBook = new FetchBook();
$bookInfo = $fetchBook->FetchBookData();

$bookPrinter = new bookPrint($bookInfo);

class bookPrint {
    public function __construct($bookInfo) {
        foreach ($bookInfo as $book) {
            $ISBN = htmlspecialchars($book['ISBN']);
            $BookID = htmlspecialchars($book['BookID']);
            $Price = htmlspecialchars($book['Price']);
            $Author = htmlspecialchars($book['Author']);
            $Genre = htmlspecialchars($book['Genre']);
            $BookName = htmlspecialchars($book['BookName']);
            $ifReal = htmlspecialchars($book['ifReal']);
            $PublishYear = htmlspecialchars($book['PublishYear']);
            $BookPicture = htmlspecialchars($book['filepath']);
            $bookPageURL = htmlspecialchars($book['subpagepath']);

            //if (strpos($Price, '.') !== false) {
            $Price = number_format($Price, 2);
            //}
            if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
                echo '<div class="BookDiv" id="bigger-book-grid">
                        <div class="delete-icon-apply" id="' . $BookID . '" >
                            <a href="db/database_handler/Book/delete-specific-book.php?bookID=' . $BookID . '"> 
                            <img src="../../../img/png icons/delete-icon.png" alt="Delete Icon" style="width: 20px; height: 20px; filter: hue-rotate(90deg) saturate(150%);"> </a>
                        </div>
                        <a href="' . $bookPageURL . '">
                            <img src="' . $BookPicture . '" alt="Book Cover">
                            <p class="BookNameGrid">' . $BookName . '</p>
                            <h5>' . $Price . '&#8364;</h5>
                        </a>
                    </div>';
            } else {
                echo '<div class="BookDiv">
                    <a href="' . $bookPageURL . '">
                        <img src="' . $BookPicture . '" alt="Book Cover">
                        <p class="BookNameGrid">' . $BookName . '</p>
                        <h5>' . $Price . '&#8364;</h5>
                    </a>
                </div>';            
            }
            
        }
    }
}


