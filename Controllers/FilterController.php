<?php
    namespace Controllers;

    use DAO\ShowtimesDAO as ShowtimesDAO;
    use DAO\InfoAPI\genresAPI as genresAPI;

    class FilterController{

        private $showtimesDAO;
        private $genresDAO;

        public function __construct()
        {
            $this->showtimesDAO = new ShowtimesDAO();
            $this->genresDAO = genresAPI::getGenres();
        }

        public function showFilters(){
            $showtimesList = $this->showtimesDAO->getAll();
            $genres=$this->genresDAO;
            require_once(VIEWS . "/Filter.php");
        }
    }

?>