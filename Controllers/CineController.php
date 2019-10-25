<?php

namespace Controllers;

use Model\Cine as Cine;
use DAO\CinemasDAO as daoCine;
//LA EXCEPCION QUE TIRA ES SI NO CRE BIEN LA QUERY POR PARAMETROS, NO POR EL RESULTADO DEVUELTO
//$advice , toma el valor en una funcion, pero luego en showtime no sigue con el valor.
//IDEA: CREAR UN ARRAY COMO ATRIBUTO Y QUE CADA VEZ QUE ENTRE A SHOW CINEMA, SE INICIALIZE Y QUE TOME POR PARAMETRO UN ARRAY, PUEDE ESTAR VACIO COMO NO, SE PUEDE DECLARAR
//SIEMPRE TESTEAR SI LA VARIABLE NO ESTA VACIA EN LA VIEW, Y SINO HACERLE EL ALERT CON DE TEXTO EL &advice
//MODIFICAR NOMBRES DEL DAO, SOLO MODIFY NO MODIFYMA
//($advices=array()) para los avisos
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
                $this->update();
            } else if ($_POST[CINE_ID] == "") {
                $this->create();
            }
        }
    }

    public function create()
    {

        $name = $_POST[CINE_NAME];
        $adress = $_POST[CINE_ADDRESS];
        $capacity = $_POST[CINE_CAPACITY];
        $price = $_POST[CINE_TICKETVALUE];

        $cine = new Cine($name, $adress, $capacity, $price);
        $cine->setActive(true);

        if ($cine->testValuesValidation()) {
            try {          
                if (!$this->CineDao->exists($cine)) {
                    $this->CineDao->add($cine);
                    $advice =  CineController::showMessage(0);
                    $this->showCinemaMenu();
                } else {
                    $advice =  CineController::showMessage(1);
                    $this->showCinemaMenu();
                }
             
            } catch (\Throwable $th) {
                $advice = CineController::showMessage("DB");
                $this->showCinemaMenu();
            }
        } else {
            $advice = CineController::showMessage("CamposInvalidos");
          $this->showCinemaMenu(); 
        }
    }

    public function update()
    {

        $updatedId = $_POST[CINE_ID];
        $updatedName = $_POST[CINE_NAME];
        $updatedAddress = $_POST[CINE_ADDRESS];
        $updatedCapacity = $_POST[CINE_CAPACITY];
        $updatedPrice = $_POST[CINE_TICKETVALUE];

            $modifiedCinema = new Cine($updatedName, $updatedAddress, $updatedCapacity, $updatedPrice);
            $modifiedCinema->setId($updatedId);

            if ($modifiedCinema->testValuesValidation()) {
                $cinemaToBeModified=$this->CineDao->searchById($updatedId);
                if ($cinemaToBeModified->getName()==$modifiedCinema->getName() && $cinemaToBeModified->getAddress()==$modifiedCinema->getAddress()){
                    $this->CineDao->modify($modifiedCinema);
                    $advice = CineController::showMessage(2);
                    $this->showCinemaMenu();                   
                }else {
                    if (!$this->CineDao->exists($modifiedCinema)) {
                        $this->CineDao->modify($modifiedCinema);
                        $advice = CineController::showMessage(2);
                        $this->showCinemaMenu();
                    } else {    
                        $advice = CineController::showMessage(3);
                        $this->showCinemaMenu();
                    }
                }
               
            } else {
                $advice = CineController::showMessage("CamposInvalidos");
                $this->showCinemaMenu();
            }           
        }
    



    public function showCinemaMenu()
    {
        try {       
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

            echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})                </script>";
            require_once(VIEWS  . "/AdminCine.php");
        } else if (isset($_GET['activate']) || isset($_GET['desactivate'])) {

            if (isset($_GET['activate'])) {

                $this->activate($_GET['activate']);
            } else {
                $this->desactivate($_GET['desactivate']);
            }
            $cines = $this->CineDao->getAll();
            require_once(VIEWS  . "/AdminCine.php");
        } else {
            $cines = $this->CineDao->getAll();
            require_once(VIEWS  . "/AdminCine.php");
        }
        require_once(VIEWS  . "/AdminCine.php");
    } catch (\Throwable $th) {
        $advice = CineController::showMessage("DB");
        require_once(VIEWS  . "/AdminCine.php");

    }
    }

    public function delete()
    {
        try {
        if (!empty($this->CineDao->searchById($_GET['id']))) {
            $this->CineDao->delete($_GET['id']);
            $advice=CineController::showMessage(5);
        }
    } catch (\Throwable $th) {
        $advice=CineController::showMessage("DB");
    }
}
   
    public function activate($id)
    {
        try {
            if (!empty($this->CineDao->searchById($id))) {
                $this->CineDao->activate($id);
                $advice=CineController::showMessage("activado");
            }else {
                $advice=CineController::showMessage(3);
            }
        } catch (\Throwable $th) {
            $advice=CineController::showMessage("DB");

        }
        
    }

    public function desactivate($id)
    {
        try {
             if (!empty($this->CineDao->searchById($id))) {
             $this->CineDao->desactivate($id);
             $advice=CineController::showMessage("desactivado");
                }else {
                 $advice=CineController::showMessage(3);

                }
            }catch (\Throwable $th) {
             $advice=CineController::showMessage("DB");

            }
    }

    public static function showMessage($messageNumber)
    {

        switch ($messageNumber) {
            case 0:
                return "Agregado correctamente";
                break;
            case 1:
                return "Verifique que los datos no esten repetidos";break;
            case 2:
                return "Modificado correctamente";break;
            case 3:
                return "Sin modificacion";break;
            case "CamposInvalidos":
                return "Los valores ingresados no son validos, verificar capacidad y valorTicket mayor a 0, O campos vacíos";break;
            case "DB":
                return "Error al procesar la query"; break;
                case 5:
                return "Eliminado correctamente";
                break;
                case 'activado':
                return "Se activó";
                break;
                case 'desactivado':
                return "Se activó";
                break;
            default:
                break;
        }
    }

}