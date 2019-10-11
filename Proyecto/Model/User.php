<?php
namespace Model;

require_once("../Config/Autoload.php");

class User{
    private $name;
    private $email;
    private $password;
    private $id;
    private static $counter=0;

    public function __construct($email,$password){
        $this->email=$email;
        $this->password=$password;
        $this->id=User::$counter++;
    }

    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getEmail(){return $this->email;}
    public function getPassword(){return $this->password;}

    public function setName($name){$this->name=$name;}
    public function setEmail($email){$this->email=$email;}
    public function setPassword($password){$this->password=$password;}

}


?>