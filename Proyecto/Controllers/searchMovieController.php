<?php 

use DAO\InfoAPI\moviesAPI as moviesAPI;


class SearchMovieController{
    
    private $allMovies;
 
    public function __construct() {
        $this->allMovies = moviesAPI::getMoviesFromApi(); 
    }

    public function searchMovieByName(){
        $title=$_GET['title'];
        $comprobationMovie=moviesAPI::searchMovieByTitle($this->allMovies,$title);
        if ($comprobationMovie != null) {
        require_once('../Views/SearchMovieByName.php');
        }else {
            echo "<script> alert('No se encontró la pelicula ingresada!');";
            echo "window.location= '../views/home.php'; </script> ";
        }
    }

    public function searchByGenres(){

        $Genres=$_GET['genres'];  
        $moviesWithGenres=moviesAPI::getMovieForGenres($Genres,$this->allMovies);
        if (!empty($moviesWithGenres)) {
        require_once('../Views/ShowFilteredMovies.php');
    }else{
        echo "<script> alert('No se encuentran peliculas que contegan los generos ingresados!');" ; 
        echo "window.location= '../views/home.php'; </script> ";
     }   
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