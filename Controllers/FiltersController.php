<?php namespace Controllers;
    use DAO\InfoAPI\moviesAPI as moviesAPI;
    use DAO\CinemasDAO as CinemasDAO;
    use DAO\ShowtimesDAO as ShowtimeDAO;
    use DAO\MoviesDAO as MoviesDAO;
    use DAO\GenresDAO as GenresDAO;
    use Controllers\GenresController as GenresController;

    class FiltersController{
        private $genresList;
        private $showtimeDao;
        private $MoviesDAO;
        private $genreDAO;

        public function __construct(){
            
            $this->showtimeDao = new ShowtimeDAO();
            $this->genreDAO = new GenresDAO();
            $this->MoviesDAO = new MoviesDAO();
        }

        public function showFilters(){
            $genres = $this->genreDAO->getAll();  
            require_once(VIEWS  . '/Filter.php');
        }

        public function searchByDate()
        {
            if (isset($_GET['date'])) {

                $dateToSearch = $_GET['date'];
                $showtimes = $this->showtimeDao->getAll();
                $showtimesByDate = array();

                foreach ($showtimes as $showtime) {

                    if ($showtime->getDate() == $dateToSearch && $showtime->getActive() == true) {
                        array_push($showtimesByDate, $showtime);
                    }
                }

                if (!empty($showtimesByDate)) {/* modularizar para usar movieGrid */
                    require_once(VIEWS . '/ShowFilteredMovies.php');
                } else {
                    echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');";
                    echo "window.location= ROOT.'/home.php'; </script> ";
                }
                // var_dump($showtimes);
                // var_dump($dateToSearch);
            }
        }
    }

?>