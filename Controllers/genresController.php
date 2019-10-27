<?php namespace Controllers;

use DAO\InfoAPI\genresAPI as genresAPI;


class genresController 
{
    private $genres;

    public function __construct() {
        $this->genres = genresAPI::getGenres();
    }

    public function showGenresFilter(){
        $genres=$this->genres;
        //require_once(VIEWS.'/ShowMovieFilters.php');
        require_once(VIEWS.'/Filter.php');
    }

    
}

?>