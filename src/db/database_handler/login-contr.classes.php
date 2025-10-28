<?php
class loginContr extends Login {

    private $uid;
    private $pwd;

    public function __construct($uid, $pwd)
    {
        $this->uid = $uid;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if ($this->emptyInput() == true) {
            header("location: /index.php?error=emptyinput");
            exit();
        }
        
        // Make sure the getUser method exists in the Login class
        $this->getUser($this->uid, $this->pwd);
    }

    private function emptyInput() {
        return (empty($this->uid) || empty($this->pwd));
    }

    // Other methods and logic for the Login class...
}
