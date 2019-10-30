<?php 
namespace Controllers;
use DAO\InfoAPI\moviesAPI as moviesAPI;
use DAO\CinemasDAO as CinemasDAO;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\GenresDAO as GenresDAO;

class SearchMovieController{
    
    private $allMovies;
    private $showtimeDao;
    private $genreDAO;
 
    public function __construct() {
        $this->allMovies = moviesAPI::getMoviesFromApi(); 
        $this->showtimeDao = new ShowtimeDAO();
        $this->genreDAO = new GenresDAO();
    }

    public function FilteredMovies(){

        if(isset($_GET['genres']) && isset($_GET['date'])){

            $this->showFilteredMovies();
        }else if(isset($_GET['genres']) && !isset($_GET['date'])){

            $this->showFilteredMovies();
        }else if(!isset($_GET['genres']) && isset($_GET['date'])){

            $this->showFilteredMovies();
        }else{

           // $this->showFilters();
        }
    }

    public function showFilters(){
        $genres = $this->genresDAO->getAll();
        //require_once(VIEWS  . '/Filter.php');
    }

    public function showFilteredMovies(){

        require_once(VIEWS  . '/ShowFilteredMovies.php');
    }

    public function searchMovieByName(){
        $ErrorsList=array();//Futuramente se guardaran los msj de errores
        $title= $_GET['title'];

        $comprobationMovie=moviesAPI::searchMovieByTitle($this->allMovies,$title);
        if ($comprobationMovie != null) {
        require_once(VIEWS .'/ShowMovieByName.php');
        }else {
            echo "<script> alert('No se encontró la pelicula ingresada!');";
            echo "window.location= ROOT.'/home.php'; </script> ";
        }
    }

    public function searchByGenres(){

        $Genres=$_GET['genres'];  
        // var_dump($_GET['genres']);
        $moviesWithGenres=moviesAPI::getMovieForGenres($Genres,$this->allMovies);
        if (!empty($moviesWithGenres)) {
            require_once(VIEWS.'/ShowFilteredMovies.php');
        }else{
            echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');" ; 
            echo "window.location= ROOT.'/home.php'; </script> ";
        }   
    }

    public function searchByGenresAndDate(){

        if(isset($_GET['genres'])){

            $Genres=$_GET['genres'];  
            // var_dump($_GET['genres']);
            $moviesWithGenres=moviesAPI::getMovieForGenres($Genres,$this->allMovies);
            if (!empty($moviesWithGenres)) {
                require_once(VIEWS.'/ShowFilteredMovies.php');
            }else{
                echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');" ; 
                echo "window.location= ROOT.'/home.php'; </script> ";
            }   
        }

        if(isset($_GET['date'])){

            $dateToSearch = $_GET['date'];
            $showtimes = $this->showtimeDao->getAll();
            $showtimesByDate = array();

            foreach ($showtimes as $showtime) {
                
                if($showtime->getDate() == $dateToSearch && $showtime->getActive() == true){
                    
                    array_push($showtimesByDate, $showtime);
                }
            }

            if (!empty($showtimesByDate)) {
                require_once(VIEWS.'/ShowFilteredMovies.php');
            }else{
                echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');" ; 
                echo "window.location= ROOT.'/home.php'; </script> ";
            }

            // var_dump($showtimes);
            // var_dump($dateToSearch);
        }
    }

    public function searchByDate(){
        
    }
//CUANDO CREAMOS LAS FUNCIONES, AHI LAS ACTIVAMOS
    /*public function moviesDateFilter($movieFunctions){
        
        $date=$_GET['date'];
        $result=array();

        for ($i=0; $i < count($movieFunctions); $i++) { 
            if ($movieFunctions[$i]->getDate()==$date) {
            array_push($result,$movieFunctions[$i]);
            }
        }
        return $result;
    }*/

  /*  public function searchByGenresAndDate(){

        $movies=moviesAPI::getMoviesFromApi();
        $MovieGenres=genresAPI::getGenres();
        $Genres=$_GET['genres'];
        $Date=$_GET['date'];
    }*/

}

?>