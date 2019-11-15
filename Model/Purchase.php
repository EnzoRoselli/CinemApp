<?php
namespace Model;



class Purchase{
    private $id;
    private $date;
    private $hour;
    private $ticketAmount;
    private $total; 
    private $user;
    private $creditCard;

    public function __construct($date="", $hour="",$ticketAmount="",$total="", $grossValue="", $user="", $creditCard=""){
        $this->date=$date;
        $this->hour=$hour;
        $this->ticketAmount=$ticketAmount;
        $this->total=$total;
        $this->$user=$user;
        $this->$creditCard=$creditCard; 
    }

    public function getId(){return $this->id;}
    public function getDate(){return $this->date;}
    public function getHour(){return $this->hour;}
    public function getTicketAmount(){return $this->ticketAmount;}
    public function getTotal(){return $this->total;}
    public function getUser(){return $this->user;}
    public function getcreditCard(){return $this->creditCard;}

    public function setId($id){$this->id=$id;}
    public function setDate($date){$this->date=$date;}
    public function setHour($hour){$this->hour=$hour;}
    public function setTicketAmount($ticketAmount){$this->ticketAmount=$ticketAmount;}
    public function setTotal($total){$this->total=$total;}
    public function setUser($user){$this->user=$user;}
    public function setcreditCard($creditCard){$this->creditCard=$creditCard;}
}


?>