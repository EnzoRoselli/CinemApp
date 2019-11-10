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
            if (!empty($this->checkNotEmptyParameters($theater)) && !$this->TheatersDAO->exists($theater)) {
                $this->TheatersDAO->add($theater);
            } else {
                //Intenta crear una sala con un nombre que ya otra sala contiene
            }
        }catch (\Throwable $th){
            //Poner aviso de que la sala no se puede agregar porque el nombre estaria duplicado
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
        if (!empty($Theater->getName()) && !empty($Theater->getCinema()) && !empty($Theater->getActive()) && !empty($Theater->getTicketValue()) && $Theater->getTicketValue()>0 && !empty($Theater->getCapacity()) && $Theater->getCapacity()>0 ) {
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