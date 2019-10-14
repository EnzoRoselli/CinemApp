<?php
namespace Model;



class User{
    private $email;
    private $password;
    private $name;

    public function __construct($email,$password){
        $this->email=$email;
        $this->password=$password;
    }

    public function getName(){return $this->name;}
    public function getEmail(){return $this->email;}
    public function getPassword(){return $this->password;}

    public function setName($name){$this->name=$name;}
    public function setEmail($email){$this->email=$email;}
    public function setPassword($password){$this->password=$password;}

}
