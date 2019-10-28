<?php
namespace Model;


class Showtime{

    private $showtimeId;
    private $movie;
    private $cinema;
    private $date;
    private $hour;
    private $ticketAvaliable;
    private $language;
    private $subtitle;
    private $active;

    public function __construct($movie= "",$cinema="",$date= "",$hour= "",$language= "",$subtitle= "")
    {
        $this->movie = $movie;
        $this->cinema = $cinema;
        $this->date = $date;
        $this->hour = $hour;
        $this->language=$language;
        $this->subtitle=$subtitle;
      //  $this->ticketAvaliable=$this->cinema->getCapacity();
    }

    public function getShowtimeId(){return $this->showtimeId;}
    public function getCinema(){return $this->cinema;}
    public function getMovie(){return $this->movie;}
    public function getDate(){return $this->date;}
    public function getHour(){return $this->hour;}
    public function getLanguage(){return $this->language;}
    public function getActive(){return $this->active;}
    public function isSubtitle(){return $this->subtitle;}   
    public function getTicketAvaliable(){return (int)$this->ticketAvaliable;}

    public function setShowtimeId($showtimeId){$this->showtimeId=$showtimeId;}
    public function setCinema($cinema){$this->cinema=$cinema;}
    public function setMovie($movie){$this->movie=$movie;}
    public function setDate($date){$this->date=$date;}
    public function setHour($hour){$this->hour=$hour;}
    public function setLanguage($language){$this->language=$language;}
    public function setSubtitle($subtitle){$this->subtitle=$subtitle;} 
    public function setActive($active){$this->active = $active;}
    public function setTicketAvaliable($ticketAvaliable){
        if (!empty($ticketAvaliable)) {
            $this->ticketAvaliable=(int)$ticketAvaliable;
        }       
    }

    
    public function testValuesValidation()
    {
        // if (!empty($this->movie) && !empty($this->cinema) && !empty($this->date) && !empty($this->hour) && $this->ticketAvaliable>-1 && !empty($this->language) && !empty($this->subtitle){
        //     return true;
        // }
        // else{
        //     return false;
        // }
        return true;
    }
}


?>