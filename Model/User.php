<?php
namespace Model;



class User{
    private $email;
    private $password;
    private $username;
    private $name;
    private $lastName;
    private $dni;

    public function __construct($email,$password){
        $this->email=$email;
        $this->password=$password;
    }

    public function getUsername(){return $this->username;}
    public function getEmail(){return $this->email;}
    public function getPassword(){return $this->password;}
    public function getName(){return $this->name;}
    public function getLastName(){return $this->lastName;}
    public function getDni(){return $this->dni;}

    public function setUsername($username){$this->name=$username;}
    public function setEmail($email){$this->email=$email;}
    public function setPassword($password){$this->password=$password;}
    public function setName($name){$this->name=$name;}
    public function setLastName($lastName){$this->lastName=$lastName;}
    public function setDni($dni){$this->dni=$dni;}

}
