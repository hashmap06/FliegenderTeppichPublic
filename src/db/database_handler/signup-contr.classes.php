<?php
class SignupContr extends Signup{
    private $uid;
    private $pwd;
    private $pwdrepeat;
    private $email;

    public function __construct($uid, $pwd, $pwdrepeat, $email)
    {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdrepeat = $pwdrepeat;
        $this->email = $email;
    }

    private function emptyInput() {
        return (empty($this->uid) || empty($this->pwd) || empty($this->pwdrepeat) || empty($this->email));
    }
    
    private function validUID() {
        return (preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $this->uid));
    }
    
    private function validEmail() {
        return (filter_var($this->email, FILTER_VALIDATE_EMAIL));
    }
    
    private function passwordsMatch() {
        return ($this->pwd === $this->pwdrepeat);
    }
    
    private function usersMatch() {
        return (!$this->checkUser($this->uid, $this->email));
    }
    
    public function signupUser() {
        // Make sure to assign values to the properties like $this->uid, $this->pwd, etc.
        // with the actual user input before calling these validation methods
    
        if ($this->emptyInput()) {
            header("location: /index.php?error=input_empty");
            exit();
        }
        if (!$this->validUID()) {
            header("location: /index.php?error=username_invalid");
            exit();
        }   
        if (!$this->validEmail()) {
            header("location: /index.php?error=email_invalid");
            exit();
        }
        if (!$this->passwordsMatch()) {
            header("location: /index.php?error=passwordsdontmatch");
            exit();
        }
        if ($this->usersMatch()) {
            header("location: /index.php?error=username_or_email_taken");
            exit();
        }
    
        // If all validations pass, you can proceed with the signup action
        $this->setUser($this->uid, $this->pwd, $this->email);
    }
    
    
}