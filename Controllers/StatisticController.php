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
        $this->movieDAO = new CinemaDAO();
    }

    public function showStats(){
        $statsCinemas = array();
        $statsMovies = array();
        $cinemasList = $this->cinemaDAO->getAll();
        $moviesList = $this->movieDAO->getAll();

        foreach($cinemasList as $cinema){
            
            array_push($statsCinemas, $this->purchaseDAO->getPurchasesByCinemaId($cinema->getId()));
        }

        foreach($moviesList as $movie){
            array_push($statsMovies, $this->purchaseDAO->getPurchasesByMovieId($movie->getId()));
        }
         echo '<pre>';
          var_dump($statsCinemas);
        // var_dump($statsMovies);

        require_once(VIEWS  . '/Statistics.php');
    }
}
?>