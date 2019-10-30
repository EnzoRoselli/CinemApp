<?php namespace Controllers;
    use Controllers\GenresController as GenresController;

    class FiltersController{
        private $genresList;

        public function __construct(){
            $this->genresList = array();
            $this->genresList = new GenresController();
        }

        public function showFilters(){
            $this->genresList->sendToDataBase();
            $genres = $this->genresList->getGenreList();
              
            require_once(VIEWS  . '/Filter.php');
        }
    }

?>