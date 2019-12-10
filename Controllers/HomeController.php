<?php
    namespace Controllers;

    use DAO\MoviesDAO as MoviesDAO;
    use DAO\GenresDAO as GenresDAO;
    use Controllers\ShowtimeController as ShowtimeController;

    class HomeController
    {
        private $moviesDAO;
        private $genresDAO;
        private $ShowtimeController;

        public function __construct()
        {
            $this->genresDAO = new GenresDAO();
            $this->moviesDAO = new MoviesDAO();
            $this->ShowtimeController=new ShowtimeController();
        }

        public function Index($message = "")
        {
            require_once(VIEWS."/header.php");
            $this->showHome();
            require_once(VIEWS."/footer.php");
        }

        public function showHome()
        {   
           
            $this->ShowtimeController->updateShowtimes();
            $moviesList = $this->moviesDAO->getAll();  
            $genresByMovie = array();

            foreach ($moviesList as $movie) {
                
                $genres = $this->genresDAO->getGenresByMovieId($movie->getId());

                array_push($genresByMovie, $genres[0]);
            }
            
            $lastMovie = $this->moviesDAO->searchById(20);
            require_once(VIEWS.'/Slider.php');
            require_once(VIEWS."/Showcase.php");
            require_once(VIEWS.'/lastArrival.php');
            require_once(VIEWS."/footer.php");
        }

        public function showMovieGrid(){
            $moviesList = $this->moviesDAO->getAll();  
            $genresByMovie = array();

            foreach ($moviesList as $movie) {
                
                $genres = $this->genresDAO->getGenresByMovieId($movie->getId());

                array_push($genresByMovie, $genres[0]);
            }
            require_once(VIEWS."/MovieGrid.php");
        }

        public static function showMain($message = "")
        {
            $homeController = new HomeController();
            require_once(VIEWS."/header.php");
            $homeController->showHome();
            require_once(VIEWS."/footer.php");
        }
        
    }
?>