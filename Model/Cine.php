<?php

namespace Model;

class Cine
{
    private $name;
    private $address;  
    private $id;
    private $active;

    public function __construct($name = "", $address = "")
    {
        $this->name = $name;
        $this->address = $address;
    }

    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getAddress(){return $this->address;}
    public function getActive(){return $this->active;}


    public function setName($name){$this->name = $name;}
    public function setAddress($address){$this->address = $address;}
    public function setId($id){$this->id = $id;}
    public function setActive($active){$this->active = $active;}

    public function equals($cine)
    {
        if ($this->getName() === $cine->getName() && $this->getAddress() === $cine->getAddress()) {
            return true;
        } else {
            return false;
        }
    }

    public function testValuesValidation()
    {
        if (!empty($this->name) && !empty($this->address)){return true;}
        else{return false;}
    }
}
