<?php

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
        $MovieGenres=genresAPI::getGenres();
        $Genres=$_GET['genres'];  
        $moviesWithGenres=moviesAPI::getMovieForGenres($Genres,$movies);
        var_dump($moviesWithGenres);
    }
}


?>