<?php
namespace Model;



class Purchase{

    private $date;
    private $hour;
    private $ticketAmount;
    private $total;
    private $descount;
    private $id;
 

    public function __construct($date="", $hour="",$ticketAmount="",$total="",$descount=""){
        $this->date=$date;
        $this->hour=$hour;
        $this->ticketAmount=$ticketAmount;
        $this->total=$total;
        $this->descount=$descount;
        
    }

    public function getId(){return $this->id;}
    public function getDate(){return $this->date;}
    public function getHour(){return $this->hour;}
    public function getTicketAmount(){return $this->ticketAmount;}
    public function getTotal(){return $this->total;}
    public function getDescount(){return $this->descount;}

    public function setDate($date){$this->date=$date;}
    public function setHour($hour){$this->hour=$hour;}
    public function setTicketAmount($ticketAmount){$this->ticketAmount=$ticketAmount;}
    public function setTotal($total){$this->total=$total;}
    public function setDescount($descount){$this->descount=$descount;}
}


?>