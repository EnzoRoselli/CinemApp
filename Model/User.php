<?php
namespace Model;



class User{
    private $id;
    private $email;
    private $password;
    private $name;
    private $lastName;
    private $dni;

    public function __construct($email="",$password=""){
        $this->email=$email;
        $this->password=$password;
    }

    public function getId(){return $this->id;}
    public function getEmail(){return $this->email;}
    public function getPassword(){return $this->password;}
    public function getName(){return $this->name;}
    public function getLastName(){return $this->lastName;}
    public function getDni(){return $this->dni;}

    public function setId($id){$this->id; $id;}
    public function setEmail($email){$this->email=$email;}
    public function setPassword($password){$this->password=$password;}
    public function setName($name){$this->name=$name;}
    public function setLastName($lastName){$this->lastName=$lastName;}
    public function setDni($dni){$this->dni=$dni;}

}
