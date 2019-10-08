<?php 
namespace DAO\InfoAPI;

class moviesAPI implements ImoviesAPI{
   
static function getMoviesFromApi()
{
$jsonMovies=file_get_contents("https://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");

$details=json_decode($jsonMovies);
$moviesList=$details->results;

return $moviesList;
}

static function searchMovieByTitle($movieArray,$title)
{
    for ($i=0; $i < count($movieArray); $i++) {  
        if ($movieArray[$i]->original_title==$title) {            
           return $movieArray[$i];
          }      
      }
      return null;
}

function getGenresFromApi()
{
$jsonMoviesGenres=file_get_contents("https://api.themoviedb.org/3/genre/movie/list?language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");
$GenresDetails=json_decode($jsonMoviesGenres);
return $GenresDetails->genres;
}

static function getMovieForGenres(array $genresName,$movies)
{
    $IDgenres=array();
   
    for ($i=0; $i < count($genresName); $i++) { 
        $genre=$genresName[$i];
        $pos=genresAPI::getIDGenre($genre);
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




}
