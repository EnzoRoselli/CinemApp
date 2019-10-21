<?php
namespace Model;

    class Movie{

        private $movieId;
        private $title;
        private $duration;
        private $originalLanguage;
        private $overview;
        private $releaseDate;
        private $adult;
        private $posterPath;
        private $active;

        public function __construct($movieId,$title,$duration,$originalLanguage,$overview,$releaseDate,$adult,$posterPath)
        {
            $this->movieId = $movieId;
            $this->title = $title;
            $this->duration = $duration;
            $this->originalLanguage = $originalLanguage;
            $this->overview = $overview;
            $this->releaseDate = $releaseDate;
            $this->adult = $adult;
            $this->posterPath = $posterPath;
            $this->active = true;
        }

        public function getMovieId(){return $this->movieId;}
        public function getTitle(){return $this->title;}
        public function getDuration(){return $this->duration;}
        public function getOrignialLanguage(){return $this->orignialLanguage;}
        public function getOverview(){return $this->overview;}
        public function getReleaseDate(){return $this->releaseDate;}
        public function getAdult(){return $this->adult;}
        public function getPosterPath(){return $this->posterPath;}
        public function getActive(){ return $this->active;}

        public function setMovieId($movieId){$this->movieId=$movieId;}
        public function setTitle($title){$this->title=$title;}
        //THROWEAR UNA EXCEPTION SI NO PUDO SETTEARSE Y NO TERMINAR CARGANDO EL CINE
        public function setDuration($duration){
            if($duration > 0){
                $this->duration=$duration;
            }
        }
        public function setOriginalLanguage($originalLanguage){$this->originalLanguage=$originalLanguage;}
        public function setOverview($overview){$this->overview=$overview;}
        public function setReleaseDate($releaseDate){$this->releaseDate=$releaseDate;}
        public function setAdult($adult){$this->adult=$adult;}
        public function setPosterPath($posterPath){$this->posterPath=$posterPath;}
        public function setActive($active){$this->active = $active;}

    }


?>