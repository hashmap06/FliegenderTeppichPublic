<?php
if (isset($_POST["submit"])) {

    $name = $_POST["firstname"];
    $comment = $_POST["subject"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];



    include "errorCheck.comment.connect.php";
    include_once "dbh.classes.php";
    include "comment.connect.php";

    $checkComment = new CheckComments($name, $comment, $email, $phone);
    //check if phone value isset null || change it use predefined parameters

    //if ($checkerMethod == false) {
    $addComment = new AddComment(
        $name, $comment, -1, $email, $phone
    );
    header('Location: /index.php?status=sent_successfully');
    exit();
    //}
    //else {
    //    exit();
    //}
}