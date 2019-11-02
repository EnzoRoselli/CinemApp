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

    public function FilteredMovies()
    {

        if (isset($_GET['genres']) && isset($_GET['date'])) {

            $this->showFilteredMovies();
        } else if (isset($_GET['genres']) && !isset($_GET['date'])) {

            $this->showFilteredMovies();
        } else if (!isset($_GET['genres']) && isset($_GET['date'])) {

            $this->showFilteredMovies();
        } else {

            $this->searchMovieByName();
        }
    }

    public function showFilters()
    {

        $genres = $this->genreDAO->getAll();
        require_once(VIEWS  . '/Filter.php');
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



    public function searchByGenres()
    {
        $Genres = $_GET['genres'];
        $moviesWithGenres = moviesAPI::getMovieForGenres($Genres, $this->allMovies);
        $allMovies = $this->MoviesDAO->getAll();
        if (!empty($moviesWithGenres)) {
            require_once(VIEWS . '/ShowFilteredMovies.php');
        } else {
            echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');";
            echo "window.location= ROOT.'/home.php'; </script> ";
        }
    }

    public function searchByDate()
    {
            $dateToSearch = $_GET['date'];
            $showtimes = $this->showtimeDao->getAll();
            $showtimesByDate = array();

            foreach ($showtimes as $showtime) {

                if ($showtime->getDate() == $dateToSearch && $showtime->getActive() == true) {
                    array_push($showtimesByDate, $showtime);
                }
            }

            if (!empty($showtimesByDate)) {/* modularizar para usar movieGrid */
                require_once(VIEWS . '/ShowFilteredMovies.php');
            } else {
                echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');";
                echo "window.location= ROOT.'/home.php'; </script> ";
            }
     
    }


    public function searchByGenresAndDate()
    {
        if(isset($_GET['genres']) || isset($_GET['date'])){

            if(isset($_GET['genres'])){

                $genresIds = $_GET['genres'];
                // $moviesWithGenres = moviesAPI::getMovieForGenres($Genres, $this->allMovies);
                
                $moviesWithGenres = $this->genresXmoviesDAO->getMoviesByGenresIds($genresIds);
                // var_dump($moviesWithGenres);
                if (!empty($moviesWithGenres)) {
                    require_once(VIEWS . '/ShowFilteredMovies.php');
                } else {
                    echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');";
                    echo "window.location= ROOT.'/home.php'; </script> ";
                }
            }

            if(isset($_GET['date'])){

                $dateToSearch = $_GET['date'];
                $showtimes = $this->showtimeDao->getAll();
                $showtimesByDate = array();
        
                foreach ($showtimes as $showtime) {
        
                    if ($showtime->getDate() == $dateToSearch && $showtime->getActive() == true) {
        
                        array_push($showtimesByDate, $showtime);
                    }
                }
        
                if (!empty($showtimesByDate)) {
                    require_once(VIEWS . '/ShowFilteredMovies.php');
                } else {
                    echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');";
                    echo "window.location= ROOT.'/home.php'; </script> ";
                }
            }

        }

    }
}
