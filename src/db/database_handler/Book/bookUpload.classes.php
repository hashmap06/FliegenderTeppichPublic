<?php
class bookUpload extends Dbh {

    public $bookISBN;
    public $bookPrice;
    public $bookAuthor;
    public $bookName;
    public $bookPublishYear;
    public $bookDescription;
    public $bookType;
    public $bookGenre;
    public $FilePath;
    public $PagePath;
    
    public function __construct(
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
    ) {
        $this->bookISBN = $bookISBN;
        $this->bookPrice = $bookPrice;
        $this->bookAuthor = $bookAuthor;
        $this->bookGenre = $bookGenre;
        $this->bookName = $bookName;
        $this->bookPublishYear = $bookPublishYear;
        $this->bookDescription = $bookDescription;
        $this->bookType = $bookType;
        $this->FilePath = $FilePath;
        $this->PagePath = $PagePath;
    }
    
    public function setBookUser() {
        $isbn = $this->bookISBN;
        $price = $this->bookPrice;
        $author = $this->bookAuthor;
        $genre = $this->bookGenre;
        $bookName = $this->bookName;
        $ifReal = $this->bookType;
        $publishYear = $this->bookPublishYear; 
        $PathOfFile = $this->FilePath;   
        $PagePath = $this->PagePath;
        

        try {
            $query = "INSERT INTO bookinfo (ISBN, Price, Author, Genre, BookName, ifReal, PublishYear, filepath, subpagepath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($query);
            
            if (!$stmt) {
                throw new PDOException("Query preparation failed: " . $this->connect()->errorInfo()[2]);
            }
            
            $result = $stmt->execute([$isbn, $price, $author, $genre, $bookName, $ifReal, $publishYear, $PathOfFile, $PagePath]);

            if (!$result) {
                throw new PDOException("Query failed : " . $stmt->errorInfo()[2]);
            }

            return $this->connect()->lastInsertId();
            

        } catch (PDOException $e) {
            print "Error: " . $e->getMessage();
            die();
        }
    }
}
