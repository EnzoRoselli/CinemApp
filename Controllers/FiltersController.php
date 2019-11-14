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
    private $showtimeController;

    public function __construct()
    {
        $this->homeController = new HomeController();
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
            if(!empty($_GET['title'])){
                
                $movieByTitleList = array();

                $movieByTitle = $this->searchMovieByTitle($_GET['title']);

                array_push($movieByTitleList, $movieByTitle);

                if(!empty($movieByTitleList)){

                    $this->showtimeController->showShowtimesListUser($movieByTitleList);
                }else{
                    $message = 1;
                }


            }else if (isset($_GET['genre']) && empty($_GET['date'])) {

                $moviesByGenre = $this->searchByGenre($_GET['genre']);
                $showtimesByMovies = $this->moviesByGenresToShowtimes($moviesByGenre);
                
                if(!empty($showtimesByMovies)){
                    
                    $this->showtimeController->showShowtimesListUser($showtimesByMovies);
                    
                }else{
                    
                    $message = 1;
                }
                    
                
            } else if (isset($_GET['date']) && !isset($_GET['genre'])) { 
    
                $showtimesByDate = $this->searchByDate($_GET['date']);

                if(!empty($showtimesByDate)){

                    $this->showtimeController->showShowtimesListUser($showtimesByDate);
                }else{
                    $message = 1;
                }
            
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }finally{
            if($message == 1){

                array_push($advices, NOT_FOUND);
    
                $this->showtimeController->showShowtimesListUser();
            }
        }
    }

    public function searchMovieByTitle($title)
    {
        $advices = array();

        $movie = new Movie();
        $movie->setTitle($title);

        try {
            $movieByTitle = $this->MoviesDAO->exists($movie);

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } 

        return $movieByTitle;
    }

    public function searchByGenre($genreId)
    {
        $advices = array();
        try {
            $moviesByGenre = $this->genresXmoviesDAO->getMoviesByGenreId($genreId);
        } catch (\Throwable $th) {
            var_dump($th);
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
                    array_push($moviesByDate, $showtime->getMovie());
                }
            }

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
            
        return $moviesByDate;
    }

    public function moviesByGenresToShowtimes($moviesByGenres){

        $advices = array();
        try {

            $Allshowtimes = $this->showtimeDao->getAll();
            $showtimesByGenres = array();

            foreach ($Allshowtimes as $showtime) {

                foreach ($moviesByGenres as  $movie) {
                    
                    if ($showtime->getMovie()->getTitle() == $movie->getTitle() && $showtime->getActive() == true) {
                        array_push($showtimesByGenres, $showtime->getMovie());
                    }
                }
            }

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }

        return $showtimesByGenres;
    }

}
