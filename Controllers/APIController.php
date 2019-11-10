<?php

namespace Controllers;

use DAO\InfoAPI\moviesAPI as moviesAPI;
use DAO\InfoAPI\genresAPI as genresAPI;
use DAO\MoviesDAO as MoviesDAO;
use DAO\GenresDAO as GenresDAO;
use DAO\GenresXMoviesDAO as GenresXMoviesDAO;
use Model\Movie as Movie;
use Model\Genre;
use Model\GenreXMovie as GenreXMovie;
use Controllers\HomeController as HomeController;

class APIController
{

    private $moviesDAO;
    private $movieList;
    private $genreList;
    private $moviesAPI;
    private $genresAPI;
    private $genresXmoviesDAO;

    public function __construct()
    {
        $this->moviesAPI = moviesAPI::getMoviesFromApi();
        $this->genresAPI = genresAPI::getGenres();
        $this->moviesDAO = new MoviesDAO();
        $this->genresDAO = new GenresDAO();
        $this->genresXmoviesDAO = new GenresXMoviesDAO();
        $this->movieList = array();
        $this->genreList = array();
    }

    public function getFromAPI()
    {


        foreach ($this->moviesAPI as $key) {
            $movie = new Movie(
                $key->title,
                120,
                $key->original_language,
                $key->overview,
                $key->release_date,
                $key->adult,
                $key->poster_path
            );
            array_push($this->movieList, $movie);
        }

        foreach ($this->genresAPI as $genreItem) {
            $genre = new Genre($genreItem->name);
            $genre->setId($genreItem->id);

            array_push($this->genreList, $genre);
        }
    }

    public function sendToDataBase()
    {
        $this->getFromAPI();
        $newInfo = false;
        foreach ($this->movieList as $movie) {
            
            try {
                if (!$this->moviesDAO->exists($movie)) {
                    $this->moviesDAO->add($movie);
                    $newInfo = true;
                }
             
            } catch (Exception $e) {
                var_dump($e);
                echo 'error';
            }
        }

        foreach ($this->genreList as $genre) {
            try {
                if (!$this->genresDAO->exists($genre)) {
                    $this->genresDAO->add($genre);
                    $newInfo=true;
                }
            } catch (Exception $e) {
                //mostrar error
                echo 'error';
            }
        }

        $genres = $this->genresDAO->getAll();
        $movies = $this->moviesDAO->getAll();
        $genresFromMovie = array();

        for ($i = 0; $i < count($this->moviesAPI); $i++) {
            $genresFromMovie = array();

            $APIgenresFromMovie = moviesAPI::getGenresFromMovie($genres, $this->moviesAPI[$i], $this->genresAPI);

            for ($j = 0; $j < count($APIgenresFromMovie); $j++) {

                for ($k = 0; $k < count($genres); $k++) {

                    if ($APIgenresFromMovie[$j] === $genres[$k]->getName()) {

                        array_push($genresFromMovie, $genres[$k]);
                    }
                }
            }

            for ($j = 0; $j < count($movies); $j++) {

                if ($this->moviesAPI[$i]->title == $movies[$j]->getTitle()) {

                    $movieId = $movies[$j]->getId();
                    break;
                }
            }

            for ($j = 0; $j < count($genresFromMovie); $j++) {

                $genre_x_movie = new GenreXMovie();
                $genre_x_movie->setMovieId($movieId);
                $genre_x_movie->setGenreId($genresFromMovie[$j]->getId());

                try {
                    if (!$this->genresXmoviesDAO->exists($genre_x_movie)) {
                        $this->genresXmoviesDAO->add($genre_x_movie);
                    }
                } catch (Exception $e) {
                    //mostrar error
                    echo 'error';
                }
            }
        }
        if ($newInfo) {
            echo '<script type="text/javascript">
            alert("Se ha cargado nueva información de la API");
     
        </script>';
        
        }
       
        
    }
}
