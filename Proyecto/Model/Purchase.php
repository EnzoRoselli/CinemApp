<?php
namespace Model;

require_once("../Config/Autoload.php");

class Purchase{

    private $date;
    private $ticketAmount;
    private $total;
    private $descount;
    private $id;
    private static $counter = 0;

    public function __construct($date,$ticketAmount,$total,$descount){
        $this->date=$date;
        $this->ticketAmount=$ticketAmount;
        $this->total=$total;
        $this->descount=$descount;
        $this->id=Purchase::$counter++;
    }

    public function getId(){return $this->id;}
    public function getDate(){return $this->date;}
    public function getTicketAmount(){return $this->ticketAmount;}
    public function getTotal(){return $this->total;}
    public function getDescount(){return $this->descount;}

    public function setDate($date){$this->date=$date;}
    public function setTicketAmount($ticketAmount){$this->ticketAmount=$ticketAmount;}
    public function setTotal($total){$this->total=$total;}
    public function setDescount($descount){$this->descount=$descount;}
}


?>