<?php
namespace DAO\InfoAPI;
interface ImoviesAPI{
    static function getMoviesFromApi();
    static function searchMovieByTitle($movieArray,$title);
    static function getMovieForGenres(array $genresFilter, array $movies);

}

?>