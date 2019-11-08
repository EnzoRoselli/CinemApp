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
                    alert("El cine ingresado o el horario son erróneos");
                </script>';
            }
            $this->showTheaterMenu();
        }
    }


}



















?>