<?php
include('dbh.classes.php');

class FetchComment extends Dbh
{
    public function fetchAndDisplayMessages()
    {
        $query = "SELECT messageText, NonCustomerName, creationDate, email, phoneNumber FROM messages ORDER BY creationDate DESC";

        try {
            $stmt = $this->connect()->query($query);

            if (!$stmt) {
                print "Database query failed: " . $this->connect()->errorInfo()[2];
                die();
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $messageText = $row['messageText'];

                if (!empty($row['phoneNumber'])) {
                    $messageText .= '<br>Telefonnummer: ' . $row['phoneNumber'];
                }

                if (!empty($row['email'])) {
                    $messageText .= '<br>Email Adresse: ' . $row['email'];
                }

?>
                <tr>
                    <td><?php echo $row['NonCustomerName']; ?></td>
                    <td><?php echo $messageText; ?></td>
                    <td><?php echo $row['creationDate']; ?></td>
                </tr>
<?php
            }
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage();
            die();
        }
    }
};
