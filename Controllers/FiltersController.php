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

    public function FilterMovies($genre = "", $date = "")
    {
        $message = 0;
        $advices = array();

        try{

            if (!empty($genre) && empty($date)) {
                
                $moviesByGenre = $this->searchByGenre($genre);

                if(!empty($moviesByGenre)){
                    
                    $this->showtimeController->showShowtimesListUser($moviesByGenre);
                    
                }else{
                    
                    $message = 1;
                }
                
            } else if (!empty($date) && empty($genre)) { 

                $moviesByDate = $this->searchByDate($date);

                if(!empty($moviesByDate)){

                    $this->showtimeController->showShowtimesListUser($moviesByDate);
                }else{
                    $message = 1;
                }
            
            }else if (empty($genre) && !empty($date)) {

                $moviesByGenres = $this->searchByGenre($genre);

                $showtimesByDateAndGenres = $this->filterMoviesByDate($moviesByGenres, $date);

                if(!empty($showtimesByDateAndGenres)){
                      $this->showtimeController->showShowtimesListUser($showtimesByDateAndGenres);
                }else{
                    $message = 1;
                }
            }else{
                $this->showtimeController->showShowtimesListUser(null,$advices);
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
        $advices = array();
        $moviesByGenre = array();

        try {
            $moviesByGenre = $this->genresXmoviesDAO->getMoviesByGenreId($genreId);
 
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }

        return $moviesByGenre;
    }

    public function searchByDate($dateToSearch)
    {   
        $advices = array();

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
            array_push($advices, DB_ERROR);
        }
            
        return $moviesByDate;
    }

    public function filterMoviesByDate($movies, $dateToSearch){

        $advices = array();

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
            array_push($advices, DB_ERROR);
        }
            
        return $moviesByDate;
    }

    

}
