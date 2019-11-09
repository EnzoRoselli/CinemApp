<?php

namespace Model;

class Cine
{
    private $name;
    private $address;  
    private $id;
    private $active;
    private $theaters;
    private $capacity;

    public function __construct($name = "", $address = "")
    {
        $this->name = $name;
        $this->address = $address;
        $this->theaters = array();
    }

    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getAddress(){return $this->address;}
    public function getActive(){return $this->active;}
    public function getTheaters(){return $this->theaters;}
    public function getCapacity(){
        foreach($this->theaters as $theater){
            $this->capacity += $theater->getCapacity();
        }
        return $this->capacity;
    }


    public function setName($name){$this->name = $name;}
    public function setAddress($address){$this->address = $address;}
    public function setId($id){$this->id = $id;}
    public function setActive($active){$this->active = $active;}
    public function setCapacity($capacity){$this->$capacity = $capacity;}

    public function addTheater($theater){
        array_push($this->theaters, $theater);
    }

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
