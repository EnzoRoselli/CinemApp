<?php 

namespace Model;

class Theater  
{
    private $id;
    private $name;
    private $cinema;
    private $active;
    private $ticketValue;
    private $capacity;

    public function __construct($name = "", $cinema = "", $active = "", $ticketValue = "", $capacity = "")
    {
        $this->name = $name;
        $this->cinema = $cinema;
        $this->active = $active;
        $this->ticketValue = $ticketValue;
        $this->capacity = $capacity;
    }

    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getCinema(){return $this->cinema;}
    public function getActive(){return $this->active;}
    public function getTicketValue(){return $this->ticketValue;}
    public function getCapacity(){return $this->capacity;}

    public function setId($Id){$this->id=$Id;}
    public function setName($name){$this->name=$name;}
    public function setCinema($cinema){$this->cinema=$cinema;}
    public function setActive($active){$this->active=$active;}
    public function setTicketValue($ticketValue){$this->ticketValue=$ticketValue;}
    public function setCapacity($capacity){$this->capacity=$capacity;}


}























?>