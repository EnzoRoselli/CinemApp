<?php

namespace Controllers;

use Model\Showtime as Showtime;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\CinemasDAO as CinemasDAO;
use DAO\GenresDAO as GenresDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\LanguagesDAO as LanguagesDAO;
use DAO\CreditCardsDAO as CreditCardsDAO;
use Controllers\APIController as APIController;
use DAO\TheatersDAO as TheatersDAO;
use DateInterval;

class ShowtimeController
{

    private $showtimeDao;
    private $cinemasDAO;
    private $moviesDAO;
    private $genresDAO;
    private $languagesDAO;
    private $APIController;
    private $theatersDAO;
    private $creditCardsDAO;


    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
        $this->creditCardsDAO = new CreditCardsDAO();
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

    public function showShowtimeMenu($cinemaTheaters = array(), $messages = "", $openPopUp = false)
    {
        $advices = array();
        require_once(VIEWS . '/ValidateAdminSession.php');
        try {
            $cinemasList = $this->cinemasDAO->getAll();
            $theatersList = $this->theatersDAO->getAll();
            $moviesList = $this->moviesDAO->getAll();
            $languagesList = $this->languagesDAO->getAll();
            $showtimes = $this->showtimeDao->getAll();
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } finally {
            require_once(VIEWS . "/AdminShowtimes.php");
        }
    }

    public function create($idTheater, $idMovie, $nameLanguage, $subtitle, $date, $hour)
    {
        $advices = array();
        $theater = $this->theatersDAO->searchById($idTheater);
        $movie = $this->moviesDAO->searchById($idMovie);
        $language = $this->languagesDAO->searchByName($nameLanguage);
        $subtitled = null;

        if ($subtitle == 'Yes') {
            $subtitled = 1;
        } else {
            $subtitled = 0;
        }

        $showtime = new Showtime($movie, $theater, $date, $hour, $language, $subtitled);
        $showtime->setActive(true);
        $showtime->setTicketAvaliable($theater->getCapacity());

        try {
            if ($this->validateShowtimeDate($showtime) && !$this->isMovieInOtherCinema($showtime)) {
                $this->showtimeDao->add($showtime);
                array_push($advices, ADDED);
            } else {
                array_push($advices, INCORRECT_SHOWTIME);
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } finally {
            $this->showShowtimeMenu(null, $advices);
        }
    }

    public function isMovieInOtherCinema(Showtime $showtime)
    {
        $comprobation = $this->cinemasDAO->isAShowtimeMovieInACinemaToday($showtime);
        if ($comprobation != false && $comprobation != $showtime->getTheater()->getCinema()->getName()) {
            return true;
        }
        return false;
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
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $newShowtimeDate = $this->formatDate($newShowtime);
        $showtimes = $this->showtimeDao->getShowtimesOfAcinema($newShowtime->getTheater()->getCinema());       
    
        foreach ($showtimes as $showtime) {
            $fechaMin = $this->formatDate($showtime);
            $fechaMin->modify('-15 minutes');

            $fechaMax = $this->formatDate($showtime);
            $fechaMax->add(new DateInterval('PT' . $showtime->getMovie()->getDuration() . 'M'));
        

            if ($newShowtime<date('Y-m-d H:i') ||$newShowtimeDate >= $fechaMin && $newShowtimeDate <= $fechaMax && $showtime->getTheater()->getCinema()->getName() == $newShowtime->getTheater()->getCinema()->getName()) {
                return false;
            }
        }
        return true;
    }


    public function activate($showtimeId)
    {
        $advices = array();
        try {
            $this->showtimeDao->activate($showtimeId);
            array_push($advices, ACTIVATED);
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
        $this->showShowtimeMenu(null, $advices);
    }

    public function desactivate($showtimeId)
    {
        $advices = array();
        try {
            $this->showtimeDao->desactivate($showtimeId);
            array_push($advices, DEACTIVATED);
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
        $this->showShowtimeMenu(null, $advices);
    }

    public function showShowtimesListUser($filteredMovies = "", $messages = "")
    {
        $moviesList = $this->moviesDAO->getMoviesWithShowtimes();
        $showtimesList = $this->showtimeDao->getAll();
        $genresByMovie = array();
        $genresList = $this->genresDAO->getAll();


        if (!empty($filteredMovies)) {

            $moviesList = $filteredMovies;
        }
        foreach ($moviesList as $movie) {

            $genres = $this->genresDAO->getGenresByMovieId($movie->getId());

            array_push($genresByMovie, $genres[0]);
        }


        require_once(VIEWS . "/showtimeList.php");
    }


    public function showSelectShowtime($movieId)
    {

        $movie = $this->moviesDAO->searchById($movieId);
        $movieShowtimes = $this->showtimeDao->getMovieShowtimes($movie);
        require_once(VIEWS . "/SelectShowtime.php");
    }

    public function showBuy($showtimeId, $open = false)
    {
        if (empty($_SESSION['idUserLogged'])) {
            $_SESSION['showtimeBuying'] = $showtimeId;
            require_once(VIEWS . "/LoginSignup.php");
        } else {
            if (!empty($_SESSION['showtimeBuying'])) {
                unset($_SESSION['showtimeBuying']);
            }
            $CreditCardsList = $this->creditCardsDAO->getCCbyUser($_SESSION['idUserLogged']);
            $showtime = $this->showtimeDao->searchById($showtimeId);
            $openPopUp = $open;
            require_once(VIEWS . "/Buy.php");
        }
    }
    public function getCinema($idCinema)
    {
        $cinema = $this->cinemasDAO->searchById($idCinema);
        $cinemaTheaters = $cinema->getTheaters();
        $advices = array();
        
        if (!empty($cinemaTheaters)) {
            $this->showShowtimeMenu($cinemaTheaters, null, true);

            }else {
                array_push($advices, DB_ERROR);
            $this->showShowtimeMenu(null, null, true);              
        }
    }
    
}
