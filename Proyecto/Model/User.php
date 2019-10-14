<?php
namespace Model;

require_once("../Config/Autoload.php");

class User{
    private $email;
    private $password;

    public function __construct($email,$password){
        $this->email=$email;
        $this->password=$password;
    }


    public function getEmail(){return $this->email;}
    public function getPassword(){return $this->password;}

    public function setEmail($email){$this->email=$email;}
    public function setPassword($password){$this->password=$password;}

}


?>