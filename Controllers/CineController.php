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

    public function getCinemaToUpdate($cineId)
    {
        $cineUpdate = $this->CineDao->searchById($cineId);
        $this->showCinemasOnTable($cineUpdate, null, null, true);
    }

    public function createCinema()
    {
        $this->showCinemasOnTable(null, null, null, true);
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

        $this->showCinemasOnTable(null, null, $advices, null);
    }

    public function getCinemaToaddTheater($cineId){
        
        $cinema = $this->CineDao->searchById($cineId);
        $this->showCinemasOnTable(null, $cinema, null, true);
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
        $this->showCinemasOnTable(null, null, $advices);
    }

    public function delete($cineId)
    {
        $advices = array();
        try {
            $this->CineDao->delete($cineId);
            array_push($advices, DELETED);
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
        $this->showCinemasOnTable(null, null, $advices);
    }

    public function activate($cineId)
    {
        $advices = array();
        try {
            $this->CineDao->activate($cineId);
            $this->theaterDao->activate($cineId);
            array_push($advices, ACTIVATED);
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
        $this->showCinemasOnTable(null, null, $advices);
    }

    public function desactivate($cineId)
    {
        $advices = array();
        try {
            $this->CineDao->desactivate($cineId);
            $this->theaterDao->desactivate($cineId);
            array_push($advices, DEACTIVATED);
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }
        $this->showCinemasOnTable(null, null, $advices);
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
        @param createTheater: cine en el que se quiere agregar una sala
        @messages: mensajes en formato de un unico a array para mostrar en un alerta
        @openPopUp: en caso de que se quiera abrir el pop-up
    */
    public function showCinemasOnTable($cineUpdate = "", $createTheater = "", $messages="", $openPopUp=false)
    {
        $cines = $this->CineDao->getAll();
        require_once(VIEWS  . '/AdminCine.php');
    }

    public function showCinemasUser(){
        $cinemas = $this->CineDao->getAll();
        require_once(VIEWS  . '/Cinemas.php');
    }
}
