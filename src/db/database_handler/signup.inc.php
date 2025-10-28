<?php

if (isset($_POST["submit"])) {

    // grabbing the data
    $uid = $_POST["uname"];
    $pwd = $_POST["psw"];
    $email = $_POST["email"];
    $pwdRepeat = $_POST["psw_repeat"];

    // instantiate SignupContr class
    include "dbh.classes.php";
    include "signup.classes.php";
    include "signup-contr.classes.php";
    
    // running error handlers and user signup

    $signup = new SignupContr($uid, $pwd, $pwdRepeat, $email);

    $signup->signupUser();
    

    // go back to front page

    header("location: /index.php?error=none");

}