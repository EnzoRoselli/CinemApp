<?php
namespace InfoAPI;
interface ImoviesAPI{
    function getMoviesFromApi();
    function searchMovieByTitle($movieArray,$title);
    

}

?>