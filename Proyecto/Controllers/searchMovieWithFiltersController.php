<?php

include('../views/header.php');
include('../views/nav.php');
require_once("../config/autoload.php");
use Config\Autoload as Autoload;
use DAO\InfoAPI\genresAPI as genresAPI;
use DAO\InfoAPI\moviesAPI as moviesAPI;

Autoload::Start();

$searchMoviesFilterDateController= new SearchMoviesWithFiltersController();

if (isset($_GET['genres']) && isset($_GET['date'])) {  
    
   $searchMoviesFilterDateController->searchByGenresAndDate();

//SE LLAMA A MoviesDateFilter()
//y luego buscamos de las peliculas que tomo la funcion,cuales tienen los generos que vino dle get
//$moviesWithGenres=moviesAPI::getMovieForGenres($Genres,$movies);
 //Todas las peliculas con los generos buscados
//Debemos buscar aquellas peliculas que concuerden con la fecha ingresada, ya la tenemos en la variable Date

}else if(isset($_GET['genres'])){
    
    $searchMoviesFilterDateController->searchByGenres();

}else if (isset($_GET['date'])) {
    
    $searchMoviesFilterDateController->moviesDateFilter(null);
    //Tomar todas aqullas peliculas de la fecha recibida 
    //Osea llamar a MoviesDateFilter()
}

class SearchMoviesWithFiltersController{

    public function moviesDateFilter($movieFunctions){
        
        $date=$_GET['date'];
        $result=array();

        for ($i=0; $i < count($movieFunctions); $i++) { 
            if ($movieFunctions[$i]->getDate()==$date) {
            array_push($result,$movieFunctions[$i]);
            }
        }
        return $result;
    }

    public function searchByGenresAndDate(){

        $movies=moviesAPI::getMoviesFromApi();
        $MovieGenres=genresAPI::getGenres();
        $Genres=$_GET['genres'];
        $Date=$_GET['date'];
    }

    public function searchByGenres(){

        $movies=moviesAPI::getMoviesFromApi();
        $Genres=$_GET['genres'];  
        $moviesWithGenres=moviesAPI::getMovieForGenres($Genres,$movies);
        return $moviesWithGenres;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../views/css/GridStyle.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <?php
        $searchMoviesFilterDateController= new SearchMoviesWithFiltersController();
        $moviesWithGenres=  $searchMoviesFilterDateController->searchByGenres();
        for ($i = 0; $i < count($moviesWithGenres); $i++) {
            $poster = $moviesWithGenres[$i]->poster_path;
            ?>
            <div class="block">
                <button class="card-image">
                    <a href="">
                    <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $poster; ?> class="image">
                    </a>
                    
                    
                    <div class="overview">
                        <h2><?php echo $moviesWithGenres[$i]->original_title;?></h2>
                        <p><?php echo $moviesWithGenres[$i]->release_date;?></p>
                    </div>
                </button>

            </div>
        <?php
        }
        ?>

    </div>
</body>

</html>