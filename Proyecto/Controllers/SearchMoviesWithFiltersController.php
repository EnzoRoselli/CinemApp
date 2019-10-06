<?php

require "../Config/autoload.php";

use Config\autoload as Autoload;
Autoload::Start();

use InfoAPI\genresAPI as genresAPI;
use InfoAPI\moviesAPI as moviesAPI;

$genresInfo=new genresAPI();
$moviesAPI=new moviesAPI();

if (isset($_GET['genres'])) {
   
$movies=$moviesAPI->getMoviesFromApi();
$MovieGenres=$genresInfo->getGenres();
$Genres=$_GET['genres'];
$moviesWithGenres=getMovieForGenres($Genres,$MovieGenres,$movies);
var_dump($moviesWithGenres);
}

?>