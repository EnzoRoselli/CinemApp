<?php

namespace Controllers;

use Model\Cine as Cine;
use Model\Theater as Theater;
use DAO\CinemasDAO as daoCine;
use DAO\TheatersDAO as theaterDAO;


class CineController
{

    private $CineDao;
    public function __construct()
    {
        $this->CineDao = new daoCine();
        $this->theaterDao = new theaterDAO();

    }

    public function getCinemaToUpdate()
    {

        $cineUpdate = $this->CineDao->searchById($_GET['update']);
        $this->openPopUp();
        $this->showCinemasOnTable($cineUpdate, null);
    }

    public function createCinema()
    {
        $this->openPopUp();
        $this->showCinemasOnTable(null, null);
    }

    public function openPopUp()
    {
        echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})</script>";
    }

    public function determinateUpdateCreate($id, $name, $address)
    {

        if ($id != "") {
            $this->update($id, $name, $address);
        } else if ($id == "") {
            $this->create($name, $address);
        }
    }

    public function create($name, $address)
    {

        $advices = array();
        $cine = new Cine($name, $address);
        $cine->setActive(true);

        if ($this->checkNotEmptyParameters($cine)) {
            try {
                if (!$this->CineDao->exists($cine)) {
                    $this->CineDao->add($cine);
                    array_push($advices, ADDED);
                } else {
                    array_push($advices, EXISTS);
                }
            } catch (\Throwable $th) {
                array_push($advices, DB_ERROR);
            }
        } else {
            array_push($advices, CAMPOS_INVALIDOS);
        }

        $this->showCinemasOnTable();
    }

    public function getCinemaToaddTheater(){
        $cinema = $this->CineDao->searchById($_GET['addTheater']);
        $this->openPopUp();
        $this->showCinemasOnTable(null, $cinema);
    }

    public function addTheater($idCinema, $name, $capacity, $ticketValue){
        $cinema = $this->CineDao->searchById($idCinema);
        $theater = new Theater($name, $cinema, true, $ticketValue, $capacity);
        
    }

    public function update($id, $name, $address)
    {
        $cinemaToModify = new Cine($name, $address);
        $cinemaToModify->setId($id);
        $advices = array();
        
        if ($this->checkNotEmptyParameters($cinemaToModify)) { //Si los campos son correctos
            try {
                $cinemaPreModification = $this->CineDao->searchById($id);
                //Para comparar el nombre y dirección del cine antes de la modificación

                if (
                    $cinemaPreModification->getName() == $cinemaToModify->getName()
                    && $cinemaPreModification->getAddress() == $cinemaToModify->getAddress()
                ) {
                    array_push($advices, SIN_MODIFICACION);
                } else {
                    //CORROBORAMOS QUE EL NUEVO NOMBRE / ADDRESS NO LO CONTENGA OTRO CINE
                    if ($this->CineDao->exists($cinemaToModify)) {
                        array_push($advices, SIN_MODIFICACION);
                    } else {
                        $this->CineDao->modify($cinemaToModify);
                        array_push($advices, MODIFIED);
                    }
                }
            } catch (\Throwable $th) {
                array_push($advices, DB_ERROR);
            }
        } else {
            array_push($advices, CAMPOS_INVALIDOS);
        }
        $this->showCinemasOnTable();
    }

    /* public function showAdminCine($message = array())
    {
        require_once(VIEWS  . '/AdminCine.php');
    }*/

    public function delete()
    {
        $id = $_GET['delete'];
        try {
            $this->CineDao->delete($id);
            
        } catch (\Throwable $th) {
            throw $th;
        }
        $this->showCinemasOnTable();
    }

    public function activate()
    {
        $id = $_GET['activate'];
        try {
            $this->CineDao->activate($id);
            $this->theaterDao->activate($id);
            echo '<script type="text/javascript">
            alert("La operación se ha realizado con éxito");
       </script>'; 
        } catch (\Throwable $th) {
            throw $th;
        }
        $this->showCinemasOnTable();
    }

    public function desactivate()
    {
        $id = $_GET['desactivate'];
        try {
            $this->CineDao->desactivate($id);
            $this->theaterDao->desactivate($id);
            echo '<script type="text/javascript">
                 alert("La operación se ha realizado con éxito");
            </script>'; 
        } catch (\Throwable $th) {
            throw $th;
        }
        $this->showCinemasOnTable();
    }

    public function checkNotEmptyParameters($cine)
    {
        if (!empty($cine->getName()) && !empty($cine->getAddress())) {
            return true;
        } else {
            return false;
        }
    }


    /*
        @param cineUpdate: en caso de que se quiera abrir el pop-up para modificar 
                           llena los campos para su modificación
    */
    public function showCinemasOnTable($cineUpdate = "", $createTheater = "")
    {
        $cines = $this->CineDao->getAll();
        require_once(VIEWS  . '/AdminCine.php');
    }
}
