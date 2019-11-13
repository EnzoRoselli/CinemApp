<?php
namespace Model;



class Purchase{

    private $date;
    private $hour;
    private $ticketAmount;
    private $total;
    private $grossValue; //valor bruto
    private $discount;
    private $id;
    private $user;

    public function __construct($date="", $hour="",$ticketAmount="",$total="",$discount="", $grossValue="", $user=""){
        $this->date=$date;
        $this->hour=$hour;
        $this->ticketAmount=$ticketAmount;
        $this->total=$total;
        $this->$discount=$discount;
        $this->$grossValue=$grossValue;
        $this->$user=$user;
        
    }

    public function getId(){return $this->id;}
    public function getDate(){return $this->date;}
    public function getHour(){return $this->hour;}
    public function getTicketAmount(){return $this->ticketAmount;}
    public function getTotal(){return $this->total;}
    public function getDiscount(){return $this->discount;}
    public function getGrossValue(){return $this->grossValue;}
    public function getUser(){return $this->user;}

    public function setDate($date){$this->date=$date;}
    public function setHour($hour){$this->hour=$hour;}
    public function setTicketAmount($ticketAmount){$this->ticketAmount=$ticketAmount;}
    public function setTotal($total){$this->total=$total;}
    public function setDiscount($discount){$this->discount=$discount;}
    public function setGrossValue($grossValue){$this->grossValue=$grossValue;}
    public function setUser($user){$this->user=$user;}
}


?>