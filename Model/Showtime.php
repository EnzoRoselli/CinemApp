<?php
namespace Model;


class Showtime{

    private $showtimeId;
    private $movie;
    private $theater;
    private $date;
    private $hour;
    private $ticketAvaliable;
    private $language;
    private $subtitle;
    private $active;

    public function __construct($movie= "",$theater="",$date= "",$hour= "",$language= "",$subtitle= "")
    {
        $this->movie = $movie;
        $this->theater = $theater;
        $this->date = $date;
        $this->hour = $hour;
        $this->language=$language;
        $this->subtitle=$subtitle;

    }

    public function getShowtimeId(){return $this->showtimeId;}
    public function getTheater(){return $this->theater;}
    public function getMovie(){return $this->movie;}
    public function getDate(){return $this->date;}
    public function getHour(){return $this->hour;}
    public function getLanguage(){return $this->language;}
    public function getActive(){return $this->active;}
    public function isSubtitle(){return $this->subtitle;}   
    public function getTicketAvaliable(){return (int)$this->ticketAvaliable;}

    public function setShowtimeId($showtimeId){$this->showtimeId=$showtimeId;}
    public function setTheater($theater){$this->theater=$theater;}
    public function setMovie($movie){$this->movie=$movie;}
    public function setDate($date){$this->date=$date;}
    public function setHour($hour){$this->hour=$hour;}
    public function setLanguage($language){$this->language=$language;}
    public function setSubtitle($subtitle){$this->subtitle=$subtitle;} 
    public function setActive($active){$this->active = $active;}
    public function setTicketAvaliable($ticketAvaliable){$this->ticketAvaliable=(int)$ticketAvaliable;     
    }

}


?>