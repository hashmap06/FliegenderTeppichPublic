<?php
class Signup extends Dbh {
    protected function setUser($uid, $pwd, $email) {
        $stmt = $this->connect()->prepare('INSERT INTO custinfo (username, UserPassword, EmailAddress) VALUES (?, ?, ?);');

        $hashedPassword = password_hash($pwd, PASSWORD_ARGON2I);

        if (!$stmt->execute(array($uid, $hashedPassword, $email))) {
            $stmt = null;
            header("location: /index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }
    // Check DataBase for the UID

    protected function checkUser($uid, $email) {
        $stmt = $this->connect()->prepare('SELECT username FROM custinfo WHERE username = ? OR EmailAddress = ?;');
        if (!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            header('Location: /index.php?error=stmtfailed');
            exit();
        }
        $CheckResult = null;
        if ($stmt->rowCount() > 0) {
            $CheckResult = false;
        }
        else {
            $CheckResult = true;
        }
        return $CheckResult;
    }

}
