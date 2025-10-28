<?php
if (isset($_POST["submit"])) {

    include('imgUploader.php');

    $fileUploader = new FileUploader();
    $FilePath = $fileUploader->uploadFile();

    $bookISBN = $_POST["isbn"];
    $bookPrice = $_POST["price"];
    $bookAuthor = $_POST["author"];
    $bookGenre = $_POST["genre"];
    $bookName = $_POST["bookName"];
    $bookPublishYear = $_POST["publishYear"];
    $bookDescription = $_POST["description"];
    $bookType = $_POST["ebookType"];

    //if (strpos($bookPrice, '.') !== false) {
    $bookPrice = number_format($bookPrice, 2);
    //}
    $bookISBN = (int)str_replace(' ', '', $bookISBN);
    $bookISBN = (int)str_replace('-', '', $bookISBN);


    include('dataChecker.classes.php');


    $checkInstance = new dataChecker(
        $bookISBN,
        $bookPrice,
        $bookAuthor,
        $bookGenre,
        $bookName,
        $bookPublishYear,
        $bookDescription,
        $bookType
    );

    if ($checkInstance->validateData()) {
        echo ('Not all input values valid');
        header('Location: ../../../dashboard.addBook.php');
        exit();
    };

    //create bookfile
    include('bookFileCreator.php');

    $PageUploader = new subPageCreator();
    $PagePath = $PageUploader->createSubpage(
        $bookISBN,
        $bookPrice,
        $bookAuthor,
        $bookGenre,
        $bookName,
        $bookPublishYear,
        $bookDescription,
        $bookType,
        $FilePath
    );


    include('../dbh.classes.php');
    include('bookUpload.classes.php');

    $databaseInstance = new bookUpload(
        $bookISBN,
        $bookPrice,
        $bookAuthor,
        $bookGenre,
        $bookName,
        $bookPublishYear,
        $bookDescription,
        $bookType,
        $FilePath,
        $PagePath
    );

    $databaseInstance->setBookUser();



    header('Location: ../../../dashboard.startmenu.php?bookSuccessfullyAdded');
    exit();
}
