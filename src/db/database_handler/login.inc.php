<?php
if (isset($_POST["submit"])) {
    // grabbing Info from Form
    $uid = $_POST["uname"];
    $pwd = $_POST["psw"];


    // instantiate signup conter class
    include_once "dbh.classes.php";
    include "login.classes.php";
    include "login-contr.classes.php";
    $login = new loginContr(
        $uid, $pwd
    );

    
    // running error handling
    $login->loginUser();

    // go back to front page
    header("location: /shop.php?error=none");
}