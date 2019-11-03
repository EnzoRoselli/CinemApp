<?php

namespace Controllers;

use DAO\InfoAPI\moviesAPI as moviesAPI;
use DAO\InfoAPI\genresAPI as genresAPI;
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

            $this->showFilteredMovies();
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

    public function showFilteredMovies($moviesByGenres = "", $showtimesByDate = ""){
        
        require_once(VIEWS . '/ShowFilteredMovies.php');
    }

}
