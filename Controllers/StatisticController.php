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
        $cinemasList = $this->cinemaDAO->getAll();
        $moviesList = $this->movieDAO->getAll();

        foreach($cinemasList as $cinema){

            if(($cinemaPurchases = $this->purchaseDAO->getPurchasesByCinemaId($cinema->getId())) != null){

                array_push($statsCinemas, $cinemaPurchases);
            }
            
        }

        foreach($moviesList as $movie){

            if(($moviePurchases = $this->purchaseDAO->getPurchasesByMovieId($movie->getId())) != null){

                array_push($statsMovies, $moviePurchases);
            }
        }

         require_once(VIEWS  . '/Statistics.php');
    }
}
?>