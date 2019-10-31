<?php
namespace Model;

    class Genre 
    {
        private $genreId;
        private $name;

        public function __construct($name="") {
            $this->name=$name;
        }

        public function getId(){ return $this->genreId;}
        public function getName(){ return $this->name;}

        public function setId($genreId){$this->genreId = $genreId;}
        public function setName($name){$this->name=$name;}
    }
    
?>