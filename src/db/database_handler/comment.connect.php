<?php
class AddComment extends Dbh {
    private $dbh;

    public function __construct($name, $comment, $uid, $email = -1, $phone = -1) {
        $this->dbh = $this->connect();

        if ($uid == -1) {
            $this->getCommentNormal($name, $comment, $email, $phone);
        }
        else {
            $this->getComment($name, $comment, $uid);
        }

    }

    protected function getComment($name, $comment, $userID) {
        $sql = "INSERT INTO messages (CustomerID, messageText, NonCustomerName, creationDate) VALUES (?, ?, ?, NOW())";

        $sql2 = "UPDATE custinfo SET Name = ? WHERE CustomerID = ?";
        
        $db = $this->connect();

        //prepare $ exec name updater
        $stmt = $db->prepare($sql2);
        if ($stmt->execute([$name, $userID])) {
            //prepare & exec. message uploader
            $stmt = $db->prepare($sql);
            if ($stmt->execute([$userID, $comment, $name])) {
                return true;
            } 
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    protected function getCommentNormal($name, $comment, $email, $phone) {
        $sql = "INSERT INTO messages (NonCustomerName, messageText, email, phoneNumber, creationDate) VALUES (?, ?, ?, ?, NOW())";

        $db = $this->connect();

        //prepare & exec.
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$name, $comment, $email, $phone])) {
            return true;
        } 
        else {
            return false;
        }
    }
}

