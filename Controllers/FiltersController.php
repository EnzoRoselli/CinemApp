<?php

namespace Controllers;

use Controllers\HomeController as HomeController;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\GenresDAO as GenresDAO;
use DAO\GenresXMoviesDAO as GenresXMoviesDAO;
use Model\Movie;

class FiltersController
{
    private $homeController;
    private $showtimeDao;
    private $MoviesDAO;
    private $genreDAO;
    private $genresXmoviesDAO;

    public function __construct()
    {
        $this->homeController = new HomeController();
        $this->showtimeDao = new ShowtimeDAO();
        $this->genreDAO = new GenresDAO();
        $this->MoviesDAO = new MoviesDAO();
        $this->genresXmoviesDAO = new GenresXMoviesDAO();
    }

    
    public function showFilters()
    {

        $genres = $this->genreDAO->getAll();
        require_once(VIEWS  . '/Filter.php');
    }

    public function FilterMovies()
    {
        $message = 0;

        try{

            if (isset($_GET['genres']) && !empty($_GET['date'])) {

                $moviesByGenres = $this->searchByGenres($_GET['genres']);
                $showtimesByDateAndGenres = $this->moviesByGenresToShowtimes($moviesByGenres, $_GET['date']);
                $showtimesFixed = $this->arrangeAsShowtimesAreShown($showtimesByDateAndGenres);

                if(!empty($showtimesFixed)){

                    $this->showFilteredMovies(null, null, $showtimesFixed);
                }else{
                    $message = 1;
                }

            } else if (isset($_GET['genres']) && empty($_GET['date'])) {
    
                    $moviesByGenres = $this->searchByGenres($_GET['genres']);
                    
                    if(!empty($moviesByGenres)){

                        $this->showFilteredMovies(null, $moviesByGenres, null);
                    }else{
                        $message = 1;
                    }
                    
                
            } else if (isset($_GET['date']) && !isset($_GET['genres'])) { 
    

                    $showtimesByDate = $this->searchByDate($_GET['date']);
                    $showtimesFixed = $this->arrangeAsShowtimesAreShown($showtimesByDate);

                    if(!empty($showtimesFixed)){

                        $this->showFilteredMovies(null, null, $showtimesFixed);
                    }else{
                        $message = 1;
                    }
                
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }finally{
            if($message == 1){

                echo '<script type="text/javascript">
                        alert("Ninguna pelicula encaja con los filtros ingresados");
                    </script>';
    
                $this->showFilters();
            }
        }
    }

    public function searchMovieByName()
    {
        $advices = array(); //Futuramente se guardaran los msj de errores
        $message = 0;
        $title = $_GET['title'];
        $movie = new Movie();
        $movie->setTitle($title);
        try {
            $comprobationMovie = $this->MoviesDAO->exists($movie);
            if ($comprobationMovie) {
                array_push($advices, ADDED);
            } else {
                array_push($advices, NOT_FOUND);
                $message = 1;
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } finally {

            if($message == 1){
                
                echo '<script type="text/javascript">
                        alert("Ninguna pelicula encaja con el nombre ingresado");
                    </script>';
    
                $this->homeController->Index();
            }else{
                
                $this->showFilteredMovies($comprobationMovie, null, null);
            }
        }
    }

    public function searchByGenres($genresIds)
    {
        try {
            $moviesByGenres = $this->genresXmoviesDAO->getMoviesByGenresIds($genresIds);
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }

        return $moviesByGenres;
    }

    public function searchByDate($dateToSearch)
    {   
        try {

            $showtimes = $this->showtimeDao->getAll();
            $showtimesByDate = array();

            foreach ($showtimes as $showtime) {

                if ($showtime->getDate() == $dateToSearch && $showtime->getActive() == true) {
                    array_push($showtimesByDate, $showtime);
                }
            }

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
            
        return $showtimesByDate;
    }

    public function moviesByGenresToShowtimes($moviesByGenres, $dateToSearch){

        try {

            $Allshowtimes = $this->showtimeDao->getAll();
            $showtimesByGenres = array();
            $showtimesByDateAndGenres = array();

            foreach ($Allshowtimes as $showtime) {

                foreach ($moviesByGenres as  $movie) {
                    
                    if ($showtime->getMovie()->getTitle() == $movie->getTitle() && $showtime->getActive() == true) {
                        array_push($showtimesByGenres, $showtime);
                    }
                }
            }
            
            foreach ($showtimesByGenres as $value) {
                
                if ($value->getDate() == $dateToSearch) {
                    array_push($showtimesByDateAndGenres, $value);
                }
            }

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }

        return $showtimesByDateAndGenres;
    }

    public function arrangeAsShowtimesAreShown($showtimes){

        $showtimesFixed = array();
        
        for ($i=0; $i < count($showtimes); $i++) {
            
            $hours = array();
            $check = false;

            for ($j=0; $j < count($showtimes); $j++) { 
                
                if($showtimes[$i]->getMovie()->getTitle() == $showtimes[$j]->getMovie()->getTitle()){
                    
                    array_push($hours, $showtimes[$j]->getHour());
                }
            }

            foreach ($showtimesFixed as $value) {
                
                if($value->getMovie()->getTitle() == $showtimes[$i]->getMovie()->getTitle()){
                    
                    $check = true;
                }

            }

            if(!$check){

                $showtimes[$i]->setHour($hours);
                array_push($showtimesFixed, $showtimes[$i]); 
            }
        }

        return $showtimesFixed;
    }

    public function showFilteredMovies($movieByName = "", $moviesByGenres = "", $showtimesByDate = ""){
        
        require_once(VIEWS . '/ShowFilteredMovies.php');
    }

}
