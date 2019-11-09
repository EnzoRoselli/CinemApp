<?php 
namespace Controllers;

use DAO\CinemasDAO as CinemasDAO;
use DAO\TheatersDAO as TheatersDAO;
use Model\Theater as Theater;

class TheatersController  
{
    private $CinemasDAO;
    private $TheatersDAO;

    public function __construct() {
        $this->CinemasDAO = new CinemasDAO();
        $this->TheatersDAO = new TheatersDAO();
    }


    public function showSortedTheatersMenu($cinema_id)
    {
        try {
            $Theaters = $this->TheatersDAO->getSortedTheatersByCineId($cinema_id); 
        } catch (\Throwable $th) {
            var_dump($th);
        } finally {
            require_once(VIEWS . "/AdminTheaters.php");
        }
    }

    public function showAllTheatersMenu()
    {
        try {
            $Theaters = $this->TheatersDAO->getAll(); 
        } catch (\Throwable $th) {
            var_dump($th);          
        } finally {
            require_once(VIEWS . "/AdminTheaters.php");
        }
    }

    public function create($idCinema,$number,$ticketValue,$capacity)
    {
        $cinema = $this->cinemasDAO->searchById($idCinema);
        $Theater = new Theater($number, $cinema,true, $ticketValue,$capacity);

        try {
            if (!$this->TheatersDAO->exists($Theater)){
                $this->TheaterDao->add($Theater);
            } else {
                $message = 1;
            }
        } catch (\Throwable $th) {
            var_dump($th);
        } finally {
            if ($message == 0) {
                echo '<script type="text/javascript">
                    alert("Función creada con éxito");
                </script>';
            } else {
                echo '<script type="text/javascript">
                    alert("La sala con ese número ya se encuentra");
                </script>';
            }
            $this->showSortedTheatersMenu($Theater->getCinema()->getId());
        }
    }

    public function modify($id,$number,$cinema_id,$active,$ticketValue,$capacity)
    {
        $cinema=$this->cinemasDAO->searchById($cinema_id);
        $Theater=new Theater($number,$cinema,$active,$ticketValue,$capacity);
        $Theater->setId($id);
        if ($this->checkNotEmptyParameters($Theater)) {
            try {
                if ($this->TheatersDAO->exists($Theater) && $Theater->getActive()) {
                    $this->TheatersDAO->modify($Theater);
                } 
            } catch (\Throwable $th) {
                var_dump($th);
            }
           
        }
    }

    public function checkNotEmptyParameters($Theater)
    {
        if (!empty($Theater->getNumber()) && !empty($Theater->getCinema()) && !empty($Theater->getActive()) && !empty($Theater->getTicketValue()) && $Theater->getTicketValue()>0 && !empty($Theater->getCapacity()) && $Theater->getCapacity()>0 ) {
            return true;
        } else {
            return false;
        }
    }


}



















?>