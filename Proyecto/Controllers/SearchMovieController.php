<?php 

require "../Config/autoload.php";

use Config\autoload as Autoload;
Autoload::Start();

use InfoAPI\moviesAPI as moviesAPI;

$moviesAPI=new moviesAPI();

if (isset($_GET['title'])){
    $title=$_GET['title'];
    $allMoviesAPI=$moviesAPI->getMoviesFromApi();
    $comprobationMovie=$moviesAPI->searchMovieByTitle($allMoviesAPI,$title);
    if ($comprobationMovie!=null) {
        echo "<script> alert('Se encontró la pelicula ingresada!');" ; 
       echo "window.location= '../views/searchMovie.html'; </script> ";
    }else{
        echo "<script> alert('NO se encontró la pelicula ingresada!');" ; 
       echo "window.location= '../views/searchMovie.html'; </script> ";
    }
}

/*
function getMoviesFromApi()
{

$jsonMovies=file_get_contents("https://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");
$details=json_decode($jsonMovies);
$moviesList=$details->results;
return $moviesList;
}


function searchMovieByTitle($movieArray,$title)
{
    for ($i=0; $i < count($movieArray); $i++) {  
        if ($movieArray[$i]->original_title==$title) {            
           return $movieArray[$i];
          }      
      }
      return null;
}


function getGenres()
{
$jsonMoviesGenres=file_get_contents("https://api.themoviedb.org/3/genre/movie/list?language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");
$GenresDetails=json_decode($jsonMoviesGenres);
return $GenresDetails->genres;
}

function getMovieForGenres(array $genresFilter,$MoviesGenre,$movies)
{
    $IDgenres=array();  

    for ($i=0; $i < count($genresFilter); $i++) { 
        $pos=getIDGenre($MoviesGenre,$genresFilter[$i]);
       array_push($IDgenres,$pos);
    }

    $MoviesWithTheIds=array();
    for ($i=0; $i < count($movies) ; $i++) { 
        if (!array_diff($IDgenres,$movies[$i]->genre_ids)) {
            array_push($MoviesWithTheIds,$movies[$i]);
        }
    }
  return $MoviesWithTheIds;
}

function getIDGenre($AllGenres,$genre)
{
    $results=null;
    for ($i=0; $i < count($AllGenres); $i++)
    { 
        if ($AllGenres[$i]->name==$genre)
        {
            return $AllGenres[$i]->id;
        }
    }   
    return $results;
}

$movies=getMoviesFromApi();
$title=$_GET['title'];
$flag=searchMovieByTitle($movies,$title);

if ($flag!=null) {
 
    $MovieGenres=getGenres();
    $Genres=$_GET['genres'];

    $moviesWithGenres=getMovieForGenres($Genres,$MovieGenres,$movies);
    var_dump($moviesWithGenres);
}*/

?>