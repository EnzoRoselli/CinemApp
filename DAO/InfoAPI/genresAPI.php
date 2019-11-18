<?php

namespace DAO\InfoAPI;



class genresAPI
{
    

    static function getGenres()
    {
        $jsonMoviesGenres = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");
        $GenresDetails = json_decode($jsonMoviesGenres);

        return $GenresDetails->genres;
    }

    static function getIDGenre($genre, array $genresAPI)
    {
        $results = null;

        for ($i = 0; $i < count($genresAPI); $i++) {
            
            if ($genresAPI[$i]->name == $genre) {

                return $genresAPI[$i]->id;
                break;
            }
        }
        return $results;
    }

    static function getGenresById($ids, array $genresAPI){

        $genres = array();

        for ($i=0; $i < count($genresAPI); $i++) { 
            
            for ($j=0; $j < count($ids); $j++) { 
                
                if($genresAPI[$i]->id == $ids[$j]){
    
                    array_push($genres, $genresAPI[$i]->name);
                }
            }

        }
        
        return $genres;
    }
}
