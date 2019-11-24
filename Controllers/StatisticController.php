<?php

namespace Controllers;

use DAO\PurchasesDAO as PurchaseDAO;
use DAO\CinemasDAO as CinemaDAO;
use DAO\MoviesDAO as MoviesDAO;


class StatisticController
{

    private $purchaseDAO;
    private $cinemaDAO;
    private $movieDAO;

    public function __construct()
    {
        $this->purchaseDAO = new PurchaseDAO();
        $this->cinemaDAO = new CinemaDAO();
        $this->movieDAO = new MoviesDAO();
    }

    public function showStats($viewDate = "", $minDate = "", $maxDate = "")
    {

        require_once(VIEWS . '/ValidateAdminSession.php');
        $statsCinemas = array();
        $statsMovies = array();
        $advices = array();

        try {

            $cinemasList = $this->cinemaDAO->getAll();
            $moviesList = $this->movieDAO->getAll();

            if (!empty($viewDate) && empty($minDate) && empty($maxDate)) {

                $statsCinemas = $this->getPurchasesByCinemaId($cinemasList);
                $statsMovies = $this->getPurchasesByViewDate($moviesList, $viewDate);

                if (empty($statsCinemas) && empty($statsMovies)) {

                    array_push($advices, NOT_FOUND_FILTERS);
                    $this->showStatistics($statsCinemas, $statsMovies, $advices);
                } else {
                    $this->showStatistics($statsCinemas, $statsMovies);
                }
            } else if (!empty($viewDate) && (!empty($minDate) && !empty($maxDate) || !empty($minDate) && empty($maxDate) || empty($minDate) && !empty($maxDate))) {

                $statsCinemas = $this->getPurchasesByCinemaId($cinemasList);
                $statsMovies = $this->getPurchasesByMovieId($moviesList);

                array_push($advices, FILTERS_ERROR);

                $this->showStatistics($statsCinemas, $statsMovies, $advices);
            } else {

                if (!empty($minDate) && !empty($maxDate)) {

                    $statsCinemas = $this->getPurchasesByCinemaId($cinemasList, $minDate, $maxDate);
                    $statsMovies = $this->getPurchasesByMovieId($moviesList, $minDate, $maxDate);

                    if (empty($statsCinemas) && empty($statsMovies)) {

                        array_push($advices, NOT_FOUND_FILTERS);
                        $this->showStatistics($statsCinemas, $statsMovies, $advices);
                    } else {
                        $this->showStatistics($statsCinemas, $statsMovies);
                    }
                } else if ((empty($minDate) && !empty($maxDate)) || (!empty($minDate) && empty($maxDate))) {

                    $statsCinemas = $this->getPurchasesByCinemaId($cinemasList);
                    $statsMovies = $this->getPurchasesByMovieId($moviesList);

                    array_push($advices, FILTERS_ERROR);

                    $this->showStatistics($statsCinemas, $statsMovies, $advices);
                } else if (empty($minDate) && empty($maxDate)) {

                    $statsCinemas = $this->getPurchasesByCinemaId($cinemasList);
                    $statsMovies = $this->getPurchasesByMovieId($moviesList);

                    $this->showStatistics($statsCinemas, $statsMovies);
                }
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
    }

    public function getPurchasesByCinemaId($cinemasList, $minDate = "", $maxDate = "")
    {

        $statsCinemas = array();

        foreach ($cinemasList as $cinema) {

            if (($cinemaPurchases = $this->purchaseDAO->getPurchasesByCinemaId($cinema->getId(), $minDate, $maxDate)) != null) {
                array_push($statsCinemas, $cinemaPurchases);
            }
        }

        return $statsCinemas;
    }

    public function getPurchasesByMovieId($moviesList, $minDate = "", $maxDate = "")
    {

        $statsMovies = array();

        foreach ($moviesList as $movie) {

            if (($moviePurchases = $this->purchaseDAO->getPurchasesByMovieId($movie->getId(), $minDate, $maxDate)) != null) {
                array_push($statsMovies, $moviePurchases);
            }
        }

        return $statsMovies;
    }

    public function getPurchasesByViewDate($moviesList, $viewDate)
    {

        $statsMovies = array();

        foreach ($moviesList as $movie) {

            if (($moviePurchases = $this->purchaseDAO->getPurchasesByViewDate($movie->getId(), $viewDate)) != null) {
                array_push($statsMovies, $moviePurchases);
            }
        }

        return $statsMovies;
    }

    public function showStatistics($statsCinemas = "", $statsMovies = "", $messages = "")
    {

        require_once(VIEWS  . '/Statistics.php');
    }
}
