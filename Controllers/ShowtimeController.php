<?php

namespace Controllers;

use Model\Showtime as Showtime;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\CinemasDAO as CinemasDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\LanguagesDAO as LanguagesDAO;
use Controllers\APIController as APIController;
use DateInterval;

//VALIDAR QUE LOS DATOS DE LA FUNCIONN YA NO ESTEN CARGADOS, OSEA A LA MISMA HORA, MISMO CINE
//PONER TODOS LOS AVISOS CON CONSTANTES, Y LLAMARLAS EN ESTA CLASE
class ShowtimeController
{

    private $showtimeDao;
    private $cinemasDAO;
    private $moviesDAO;
    private $languagesDAO;
    private $APIController;


    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
        $this->cinemasDAO = new CinemasDAO();
        $this->moviesDAO = new MoviesDAO();
        $this->languagesDAO = new LanguagesDAO();
        $this->APIController= new APIController();
        $this->APIController->sendToDataBase();
    }

    public function determinateUpdateCreate()
    {
        if ($_POST) {
            if ($_POST[SHOWTIME_ID] != "") {

                $this->update();
            } else if ($_POST[SHOWTIME_ID] == "") {

                $this->create();
            }
        }
    }
    public function showShowtimeMenu()
    {
        try {
            $cinemasList = $this->cinemasDAO->getAll();
           $moviesList = $this->moviesDAO->getAll();
            $languagesList = $this->languagesDAO->getAll();
            $showtimes = $this->showtimeDao->getAll();
        } catch (\Throwable $th) {
            $advice = ShowtimeController::showMessage("DB");
        } finally {
            require_once(VIEWS . "/AdminShowtimes.php");
        }
    }

    public function create()
    {

        $cinema = $this->cinemasDAO->searchById($_POST['idCinema']);
        $movie = $this->moviesDAO->searchById($_POST['idMovie']);
        $language = $this->languagesDAO->searchByName($_POST['nameLanguage']);
        $subtitled = null;

        if (isset($_POST['subtitle']) && $_POST['subtitle'] != "") {
            $subtitled = 1;
        } else {
            $subtitled = 0;
        }

        $showtime = new Showtime($movie, $cinema, $_POST['date'], $_POST['hour'], $language, $subtitled);
        $showtime->setActive(true);
        $showtime->setTicketAvaliable($cinema->getCapacity());

        try {
            if ($this->validateShowtimeDate($showtime) && !$this->isMovieInOtherCinema($showtime)) {
                $this->showtimeDao->add($showtime);

            }else {
                
            }
        } catch (\Throwable $th) {

            var_dump($th);
        } finally {

            $this->showShowtimeMenu();
        }
    }

 


    public function isMovieInOtherCinema(Showtime $showtime)
    {
        $comprobationIdCinema = $this->showtimeDao->getShowtimesMovieOfAday($showtime);
        if (!empty($comprobationIdCinema)) {
            if ($showtime->getCinema()->getId() == $comprobationIdCinema) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function validateShowtimeDate(Showtime $newShowtime)
    {

        $newShowtimeDate = date_create($newShowtime->getDate());
        $time = explode(":", $newShowtime->getHour());
        date_time_set($newShowtimeDate, $time[0], $time[1]);
        $showtimes = $this->showtimeDao->getAll();

        foreach ($showtimes as $showtime) {

            $fechaMin = date_create($showtime->getDate());
            $tiempo = explode(":", $showtime->getHour());
            date_time_set($fechaMin, $tiempo[0], $tiempo[1]);
            $fechaMin->modify('-15 minutes');

            $fechaMax = date_create($showtime->getDate());
            date_time_set($fechaMax, $tiempo[0], $tiempo[1]);
            $fechaMax->add(new DateInterval('PT' . $showtime->getMovie()->getDuration() . 'M'));

            if ($newShowtimeDate > $fechaMin && $newShowtimeDate < $fechaMax && $newShowtime->getCinema()->getName() == $showtime->getCinema()->getName()) {
                return false;
            }
        }
        return true;
    }

    public function delete()
    {
        try {
            if (!empty($this->showtimeDao->searchById($_GET['id']))) {
                $this->showtimeDao->delete($_GET['id']);
                $advice = ShowtimeController::showMessage(5);
            }
        } catch (\Throwable $th) {
            $advice = ShowtimeController::showMessage("DB");
        }
    }
    public function update()
    {
        try {
            if (!empty($this->showtimeDao->searchById($_GET['id']))) {
                $this->showtimeDao->modify($_GET['id']);
                $advice = ShowtimeController::showMessage(2);
            } else {
                $advice = ShowtimeController::showMessage(3);
            }
        } catch (\Throwable $th) {
            $advice = ShowtimeController::showMessage("DB");
        }
    }

    public function activate($id)
    {
        try {
            if (!empty($this->showtimeDao->searchById($id))) {
                $this->showtimeDao->activate($id);
                $advice = ShowtimeController::showMessage("activado");
            } else {
                $advice = ShowtimeController::showMessage(3);
            }
        } catch (\Throwable $th) {
            $advice = ShowtimeController::showMessage("DB");
        }
    }

    public function desactivate($id)
    {
        try {
            if (!empty($this->showtimeDao->searchById($id))) {
                $this->showtimeDao->desactivate($id);
                $advice = ShowtimeController::showMessage("desactivado");
            } else {
                $advice = ShowtimeController::showMessage(3);
            }
        } catch (\Throwable $th) {
            $advice = ShowtimeController::showMessage("DB");
        }
    }
}
