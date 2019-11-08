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
        $this->APIController = new APIController();
        $this->APIController->sendToDataBase();
    }

  

    public function updateShowtimes()
    {
        $showtimes = $this->showtimeDao->getAll();
        foreach ($showtimes as $item) {
       
            $date = $this->formatDate($item);
            $actualDate=date_create(date("Y-m-d"));
            $actualTime = explode(":", date("h:i"));
            
            date_time_set($actualDate, $actualTime[0], $actualTime[1]);

                if ($date < $actualDate) {
          
                    $this->showtimeDao->desactivate($item->getShowtimeId());
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
            var_dump($th);
            // // $advice = ShowtimeController::showMessage("DB");
        } finally {
            require_once(VIEWS . "/AdminShowtimes.php");
        }
    }

    public function create($idCinema, $idMovie, $nameLanguage)
    {
        $cinema = $this->cinemasDAO->searchById($idCinema);
        $movie = $this->moviesDAO->searchById($idMovie);
        $language = $this->languagesDAO->searchByName($nameLanguage);
        $subtitled = null;
        $message = 0;

        if (isset($_POST['subtitle'])) {
            $subtitled = 1;
        } else {
            $subtitled = 0;
        }

        $showtime = new Showtime($movie, $cinema,$_POST['date'], $_POST['hour'], $language, $subtitled);
        $showtime->setActive(true);
        $showtime->setTicketAvaliable($cinema->getCapacity());  

        try {
            if ($this->validateShowtimeDate($showtime) && !$this->isMovieInOtherCinema($showtime)) {
                $this->showtimeDao->add($showtime);
            } else {
                $message = 1;
            }
        } catch (\Throwable $th) {
            var_dump($th);
        } finally {
            if ($message == 0) {
                echo '<script type="text/javascript">
                    alert("Función creada con éxito");
                </script>';
            } else {
                echo '<script type="text/javascript">
                    alert("El cine ingresado o el horario son erróneos");
                </script>';
            }
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
    public function formatDate($showtime)
    {
    
        $date = date_create($showtime->getDate());
        $time = explode(":", $showtime->getHour());
        date_time_set($date, $time[0], $time[1]);
        return $date;
    }

    public function validateShowtimeDate(Showtime $newShowtime)
    {
        $newShowtimeDate = $this->formatDate($newShowtime);
        $showtimes = $this->showtimeDao->getAll();

        foreach ($showtimes as $showtime) {

            $fechaMin = $this->formatDate($showtime);
            $fechaMin->modify('-15 minutes');

            $fechaMax = $this->formatDate($showtime);
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
                // $advice = ShowtimeController::showMessage(5);
            }
        } catch (\Throwable $th) {
            // $advice = ShowtimeController::showMessage("DB");
        }
    }
    public function update()
    {
        try {
            if (!empty($this->showtimeDao->searchById($_GET['id']))) {
                $this->showtimeDao->modify($_GET['id']);
                // $advice = ShowtimeController::showMessage(2);
            } else {
                // $advice = ShowtimeController::showMessage(3);
            }
        } catch (\Throwable $th) {
            // $advice = ShowtimeController::showMessage("DB");
        }
    }

    public function activate()
    {
        $id = $_GET['activate'];
        try {
            $this->showtimeDao->activate($id);
        } catch (\Throwable $th) {
            // $advice = ShowtimeController::showMessage("DB");
        }
        $this->showShowtimeMenu();
    }

    public function desactivate($id)
    {
        $id = $_GET['desactivate'];
        try {
            $this->showtimeDao->desactivate($id);
        } catch (\Throwable $th) {
            // $advice = ShowtimeController::showMessage("DB");
        }
        $this->showShowtimeMenu();
    }
}
