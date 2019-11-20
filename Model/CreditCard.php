<?php
namespace Model;



class CreditCard{

    private $id;
    private $number;
    private $user;
    private $security_code;



    public function __construct($number = "",$user = null, $security_code = ""){
        $this->number=$number;
        $this->user=$user;
        $this->security_code=$security_code;
    }

    public function getId(){ return $this->id;}
    public function getNumber(){return $this->number;}
    public function getUser(){return $this->user;}
    public function getSecurity_code(){return $this->security_code;}
    public function getLastFour(){
        return substr($this->getNumber(), -4);
    }

    
    public function setId($id){$this->id = $id;}
    public function setNumber($number){$this->number=$number;}
    public function setUser($user){$this->user=$user;}
    public function setSecurity_code($security_code){$this->security_code = $security_code;}
}



?>