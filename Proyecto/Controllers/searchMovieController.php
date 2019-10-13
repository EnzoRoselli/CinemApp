<?php 

require_once("../config/autoload.php");

use config\autoload as Autoload;
use DAO\InfoAPI\moviesAPI as moviesAPI;

Autoload::Start();


if (isset($_GET['title'])){
    
    $movieController=new SearchMovieController();

    $movieController->searchMovie();
}

class SearchMovieController{
    
    private $moviesAPI;

    public function searchMovie(){

        $moviesAPI=new moviesAPI();

        $title=$_GET['title'];
        $allMoviesAPI=$moviesAPI->getMoviesFromApi();
    
        $comprobationMovie=$moviesAPI->searchMovieByTitle($allMoviesAPI,$title);
        if ($comprobationMovie!=null) {
            echo "<script> alert('Se encontró la pelicula ingresada!');" ;
            echo "window.location= '../views/AdminCine.php'; </script> ";
        }else{
            echo "<script> alert('NO se encontró la pelicula ingresada!');" ; 
            echo "window.location= '../views/SearchMovieWithFiltersController.php'; </script> ";
        }
    }
}


?>