<?php 
namespace Controllers;

use DAO\CinemasDAO as CinemasDAO;
use DAO\TheatersDAO as TheatersDAO;
use Model\Theater as Theater;
use Controllers\CineController as CineController;

class TheaterController  
{
    private $CinemasDAO;
    private $TheatersDAO;
    private $cineController;
    public function __construct() {
        $this->CinemasDAO = new CinemasDAO();
        $this->TheatersDAO = new TheatersDAO();
        $this->cineController = new CineController();
    }

    public function create($idCinema, $name, $capacity, $ticketValue)
    {
        $advices = array();
        $cinema = $this->CinemasDAO->searchById($idCinema);
        $theater = new Theater($name, $cinema, true, $ticketValue, $capacity);
        try{
            if (!empty($this->checkNotEmptyParameters($theater)) && !$this->TheatersDAO->exists($theater)) {
                $this->TheatersDAO->add($theater);
                array_push($advices, ADDED);
            } else {
                array_push($advices, EXISTS);
            }
        }catch (\Throwable $th){
            array_push($advices, DB_ERROR);
        }finally{
            $this->cineController->showCinemasOnTable(null, null, $advices);
        }
    }

    public function getCinemaToAddTheater($cineId){
        $cinema = $this->CinemasDAO->searchById($cineId);
        $this->cineController->showCinemasOnTable(null, $cinema, null, true);
    }

    public function checkNotEmptyParameters($Theater)
    {
        if (!empty($Theater->getName()) && !empty($Theater->getCinema()) && !empty($Theater->getActive()) && !empty($Theater->getTicketValue()) && $Theater->getTicketValue()>0 && !empty($Theater->getCapacity()) && $Theater->getCapacity()>0 ) {
            return true;
        } else {
            return false;
        }
    }

}



















?>