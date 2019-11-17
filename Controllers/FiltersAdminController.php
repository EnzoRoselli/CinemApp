<?php

namespace Controllers;

use Model\CinemaPurchases;
use Controllers\PurchaseController as PurchaseController;
use DAO\CinemasDAO;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\GenresDAO as GenresDAO;
use DAO\GenresXMoviesDAO as GenresXMoviesDAO;
use DAO\PurchasesDAO;

class FiltersAdminController
{

    private $cinemaDAO;
    private $purchaseDAO;
    private $showtimeDao;
    private $MoviesDAO;
    private $genreDAO;
    private $genresXmoviesDAO;
    private $showtimeController;
    private $purchaseController;

    public function __construct()
    {
        $this->cinemaDAO = new CinemasDAO();
        $this->purchaseDAO = new PurchasesDAO();
        $this->showtimeDao = new ShowtimeDAO();
        $this->genreDAO = new GenresDAO();
        $this->MoviesDAO = new MoviesDAO();
        $this->genresXmoviesDAO = new GenresXMoviesDAO();
        $this->showtimeController = new ShowtimeController();
        $this->purchaseController = new PurchaseController();
    }

    public function showPurchaseStatistics()
    {
        $advices = array();
        $cinemasPurchases = array();
        $moviesPurchases = array();

        try{

            $cinemasPurchases = $this->getCinemasPurchases();
            $moviesPurchases = $this->getMoviesPurchases();

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }finally{

            $this->showtimeController->showShowtimesListUser($cinemasPurchases, $moviesPurchases);
        }
    }

    public function getCinemasPurchases()
    {
        $advices = array();
        $cinemasPurchasesList = array();

        try {
            $cinemas = $this->cinemaDAO->getAll();

            foreach ($cinemas as $cinema) {
                
                $cinemaPurchases = $this->purchaseDAO->getPurchasesByCinemaId($cinema->getId());

                if(!empty($cinemaPurchases)){

                    array_push($cinemasPurchasesList, $cinemaPurchases);
                }

            }

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } 

        return $cinemasPurchasesList;
    }

    public function getMoviesPurchases()
    {
        $advices = array();
        $moviesPurchasesList = array();

        try {
            $movies = $this->MoviesDAO->getAll();

            foreach ($movies as $movie) {
                
                $moviePurchases = $this->purchaseDAO->getPurchasesByMovieId($movie->getId());

                if(!empty($moviePurchases)){

                    array_push($moviesPurchasesList, $moviePurchases);
                }

            }

        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } 

        return $moviesPurchasesList;
    }


}
