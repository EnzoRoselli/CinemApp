<?php
namespace Controllers;
use DAO\PurchasesDAO as PurchaseDAO;
use DAO\CinemasDAO as CinemaDAO;
use DAO\MoviesDAO as MoviesDAO;


class StatisticController{

    private $purchaseDAO;
    private $cinemaDAO;
    private $movieDAO;

    public function __construct()
    {
        $this->purchaseDAO = new PurchaseDAO();
        $this->cinemaDAO = new CinemaDAO();
        $this->movieDAO = new MoviesDAO();
    }

    public function showStats($minDate="", $maxDate = ""){
        $statsCinemas = array();
        $statsMovies = array();
        $advices = array();

        try {
            
            $cinemasList = $this->cinemaDAO->getAll();
            $moviesList = $this->movieDAO->getAll();
    
            if(!empty($minDate) && !empty($maxDate)){
                
                $statsCinemas = $this->getPurchasesByCinemaId($cinemasList, $minDate, $maxDate);
                $statsMovies = $this->getPurchasesByMovieId($moviesList, $minDate, $maxDate);

    
                if(empty($statsCinemas) && empty($statsMovies)){
                    
                    array_push($advices, NOT_FOUND_FILTERS);
                    $this->showStatics($statsCinemas, $statsMovies, $advices);
                }else{
                     $this->showStatics($statsCinemas, $statsMovies);
                }
    
            }else if((empty($minDate) && !empty($maxDate)) || (!empty($minDate) && empty($maxDate))){

                $statsCinemas = $this->getPurchasesByCinemaId($cinemasList);
                $statsMovies = $this->getPurchasesByMovieId($moviesList);

                array_push($advices, FILTERS_ERROR);

                $this->showStatics($statsCinemas, $statsMovies, $advices);

            }else if(empty($minDate) && empty($maxDate)){

                $statsCinemas = $this->getPurchasesByCinemaId($cinemasList);
                $statsMovies = $this->getPurchasesByMovieId($moviesList);

                $this->showStatics($statsCinemas, $statsMovies);
            }


        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }

          
    }

    public function getPurchasesByCinemaId($cinemasList, $minDate = "", $maxDate = ""){

        $statsCinemas = array();

        foreach($cinemasList as $cinema){
        
            if(($cinemaPurchases = $this->purchaseDAO->getPurchasesByCinemaId($cinema->getId(), $minDate, $maxDate)) != null){

                array_push($statsCinemas, $cinemaPurchases);
            }
            
        }

        return $statsCinemas;
    }

    public function getPurchasesByMovieId($moviesList, $minDate = "", $maxDate = ""){

        $statsMovies = array();

        foreach($moviesList as $movie){
        
            if(($moviePurchases = $this->purchaseDAO->getPurchasesByMovieId($movie->getId(), $minDate, $maxDate)) != null){

                array_push($statsMovies, $moviePurchases);
            }
        }

        return $statsMovies;
    }

    public function showStatics($statsCinemas = "", $statsMovies = "", $messages = ""){

        require_once(VIEWS  . '/Statistics.php');
    }
}
?>