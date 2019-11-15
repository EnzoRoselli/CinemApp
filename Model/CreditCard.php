<?php
namespace Model;



class CreditCard{

    private $id;
    private $number;
    private $user;



    public function __construct($number="",$user=""){
        $this->number=$number;
        $this->user=$user;
  
    }

    public function getId(){ return $this->id;}
    public function getNumber(){return $this->number;}
    public function getUser(){return $this->user;}

    public function setId($id){$this->id = $id;}
    public function setNumber($number){$this->number=$number;}
    public function setUser($user){$this->user=$user;}

}



?>