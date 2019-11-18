<?php

namespace Controllers;

use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\GenresDAO as GenresDAO;
use DAO\GenresXMoviesDAO as GenresXMoviesDAO;

class FiltersController
{
    private $showtimeDao;
    private $MoviesDAO;
    private $genreDAO;
    private $genresXmoviesDAO;
    private $showtimeController;

    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
        $this->genreDAO = new GenresDAO();
        $this->MoviesDAO = new MoviesDAO();
        $this->genresXmoviesDAO = new GenresXMoviesDAO();
        $this->showtimeController = new ShowtimeController();
    }

    public function FilterMovies()
    {
        $message = 0;
        $advices = array();

        try{

            if (isset($_GET['genre']) && empty($_GET['date'])) {
                
                $moviesByGenre = $this->searchByGenre($_GET['genre']);

                if(!empty($moviesByGenre)){
                    
                    $this->showtimeController->showShowtimesListUser($moviesByGenre);
                    
                }else{
                    
                    $message = 1;
                }
                
            } else if (isset($_GET['date']) && empty($_GET['genre'])) { 

                $moviesByDate = $this->searchByDate($_GET['date']);

                if(!empty($moviesByDate)){

                    $this->showtimeController->showShowtimesListUser($moviesByDate);
                }else{
                    $message = 1;
                }
            
            }else if (isset($_GET['genre']) && !empty($_GET['date'])) {

                $moviesByGenres = $this->searchByGenre($_GET['genre']);

                $showtimesByDateAndGenres = $this->filterMoviesByDate($moviesByGenres, $_GET['date']);

                if(!empty($showtimesByDateAndGenres)){
                      $this->showtimeController->showShowtimesListUser($showtimesByDateAndGenres);
                }else{
                    $message = 1;
                }
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }finally{
            if($message == 1){

                array_push($advices, NOT_FOUND);
    
                $this->showtimeController->showShowtimesListUser(null,$advices);
            }
        }
    }

    public function searchByGenre($genreId)
    {
        try {
            $moviesByGenre = $this->genresXmoviesDAO->getMoviesByGenreId($genreId);
 
        } catch (\Throwable $th) {
            var_dump($th);
        }

        return $moviesByGenre;
    }

    public function searchByDate($dateToSearch)
    {   

        try {

            $showtimes = $this->showtimeDao->getAll();
            $moviesByDate = array();
            
            foreach ($showtimes as $showtime) {

                if ($showtime->getDate() == $dateToSearch && $showtime->getActive() == true) {

                    $reapeted = false;

                    foreach ($moviesByDate as $value) {

                        if($showtime->getMovie()->getTitle() == $value->getTitle()){

                            $reapeted = true;
                        }
                    }

                    if($reapeted == false){

                        array_push($moviesByDate, $showtime->getMovie());
                    }
                }

            }


        } catch (\Throwable $th) {
            var_dump($th);
        }
            
        return $moviesByDate;
    }

    public function filterMoviesByDate($movies, $dateToSearch){

        try {

            $moviesToShowtimesList = array();
            $moviesByDate = array();

            foreach ($movies as $movie) {
                
                $movieToShowtime = $this->showtimeDao->getMovieShowtimes($movie);

                array_push($moviesToShowtimesList, $movieToShowtime);
            }

            foreach ($moviesToShowtimesList as $showtime) {
                 
                foreach ($showtime as $value) {
                    
                    if ($value->getDate() == $dateToSearch && $value->getActive() == true) {

                        $reapeted = false;

                        foreach ($moviesByDate as $movie) {
                            
                            if($value->getMovie()->getTitle() == $movie->getTitle()){

                                $reapeted = true;
                            }
                        }

                        if($reapeted == false){

                            array_push($moviesByDate, $value->getMovie());
                        }
                    }
                }
            }

        } catch (\Throwable $th) {
            var_dump($th);
        }
            
        return $moviesByDate;
    }

    

}
