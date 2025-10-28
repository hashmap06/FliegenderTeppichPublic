<?php

if (isset($_GET['bookID'])) {
    $bookID = $_GET['bookID'];
    include("../dbh.classes.php");

    $dbh = (new Dbh())->connect();

    $stmt = $dbh->prepare("SELECT subpagepath FROM bookinfo WHERE BookID = :bookID");
    $stmt->bindParam(':bookID', $bookID, PDO::PARAM_INT);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $subpagePath = $row['subpagepath'];
        $subpagePath = '../../../' . $subpagePath;

        // First, try to delete the book record from the database
        $deleteStmt = $dbh->prepare("DELETE FROM bookinfo WHERE BookID = :bookID");
        $deleteStmt->bindParam(':bookID', $bookID, PDO::PARAM_INT);

        try {
            if ($deleteStmt->execute()) {
                echo "Book record deleted successfully.";

                // Proceed to delete the file only if the DB record is successfully deleted
                if (file_exists($subpagePath)) {
                    if (unlink($subpagePath)) {
                        echo " File deleted successfully.";
                    } else {
                        echo " Error in deleting file.";
                    }
                } else {
                    echo " File does not exist.";
                }
            } else {
                echo " Error in deleting book record. Book might be used in an order.";
            }
        } catch (PDOException $e) {
            // Catch any PDO exceptions (like foreign key constraint issues)
            echo " Error: " . $e->getMessage() . " - Book might be used in an order.";
        }

        echo '<a href="../../../shop.php">Return back to shop</a>';

    } else {
        echo "No record found for BookID: $bookID.";
    }
}
