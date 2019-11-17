<?php

namespace Model;

class CinemaPurchases
{
    private $name;
    private $address;  
    private $totalTickets;
    private $totalSales;

    public function __construct($name = "", $address = "", $totalTickets = "", $totalSales = "")
    {
        $this->name = $name;
        $this->address = $address;
        $this->totalTickets = $totalTickets;
        $this->totalSales = $totalSales;
        
    }

    public function getName(){return $this->name;}
    public function getAddress(){return $this->address;}
    public function getTotalTickets(){return $this->totalTickets;}
    public function getTotalSales(){return $this->totalSales;}

    public function setName($name){$this->name = $name;}
    public function setAddress($address){$this->address = $address;}
    public function setTotalTickets($totalTickets){$this->totalTickets = $totalTickets;}
    public function setTotalSales($totalSales){$this->totalSales = $totalSales;}


}
