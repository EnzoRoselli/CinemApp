<?php
namespace Controllers;

use Model\Showtime as Showtime;
use DAO\ShowtimesDAO as ShowtimeDAO;

class ShowtimeController{

    private $showtimeDao;

    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
    }

    public function determinateUpdateCreate()
    {
        if ($_POST) {
            if ($_POST[SHOWTIME_ID] != "") {
         
                $this->updateShowtime();

            } else if ($_POST[SHOWTIME_ID] == "") {
           
                $this->createShowtime();
            }
          
        }
    }

    public function createShowtime()
    {

        $cinema = $_POST[SHOWTIME_CINEMA];
        $movie = $_POST[SHOWTIME_MOVIE];
        $date = $_POST[SHOWTIME_DATE];
        $hour = $_POST[SHOWTIME_HOUR];
        $language = $_POST[SHOWTIME_LANGUAGE];
        $subtitles = $_POST[SHOWTIME_SUBTITLE];

        $showtime = new Showtime($cinema, $movie, $date, $hour, $language, $subtitles);
        $showtime->setActive(true);

        if (!empty($showtime->getCinema()) && !empty($showtime->getMovie()) && !empty($showtime->getDate()) && !empty($showtime->getHour()) && !empty($showtime->getLanguage()) && !empty($showtime->getSubtitles())) {
            
            if ($this->CineDao->add($cine)) {
              
                $advice =  CineController::showMessage(0);
                $this->showCinemaMenu();
            } else {
                $advice =  CineController::showMessage(1);
               $this->showCinemaMenu();
            }
        } else {
            $advice = CineController::showMessage(4);
            $this->showCinemaMenu(); //SIEMPRE TESTEAR SI LA VARIABLE NO ESTA VACIA EN LA VIEW, Y SINO HACERLE EL ALERT CON DE TEXTO EL &advice
        }
    }

    public function showShowtimeMenu(){
        require_once(VIEWS . "/AdminShowtimes.php");
    }


}
?>