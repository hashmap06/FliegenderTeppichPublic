<?php

class CheckComments {
    public function __construct($name, $comment, $email = -1, $phone = -1) {
        if ($email === -1 || $phone === -1) {
            if ($this->checkCommentValue($name, $comment)) {
                throw new Exception("Fields are empty or not valid.");
                exit();
            }
        }
        else {
            if ($this->checkNormalCommentValue($name, $comment, $email, $phone)) {
                echo("Written values are faulty or incomplete.");
                exit();
            }
        }
    }
    

    private function checkCommentValue($name, $comment) {
        if ($name === null || $comment === null) {
            return true;
        } elseif (strlen($name) <= 3 || strlen($comment) < 10) {
            return true;
        }
        return false;
    }

    private function checkNormalCommentValue($name, $comment, $email, $phone) {
        if ($this->checkCommentValue($name, $comment) || $email === -1) {
            return true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}


