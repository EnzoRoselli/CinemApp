<?php namespace Controllers;

use DAO\GenresDAO as GenreDAO;

class GenresController 
{

    private $genreDAO;

    public function __construct() {

        $this->genreDAO = new GenreDAO();
    }

    public function showGenresFilter(){
        $genres=$this->genresDAO->getAll();
        require_once(VIEWS.'/Filter.php');
    }

    public function getGenresByMovieId($MovieId)
    {
       $genresName=$this->genreDAO->getGenresByMovieId($MovieId);
    }
    
}

?>