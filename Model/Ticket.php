<?php
namespace Model;



class Ticket{

    private $id;
    private $qr_code;
    private $showtime;
    private $purchase;


    public function __construct($qr_code="",$purchase="",$showtime=""){
        $this->qr_code=$qr_code;
        $this->purchase=$purchase;
        $this->showtime=$showtime;
    }

    public function getId(){ return $this->id;}
    public function getQr_Code(){return $this->qr_code;}
    public function getShowtime(){return $this->showtime;}
    public function getPurchase(){return $this->purchase;}

    public function setId($id){$this->id = $id;}
    public function setQr_Code($qr_code){$this->qr_code=$qr_code;}
    public function setShowtime($showtime){$this->showtime=$showtime;}
    public function setPurchase($purchase){$this->purchase=$purchase;}
}



?>