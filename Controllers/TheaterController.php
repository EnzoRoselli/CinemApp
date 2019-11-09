<?php 
namespace Controllers;

use DAO\CinemasDAO as CinemasDAO;
use DAO\TheatersDAO as TheatersDAO;
use Model\Theater as Theater;

class TheaterController  
{
    private $CinemasDAO;
    private $TheatersDAO;

    public function __construct() {
        $this->CinemasDAO = new CinemasDAO();
        $this->TheatersDAO = new TheatersDAO();
    }

    public function create($idCinema, $name, $capacity, $ticketValue)
    {
        $cinema = $this->CinemasDAO->searchById($idCinema);
        $theater = new Theater($name, $cinema, true, $ticketValue, $capacity);
        try{
            $this->TheatersDAO->add($theater);
        }catch (\Throwable $th){
            var_dump($th);
        }finally{
            $this->showCinemasOnTable();
        }
    }

    public function getCinemaToAddTheater(){
        $cinema = $this->CinemasDAO->searchById($_GET['addTheater']);
        $this->openPopUp();
        $this->showCinemasOnTable(null, $cinema);
    }

    public function checkNotEmptyParameters($Theater)
    {
        if (!empty($Theater->getNumber()) && !empty($Theater->getCinema()) && !empty($Theater->getActive()) && !empty($Theater->getTicketValue()) && $Theater->getTicketValue()>0 && !empty($Theater->getCapacity()) && $Theater->getCapacity()>0 ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function openPopUp()
    {
        echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})</script>";
    }

    public function showCinemasOnTable($cineUpdate = "", $createTheater = "")
    {
        $cines = $this->CinemasDAO->getAll();
        require_once(VIEWS  . '/AdminCine.php');
    }
}



















?>