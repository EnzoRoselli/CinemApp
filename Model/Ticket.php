<?php
namespace Model;



class Ticket{

    private $ticketId;
    private $qr_code;
    private $ticketNumber;


    public function __construct($ticketId,$qr_code,$ticketNumber){
        $this->ticketId=$ticketId;
        $this->qr_code=$qr_code;
        $this->ticketNumber=$ticketNumber;
    }

    public function getId(){ return $this->id;}
    public function getQr_Code(){return $this->qr_code;}
    public function getTicketNumber(){return $this->ticketNumber;}

    public function setId($id){$this->id = $id;}
    public function setQr_Code($qr_code){$this->qr_code=$qr_code;}
    public function setTicketNumber($ticketNumber){$this->ticketNumber=$ticketNumber;}
}



?>