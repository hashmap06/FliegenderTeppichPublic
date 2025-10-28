<?php
if (isset($_POST["submit"])) {

    $name = $_POST["firstname"];
    $comment = $_POST["subject"];
    $userID = $_POST["UID"];


    include "errorCheck.comment.connect.php";
    include_once "dbh.classes.php";
    include "comment.connect.php";

    $checkComment = new CheckComments($name, $comment);

    //$addComment = new AddComment($name, $comment, $userID);

    if ($checkerMethod == false) {
        $addComment = new AddComment(
            $name, $comment, $userID
        );
        header('Location: /index.php?status=sent_successfully');
    }
}