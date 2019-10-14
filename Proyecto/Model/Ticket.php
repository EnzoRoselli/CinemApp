<?php
namespace Model;



class Ticket{

    private $ticketNumber;
    private $qr_code;
    private $id;
    private static $counter = 0;

    public function __construct($ticketNumber,$qr_code){
        $this->ticketNumber=$ticketNumber;
        $this->qr_code=$qr_code;
        $this->id=Ticket::$counter++;
    }

    public function getId(){ return $this->id;}
    public function getTicketNumber(){return $this->ticketNumber;}
    public function getQr_Code(){return $this->qr_code;}

    public function setTicketNumber($ticketNumber){$this->ticketNumber=$ticketNumber;}
    public function setQr_Code($qr_code){$this->qr_code=$qr_code;}
}



?>