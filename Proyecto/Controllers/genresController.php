<?php namespace Controllers;

use DAO\InfoAPI\genresAPI as genresAPI;


class genresController 
{
    private $allGenres;

    public function __construct() {
        $this->genres = genresAPI::getGenres();
    }

    public function showGenresFilter(){
        require_once('../Views/ShowMovieFilters.php');
    }
}

?>