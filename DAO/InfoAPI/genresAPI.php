<?php

namespace DAO\InfoAPI;



class genresAPI implements IgenresAPI
{
    

    static function getGenres()
    {
        $jsonMoviesGenres = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?language=en-US&api_key=f74ffe2d8ab6690478568c0a2eb5582a");
        $GenresDetails = json_decode($jsonMoviesGenres);

        return $GenresDetails->genres;
    }

    static function getIDGenre($genre)
    {
        $results = null;
       
        $AllGenres = genresAPI::getGenres();
        for ($i = 0; $i < count($AllGenres); $i++) {
            
            if ($AllGenres[$i]->name == $genre) {

                return $AllGenres[$i]->id;
                break;
            }
        }
        return $results;
    }

    static function getGenresById($ids){

        $AllGenres = genresAPI::getGenres();
        $genres = array();

        for ($i=0; $i < count($AllGenres); $i++) { 
            
            for ($j=0; $j < count($ids); $j++) { 
                
                if($AllGenres[$i]->id == $ids[$j]){
    
                    array_push($genres, $AllGenres[$i]->name);
                }
            }

        }
        var_dump($genres);
        return $genres;
    }
}
