<?php

namespace Model;

class MoviePurchases
{
    private $title;
    private $totalTickets;
    private $totalSales;

    public function __construct($title = "", $totalTickets = "", $totalSales = "")
    {
        $this->title = $title;
        $this->totalTickets = $totalTickets;
        $this->totalSales = $totalSales;
        
    }

    public function getTitle(){return $this->title;}
    public function getTotalTickets(){return $this->totalTickets;}
    public function getTotalSales(){return $this->totalSales;}

    public function setTitle($title){$this->title = $title;}
    public function setTotalTickets($totalTickets){$this->totalTickets = $totalTickets;}
    public function setTotalSales($totalSales){$this->totalSales = $totalSales;}


}

?>