<?php

namespace Controllers;

use Model\Cine as Cine;
use DAO\CinemasDAO as daoCine;


class CineController
{

    private $CineDao;
    public function __construct()
    {
        $this->CineDao = new daoCine();
    }

    public function determinateUpdateCreate()
    {
        if ($_POST) {
            if ($_POST[CINE_ID] != "") {
         
                $this->updateCinema();
            } else if ($_POST[CINE_ID] == "") {
           
                $this->createCinema();
            }
          
        }
    }

    public function createCinema()
    {

        $name = $_POST[CINE_NAME];
        $adress = $_POST[CINE_ADDRESS];
        $capacity = $_POST[CINE_CAPACITY];
        $price = $_POST[CINE_TICKETVALUE];

        $cine = new Cine($name, $adress, $capacity, $price);
        $cine->setActive(true);

        if ($cine->getName() != null && $cine->getAddress() != null && $cine->getCapacity() > 0 && $cine->getTicketValue() > 0) {

            if ($this->CineDao->add($cine)) {
              
                $advice =  CineController::showMessage(0);
                $this->showCinemaMenu();
            } else {
                $advice =  CineController::showMessage(1);
               $this->showCinemaMenu();
            }
        } else {
            $advice = CineController::showMessage(4);
            $this->showCinemaMenu(); //SIEMPRE TESTEAR SI LA VARIABLE NO ESTA VACIA EN LA VIEW, Y SINO HACERLE EL ALERT CON DE TEXTO EL &advice
        }
    }

    public function updateCinema()
    {

        $updatedId = $_POST[CINE_ID];
        $updatedName = $_POST[CINE_NAME];
        $updatedAddress = $_POST[CINE_ADDRESS];
        $updatedCapacity = $_POST[CINE_CAPACITY];
        $updatedPrice = $_POST[CINE_TICKETVALUE];
      
        if ($updatedName!=null && $updatedAddress!=null && $updatedCapacity!=null && $updatedPrice!=null) {
            
   
        $modifiedCinema = new Cine($updatedName, $updatedAddress, $updatedCapacity, $updatedPrice);
        $modifiedCinema->setId($updatedId);

        //COROBORAR TODOS LOS CAMPOS NO SEAN NULOS Y QUE LOS NUEVOS NO LOS CONTENGA OTRO CINE
        if ($this->isCapacityValid($updatedCapacity) && $this->isTicketValueValid($updatedPrice)) {

            if ($this->CineDao->modifyCine($modifiedCinema)) {
                $advice = CineController::showMessage(2);
               $this->showCinemaMenu();
            } else {

                $advice = CineController::showMessage(3);
               $this->showCinemaMenu();
            }
        } else {
            $advice = CineController::showMessage(4);
            $this->showCinemaMenu(); //SIEMPRE TESTEAR SI LA VARIABLE NO ESTA VACIA EN LA VIEW, Y SINO HACERLE EL ALERT CON DE TEXTO EL &advice
        }
    }else{
        $this->showCinemaMenu();

        $advice="Los campos no pueden ser vacíos";
    }
    }


    private function isCapacityValid($capacity)
    {

        if ($capacity <= 0) {
            return false;
        } else {
            return true;
        }
    }

    private function isTicketValueValid($price)
    {

        if ($price <= 0) {
            return false;
        } else {
            return true;
        }
    }

    public function showCinemaMenu()
    {
       

        $cines = $this->CineDao->getAll();
        if (isset($_GET['delete'])) {

            $id = $_GET['delete'];
            $this->CineDao->delete($id);
        
            $cines = $this->CineDao->getAll();
            require_once(VIEWS  . '/AdminCine.php');
        } else if (isset($_GET['update'])) {

            $cineUpdate = new Cine();
            $id = $_GET['update'];
            $cineUpdate = $this->CineDao->searchById($id);
            //Abre el pop up
            echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})                </script>";
       
            require_once(VIEWS  . "/AdminCine.php");
        } else if (isset($_GET['activate']) || isset($_GET['desactivate'])) {

            if (isset($_GET['activate'])) {
                
                $this->activateCinema($_GET['activate']);
            } else {
                $this->desactivateCinema($_GET['desactivate']);
            }
            $cines = $this->CineDao->getAll();
            require_once(VIEWS  . "/AdminCine.php");
        } else {
            $cines = $this->CineDao->getAll();
            require_once(VIEWS  . "/AdminCine.php");
        }
        require_once(VIEWS  . "/AdminCine.php");

    }

    public function delete()
    {
        $this->CineDao->delete($_GET['id']);
    }
    public function update()
    {
        var_dump($_GET);
        if ($_GET['']) {
           
        }
       $this->CineDao->modifyCine($_GET['id']);
    }

    public function activateCinema($id)
    {

        $this->CineDao->activateCinema($id);
    }

    public function desactivateCinema($id)
    {

        $this->CineDao->desactivateCinema($id);
    }

    public static function showMessage($messageNumber)
    {

        switch ($messageNumber) {
            case 0:
                return "Agregado correctamente";
                break;
            case 1:
                return "Verifique que los datos no esten repetidos";
                break;
            case 2:
                return "Modificado correctamente";
                break;
            case 3:
                return "Sin modificacion";
                break;
            case 4:
                return "La capacidad y el valor del ticket deben ser mayor a 0(cero)";

                break;

            default:


                break;
        }
    }
}
