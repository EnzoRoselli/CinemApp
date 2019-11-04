<?php

namespace Controllers;

use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\GenresDAO as GenresDAO;
use DAO\GenresXMoviesDAO as GenresXMoviesDAO;
use Model\Movie;

class FiltersController
{
    private $showtimeDao;
    private $MoviesDAO;
    private $genreDAO;
    private $genresXmoviesDAO;

    public function __construct()
    {
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

        if (isset($_GET['genres']) && !empty($_GET['date'])) {

            $moviesByGenres = $this->searchByGenres($_GET['genres']);
            $allShowtimesDate = $this->moviesToShowtimesDate($moviesByGenres);
            $showtimesByDate = $this->searchByDate($allShowtimesDate);
            $this->showFilteredMovies(null, $showtimesByDate);
        } else if (isset($_GET['genres']) && empty($_GET['date'])) {

            try {
                $moviesByGenres = $this->searchByGenres($_GET['genres']);
            } catch (\Throwable $th) {
                array_push($advices, DB_ERROR);
            }finally{
                $this->showFilteredMovies($moviesByGenres, null);
            }
            
        } else if (isset($_GET['date']) && !isset($_GET['genres'])) { 

            try {
                $showtimesByDate = $this->searchByDate($_GET['date']);
            } catch (\Throwable $th) {
                array_push($advices, DB_ERROR);
            }finally{
                $this->showFilteredMovies(null, $showtimesByDate);
            }
            
        }
    }

    public function searchMovieByName()
    {
        $advices = array(); //Futuramente se guardaran los msj de errores
        $title = $_GET['title'];
        $movie = new Movie();
        $movie->setTitle($title);
        try {
            $comprobationMovie = $this->MoviesDAO->exists($movie);
            if ($comprobationMovie) {
                array_push($advices, ADDED);
            } else {
                array_push($advices, NOT_FOUND);                
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } finally {
            require_once(VIEWS . '/ShowMovieByName.php');
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

    public function moviesToShowtimesDate($moviesByGenres){

        try {

            $showtimes = $this->showtimeDao->getAll();
            $showtimesDate = array();

            foreach ($showtimes as $showtime) {

                foreach ($moviesByGenres as  $movie) {
                    
                    if ($showtime->getMovie()->getTitle() == $movie->getTitle() && $showtime->getActive() == true) {
                        array_push($showtimesDate, $showtime->getDate());
                    }
                }
            }


        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }

        return $showtimesDate;
    }

    public function showFilteredMovies($moviesByGenres = "", $showtimesByDate = ""){
        
        require_once(VIEWS . '/ShowFilteredMovies.php');
    }

}
