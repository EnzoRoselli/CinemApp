<?php namespace Controllers;

use DAO\InfoAPI\genresAPI as genresAPI;
use Model\Genre as Genre;
use DAO\GenresDAO as GenreDAO;

class GenresController 
{
    private $genres;
    private $genreDAO;

    public function __construct() {
        $this->genres = genresAPI::getGenres();
        $this->genreDAO = new GenreDAO();
    }

    public function showGenresFilter(){
        $genres=$this->genres;
        require_once(VIEWS.'/Filter.php');
    }

  /*  public function sendToDataBase(){
        $genresList = json_decode(json_encode($this->genres), true);
        foreach($genresList as $key){
            $genre = new Genre();
            $genre->setName($key['name']);
            $this->genreDAO->add($genre);
        }
    }*/
/*
    public function getGenreList(){
       // $this->genreList = genresAPI::getGenres();
         return $this->genres;
    }*/
    public function getGenresByMovieId($MovieId)
    {
       $genresName=$this->genreDAO->getGenresByMovieId($MovieId);
    }
    
}

?>