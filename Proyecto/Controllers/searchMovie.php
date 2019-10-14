<?php 

require_once("../config/autoload.php");

use config\autoload as Autoload;
Autoload::Start();

use DAO\InfoAPI\moviesAPI as moviesAPI;



if (isset($_GET['title'])){
    $title=$_GET['title'];
    $allMoviesAPI=moviesAPI::getMoviesFromApi();
   
    $comprobationMovie=moviesAPI::searchMovieByTitle($allMoviesAPI,$title);
    if ($comprobationMovie!=null) {
        echo "<script> alert('Se encontró la pelicula ingresada!');" ;

       echo "window.location= '../views/AdminCine.php'; </script> ";
    }else{
        echo "<script> alert('NO se encontró la pelicula ingresada!');" ; 
       echo "window.location= '../views/SearchMoviesWithFilters.php'; </script> ";
    }
}


?>