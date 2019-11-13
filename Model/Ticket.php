<?php
namespace Model;



class Ticket{

    private $ticketId;
    private $qr_code;
    private $ticketNumber;
    private $showtime;
    private $purchase;


    public function __construct($ticketId="",$qr_code="",$ticketNumber="",$purchase=""){
        $this->ticketId=$ticketId;
        $this->qr_code=$qr_code;
        $this->ticketNumber=$ticketNumber;
        $this->purchase=$purchase;
    }

    public function getId(){ return $this->id;}
    public function getQr_Code(){return $this->qr_code;}
    public function getTicketNumber(){return $this->ticketNumber;}
    public function getShowtime(){return $this->showtime;}
    public function getPurchase(){return $this->purchase;}

    public function setId($id){$this->id = $id;}
    public function setQr_Code($qr_code){$this->qr_code=$qr_code;}
    public function setTicketNumber($ticketNumber){$this->ticketNumber=$ticketNumber;}
    public function setShowtime($showtime){$this->showtime=$showtime;}
    public function setPurchase($purchase){$this->purchase=$purchase;}
}



?>