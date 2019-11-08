<?php 

namespace Model;

class Theater  
{
    private $id;
    private $number;
    private $cinema;
    private $active;
    private $ticketValue;
    private $capacity;

    public function __construct($number = "", $cinema = "", $active = "", $ticketValue = "", $capacity = "")
    {
        $this->number = $number;
        $this->cinema = $cinema;
        $this->active = $active;
        $this->ticketValue = $ticketValue;
        $this->capacity = $capacity;
    }

    public function getId(){return $this->id;}
    public function getNumber(){return $this->number;}
    public function getCinema(){return $this->cinema;}
    public function getActive(){return $this->active;}
    public function getTicketValue(){return $this->ticketValue;}
    public function getCapacity(){return $this->capacity;}

    public function setId($movieId){$this->movieId=$movieId;}
    public function setNumber($number){$this->number=$number;}
    public function setCinema($cinema){$this->cinema=$cinema;}
    public function setActive($active){$this->active=$active;}
    public function setTicketValue($ticketValue){$this->ticketValue=$ticketValue;}
    public function setCapacity($capacity){$this->capacity=$capacity;}


}























?>