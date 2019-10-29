<?php
    namespace Controllers;

    use DAO\MoviesDAO as MoviesDAO;

    class HomeController
    {
        private $moviesDAO;

        public function __construct()
        {
            $this->moviesDAO = new MoviesDAO();
        }

        public function Index($message = "")
        {
            // Proceso
            require_once(VIEWS."/header.php");
            $this->showHome();
            require_once(VIEWS."/footer.php");
        }
        
        public function showGrid()
        {
            $moviesList = $this->moviesDAO->getAll();
            require_once(VIEWS."/MovieGrid.php");
        }

        public function showHome()
        {       
            require_once(VIEWS.'/lastArrival.php');
            $moviesList = $this->moviesDAO->getAll();
            require_once(VIEWS."/MovieGrid.php");
        }

        public static function showMain($message = "")
        {
            // Proceso
            require_once(VIEWS."/header.php");
            $this->showHome();
            require_once(VIEWS."/footer.php");
        }
        
    }
?>