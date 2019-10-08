<?php

require "../Config/Autoload.php";

use config\autoload as Autoload;
Autoload::Start();

use InfoAPI\genresAPI as genresAPI;
use InfoAPI\moviesAPI as moviesAPI;


$moviesAPI=new moviesAPI();

if (isset($_GET['genres'])) {
   
$movies=moviesAPI::getMoviesFromApi();
$MovieGenres=genresAPI::getGenres();
$Genres=$_GET['genres'];

$moviesWithGenres=moviesAPI::getMovieForGenres($Genres,$movies);
var_dump($moviesWithGenres);
}

?>