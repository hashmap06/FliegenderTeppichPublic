<?php

//return false if everything ok, dont extend dbh class

//simple checker class to start 

class dataChecker {
    public $bookISBN;
    public $bookPrice;
    public $bookAuthor;
    public $bookGenre;
    public $bookName;
    public $bookPublishYear;
    public $bookDescription;
    public $bookType;

    public function __construct(
        $bookISBN,
        $bookPrice,
        $bookAuthor,
        $bookGenre,
        $bookName,
        $bookPublishYear,
        $bookDescription,
        $bookType
    ) {
        $this->bookISBN = $bookISBN;
        $this->bookPrice = $bookPrice;
        $this->bookAuthor = $bookAuthor;
        $this->bookGenre = $bookGenre;
        $this->bookName = $bookName;
        $this->bookPublishYear = $bookPublishYear;
        $this->bookDescription = $bookDescription;
        $this->bookType = $bookType;
    }

    public function validateData() {
        $data = array(
            "bookISBN" => $this->bookISBN,
            "bookPrice" => $this->bookPrice,
            "bookAuthor" => $this->bookAuthor,
            "bookGenre" => $this->bookGenre,
            "bookName" => $this->bookName,
            "bookPublishYear" => $this->bookPublishYear,
            "bookDescription" => $this->bookDescription,
            "bookType" => $this->bookType
        );


        /*
        fucntion to check if there is any duplicate ISBN, among other books as they are used as uniqe key for payment
        */

        foreach ($data as $key => $value) {
            if ($value === null || $value === -1 || (!is_string($value) && !is_int($value))) {
                return true;
                exit();
            }
            //else if (bookISBN) {Write customized ISBN checker function to see if it is an ISBN}
        }
        return false;
        exit();
    }
}
