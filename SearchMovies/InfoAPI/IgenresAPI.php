<?php 
namespace InfoAPI;
interface IgenresAPI 
{
    function GetGenres();
    function getIDGenre($AllGenres,$genre);
    //A DONDE LO CLAVO ESTE METODO
    function getMovieForGenres(array $genresFilter,array $MoviesGenre, array $movies);
}


?>