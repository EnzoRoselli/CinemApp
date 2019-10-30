<?php namespace Controllers;

use DAO\InfoAPI\genresAPI as genresAPI;
use Model\Genre as Genre;
use DAO\GenresDAO as GenreDAO;

class genresController 
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

    public function sendToDataBase(){
        foreach($this->genres as $genre){
            var_dump($genre);
            $this->genreDAO->add($genre);
        }
    }

    public function getGenreList(){
       // $this->genreList = genresAPI::getGenres();
         return $this->genres;
    }
    
}

?>