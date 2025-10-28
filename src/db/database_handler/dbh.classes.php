<?php

class Dbh
{
    public function connect()
    {
        try {
            $dbusername = "root";
            $dbpassword = getenv('DB_PASS') ?: 'you';
            $dbh = new PDO('mysql:host=localhost;dbname=FliegenderTeppich', $dbusername, $dbpassword);
            return $dbh;
        } catch (PDOException $e) {
            print "Fehler!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
