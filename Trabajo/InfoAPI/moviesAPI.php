<?php 
namespace InfoAPI;

class moviesAPI implements ImoviesAPI{
   
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




}
