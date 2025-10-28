<?php
require_once 'dbh.classes.php';

class WochentageDb extends Dbh {
    private $dbh;

    public function __construct() {
        $this->dbh = $this->connect();
    }

    public function updateWochentage($angemeldet) {
        $StringWeekDay = $this->getStringWeekDay();
        if ($angemeldet == true) {
            $status = 'Angemeldet';
        }
        else {
            $status = 'Nichtangemeldet';
        }
        $WeekDay = $StringWeekDay . "_" . $status;

        $json_file = __DIR__ . '/../../JSON/WeeklyClicks.json';

        $json_data = file_get_contents($json_file);
        $data = json_decode($json_data, true);
        $data[$WeekDay]++;
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($json_file, $json_data);

        //MYSQL Data Transfer
        $sql = "UPDATE wochentage SET `$WeekDay` = COALESCE(`$WeekDay`, 0) + 1 WHERE id = 2;";
        $stmt = $this->dbh->query($sql);

        if ($stmt === false) {
            echo "Error updating record: " . $this->dbh->errorInfo()[2];
        }
    }

    public function getStringWeekDay() {
        date_default_timezone_set('Europe/Berlin');
        return date('l');
    }
}