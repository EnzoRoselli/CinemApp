<?php
namespace Model;


class Showtime{

    private $showtimeId;
    private $movieId;
    private $cinemaId;
    private $day;
    private $hour;
    private $ticketStock;
    private $active;

    public function __construct($showtimeId,$movieId,$cinemaId,$day,$hour,$ticketStock)
    {
        $this->showtimeId=$showtimeId;
        $this->movieId = $movieId;
        $this->cinemaId = $cinemaId;
        $this->day = $day;
        $this->hour = $hour;
        $this->ticketStock = $ticketStock;
        $this->active = true;
    }

    public function getShowtimeId(){return $this->showtimeId;}
    public function getCinemaId(){return $this->cinemaId;}
    public function getMovieId(){return $this->movieId;}
    public function getDay(){return $this->day;}
    public function getHour(){return $this->hour;}
    public function getTicketStock(){return $this->ticketStock;}
    public function getActive(){return $this->active;}

    public function setShowtimeId($showtimeId){$this->showtimeId=$showtimeId;}
    public function setCinemaId($cinemaId){$this->cinemaId=$cinemaId;}
    public function setMovieId($movieId){$this->movieId=$movieId;}
    public function setDay($day){$this->day=$day;}
    public function setHour($hour){$this->hour=$hour;}
    public function setTicketStock($ticketStock){
        if($ticketStock > 0){
            $this->ticketStock=$ticketStock;
        }
    }
    public function setActive($active){$this->active;}
}


?>