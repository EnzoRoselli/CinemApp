<?php namespace Controllers;

use DAO\InfoAPI\genresAPI as genresAPI;


class genresController 
{
    private $genresDAO;

    public function __construct() {
        $this->genresDAO = genresAPI::getGenres();
    }

    public function showGenresFilter(){
        $genres=$this->genres;
        //require_once(VIEWS.'/ShowMovieFilters.php');
        require_once(VIEWS.'/Filter.php');
    }

    
}

?>