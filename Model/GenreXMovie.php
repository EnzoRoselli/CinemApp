<?php
namespace Model;

    class GenreXMovie{

        private $movieId;
        private $genreId;

        public function __construct($movieId = "", $genreId = "")
        {
            $this->movieId = $movieId;
            $this->genreId = $genreId;
        }

        public function getMovieId(){return $this->movieId;}
        public function getGenreId(){return $this->genreId;}

        public function setMovieId($movieId){$this->movieId = $movieId;}
        public function setGenreId($genreId){$this->genreId = $genreId;}
    }
?>