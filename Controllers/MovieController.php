<?php
    namespace Controllers;
    use DAO\InfoAPI\moviesAPI as moviesAPI;
    use DAO\MoviesDAO as MoviesDAO;
    use Model\Movie as Movie;


        class MovieController{
        private $moviesDAO;
        private $movieList;

        public function __construct()
        {
            $this->moviesDAO= new MoviesDAO();
            $this->movieList = array();
        }

        public function getFromAPI(){
            $moviesAPI = moviesAPI::getMoviesFromApi();
            
            foreach($moviesAPI as $key){
                $movie = new Movie($key->original_title, 120, $key->original_language, $key->overview, 
                                   $key->release_date, $key->adult, $key->poster_path);
                array_push($this->movieList, $movie);
            }
        }

        public function sendToDataBase(){
            $this->getFromAPI();
            echo '<pre>';
            
            echo '<pre>';
            foreach($this->movieList as $movie){
                try{

                    if(!$this->moviesDAO->exists($movie)){
                        $this->moviesDAO->add($movie);
                    }

                }catch(Exception $e){
                    //mostrar error
                    echo 'error';
                }
                finally{
                    require_once(VIEWS. "/home.php");
                }
            }
        }

        
    }
