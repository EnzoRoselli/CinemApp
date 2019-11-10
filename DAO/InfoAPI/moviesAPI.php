<?php

namespace DAO\InfoAPI;

use Model\Genre as Genre;
use DAO\InfoAPI\genresAPI as genresAPI;

class moviesAPI
{

    static function getMoviesFromApi()
    {
        $jsonMovies = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");
        $details = json_decode($jsonMovies);
        $moviesList = $details->results;
        
        return $moviesList;
    }

    static function searchMovieByTitle($movieArray, $title)
    {
        for ($i = 0; $i < count($movieArray); $i++) {
            if (strcasecmp($movieArray[$i]->title, $title) == 0) {
                return $movieArray[$i];
            }
        }
        return null; //throw excception
    }

    function getGenresFromApi()
    {
        $jsonMoviesGenres = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");
        $GenresDetails = json_decode($jsonMoviesGenres);
        return $GenresDetails->genres;
    }

    static function getGenresFromMovie(array $genresDAO, $movie, array $genresAPI)
    {
        $IDgenres = array();

        for ($i = 0; $i < count($genresDAO); $i++) {

            $genre = $genresDAO[$i]->getName();

            $pos = genresAPI::getIDGenre($genre, $genresAPI);
            
            array_push($IDgenres, $pos);
        }

        $genresIdList = array();
        $movieGenreIds = $movie->genre_ids;

        for ($i = 0; $i < count($IDgenres); $i++) {

            for ($j=0; $j < count($movieGenreIds); $j++) { 
                
                if($movieGenreIds[$j] == $IDgenres[$i]){

                    array_push($genresIdList, $IDgenres[$i]);
                }

            }
        }

        $APIgenresFromMovie = genresAPI::getGenresById($genresIdList, $genresAPI);

        return $APIgenresFromMovie;
    }

}
