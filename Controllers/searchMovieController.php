<?php

namespace Controllers;

use DAO\InfoAPI\moviesAPI as moviesAPI;
use DAO\CinemasDAO as CinemasDAO;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\MoviesDAO as MoviesDAO;


class SearchMovieController
{

    private $allMovies;
    private $showtimeDao;
    private $MoviesDAO;

    public function __construct()
    {
        $this->allMovies = moviesAPI::getMoviesFromApi();
        $this->showtimeDao = new ShowtimeDAO();
        $this->MoviesDAO = new MoviesDAO();
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

            $this->showFiltersView();
        }
    }


    public function showFiltersView()
    {

        require_once(VIEWS  . '/Filter.php');
    }

    public function showFilteredMovies()
    {

        require_once(VIEWS  . '/ShowFilteredMovies.php');
    }

    public function searchMovieByName()
    {
        $advices = array(); //Futuramente se guardaran los msj de errores
        $title = $_GET['title'];
        try {
            $comprobationMovie = $this->MoviesDAO->exists($title);
            if ($comprobationMovie) {
                array_push($advices, ADDED);
            } else {
                array_push($advices, VERIFY);
            }
        } catch (\Throwable $th){     
            array_push($advices, DB_ERROR);
        }finally{
            require_once(VIEWS . '/ShowMovieByName.php');
        }
    }

    public function searchByGenres()
    {
        $Genres = $_GET['genres'];
        $moviesWithGenres = moviesAPI::getMovieForGenres($Genres, $this->allMovies);
        if (!empty($moviesWithGenres)) {
            require_once(VIEWS . '/ShowFilteredMovies.php');
        } else {
            echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');";
            echo "window.location= ROOT.'/home.php'; </script> ";
        }
    }

    public function searchByGenresAndDate()
    {

        if (isset($_GET['genres'])) {

            $Genres = $_GET['genres'];
            $moviesWithGenres = moviesAPI::getMovieForGenres($Genres, $this->allMovies);
            if (!empty($moviesWithGenres)) {
                require_once(VIEWS . '/ShowFilteredMovies.php');
            } else {
                echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');";
                echo "window.location= ROOT.'/home.php'; </script> ";
            }
        }

        if (isset($_GET['date'])) {

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

            // var_dump($showtimes);
            // var_dump($dateToSearch);
        }
    }

    public function searchByDate()
    { }
}
