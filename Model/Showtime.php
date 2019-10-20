<?php
namespace Model;


class Showtime{

    private $cinemaId;
    private $date;
    private $hour;
    private $movieId;
    private $ticketStock;
    private $id;
    private $active;

    public function __construct($movieId,$cinemaId,$date,$hour,$ticketStock)
    {
        $this->movieId = $movieId;
        $this->cinemaId = $cinemaId;
        $this->date = $date;
        $this->hour = $hour;
        $this->ticketStock = $ticketStock;
        $this->id=0;
        $this->active = true;
    }

    public function getId(){return $this->id;}
    public function getCinemaId(){return $this->cinemaId;}
    public function getMovieId(){return $this->movieId;}
    public function getDate(){return $this->date;}
    public function getHour(){return $this->hour;}
    public function getTicketStock(){return $this->ticketStock;}
    public function getActive(){return $this->active;}

    public function setId($id){$this->id=$id;}
    public function setCinemaId($cinemaId){$this->cinemaId=$cinemaId;}
    public function setMovieId($movieId){$this->movieId=$movieId;}
    public function setDate($date){$this->date=$date;}
    public function setHour($hour){$this->hour=$hour;}
    public function setTicketStock($ticketStock){
        if($ticketStock > 0){
            $this->ticketStock=$ticketStock;
        }
    }
    public function setActive($active){$this->active;}
}


?>