<?php

namespace Controllers;

use Model\Showtime as Showtime;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\CinemasDAO as CinemasDAO;
use DAO\GenresDAO as GenresDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\LanguagesDAO as LanguagesDAO;
use Controllers\APIController as APIController;
use DAO\TheatersDAO as TheatersDAO;
use DateInterval;

//VALIDAR QUE LOS DATOS DE LA FUNCIONN YA NO ESTEN CARGADOS, OSEA A LA MISMA HORA, MISMO CINE
//PONER TODOS LOS AVISOS CON CONSTANTES, Y LLAMARLAS EN ESTA CLASE
class ShowtimeController
{

    private $showtimeDao;
    private $cinemasDAO;
    private $moviesDAO;
    private $genresDAO;
    private $languagesDAO;
    private $APIController;
    private $theatersDAO;


    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
        $this->cinemasDAO = new CinemasDAO();
        $this->moviesDAO = new MoviesDAO();
        $this->genresDAO = new GenresDAO();
        $this->languagesDAO = new LanguagesDAO();
        $this->theatersDAO = new TheatersDAO();
        $this->APIController = new APIController();
        $this->APIController->sendToDataBase();
    }



    public function updateShowtimes()
    {
        $showtimes = $this->showtimeDao->getAll();
        foreach ($showtimes as $item) {

            $date = $this->formatDate($item);
            $actualDate = date_create(date("Y-m-d"));
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
            $theatersList = $this->theatersDAO->getAll();//EL TD DEL CINE LO TOMAS POR EL GETname del cine de la sala Y AGREGAR OTRO TD CON NOMBRE SALA
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

    public function create($idCinema/*, $idMovie, $nameLanguage*/)
    {
        $cinema = $this->cinemasDAO->searchById($idCinema);
        //ABRIS EL POP UP PARA SELECCIONAR UN CINE
        //FUNCION

        //////////////YA EL POP UP DE TODOS LOS DATOS
        $theater=$this->theatersDAO->searchById($idtheater);
        $movie = $this->moviesDAO->searchById($idMovie);
        $language = $this->languagesDAO->searchByName($nameLanguage);
        $subtitled = null;
        $message = 0;

        if (isset($_POST['subtitle'])) {
            $subtitled = 1;
        } else {
            $subtitled = 0;
        }

        $showtime = new Showtime($movie, $theater, $_POST['date'], $_POST['hour'], $language, $subtitled);
        $showtime->setActive(true);
        $showtime->setTicketAvaliable($theater->getCapacity());

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
        $comprobation = $this->cinemasDAO->isAmovieInACinemaToday($showtime);
        if (!$comprobation) {
            return false;
        }
        return true;
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
        $showtimes = $this->showtimeDao->getShowtimesOfAcinema($newShowtime->getTheater()->getCinema());

        foreach ($showtimes as $showtime) {

            $fechaMin = $this->formatDate($showtime);
            $fechaMin->modify('-15 minutes');

            $fechaMax = $this->formatDate($showtime);
            $fechaMax->add(new DateInterval('PT' . $showtime->getMovie()->getDuration() . 'M'));

            if ($newShowtimeDate > $fechaMin && $newShowtimeDate < $fechaMax) {
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

    public function showShowtimesListUser()
    {
        $moviesList = $this->moviesDAO->getAll();
        $genresByMovie = array();

        foreach ($moviesList as $movie) {

            $genres = $this->genresDAO->getGenresByMovieId($movie->getId());

            array_push($genresByMovie, $genres[0]);
        }

        require_once(VIEWS . "/showtimeList.php");
    }

    public function showOverview(){
        
        $movie = $this->moviesDAO->searchById($_GET['movie']);
        require_once(VIEWS . "/MovieOverview.php");
    }

    public function showBuy(){
        
        
        require_once(VIEWS . "/Buy.php");
    }

    public function openPopUp()
    {
        echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})</script>";
    }

    public function getCinema(){
        var_dump($_GET);
    }
}
