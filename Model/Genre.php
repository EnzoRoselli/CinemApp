<?php
namespace Model;

    class Genre 
    {
        private $genreId;
        private $name;

        public function __construct($genreId,$name) {
            $this->genreId=$genreId;
            $this->name=$name;
        }

        public function getGenreId(){ return $this->genreId;}
        public function getName(){ return $this->name;}

        public function setGenreId($genreId){$this->genreId = $genreId;}
        public function setName($name){$this->name=$name;}
    }
    
?>