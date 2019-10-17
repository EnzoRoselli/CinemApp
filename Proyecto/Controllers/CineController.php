<?php 
namespace Controllers;

Use Model\Cine as Cine;
Use DAO\CineRepository as daoCine;

    
// if($_POST){

//     $cineController=new CineController();

//     if($_POST[CINE_ID] !== ""){

//         $cineController->updateCinema();

//     }else if($_POST[CINE_ID] == ""){

//         $cineController->createCinema();
//     }
// }

class CineController{

    private $cineRepository;

    public function __construct()
    {
        $this->cineRepository = new daoCine();
    }

    public function createCinema(){
        
        $name = $_POST[CINE_NAME];
        $adress = $_POST[CINE_ADRESS];
        $capacity = $_POST[CINE_CAPACITY];
        $price = $_POST[CINE_TICKETVALUE];
        
        $cine = new Cine($name, $adress, $capacity, $price);

        if(isCapacityValid($capacity) && isTicketValueValid($price)){

            if($this->cineRepository->add($cine)){
    
                CineController::showMessage(0);
                require_once('../Views/AdminCine.php');
            }else{
                CineController::showMessage(1);
                require_once('../Views/AdminCine.php');
            }

        }else if(!isCapacityValid($capacity) && isTicketValueValid($price)){

            CineController::showMessage(4);
            require_once('../Views/AdminCine.php');

        }else if(isCapacityValid($capacity) && !isTicketValueValid($price)){

            CineController::showMessage(5);
            require_once('../Views/AdminCine.php');

        }else if(!isCapacityValid($capacity) && !isTicketValueValid($price)){

            CineController::showMessage(6);
            require_once('../Views/AdminCine.php');
        }
        
        
    }

    public function updateCinema(){

        $updatedId=$_POST[CINE_ID];
        $updatedName=$_POST[CINE_NAME];
        $updatedAdress=$_POST[CINE_ADRESS];
        $updatedCapacity=$_POST[CINE_CAPACITY];
        $updatedPrice=$_POST[CINE_TICKETVALUE];

        $modifiedCinema = new Cine($updatedName,$updatedAdress,$updatedCapacity,$updatedPrice);
        $modifiedCinema->setId($updatedId);

        if(isCapacityValid($updatedCapacity) && isTicketValueValid($updatedPrice)){

            if($this->cineRepository->modifyCine($modifiedCinema)){
    
                CineController::showMessage(2);
                require_once('../Views/AdminCine.php');
            }else{
                CineController::showMessage(3);
                require_once('../Views/AdminCine.php');
            }

        }else if(!isCapacityValid($updatedCapacity) && isTicketValueValid($updatedPrice)){

            CineController::showMessage(4);
            require_once('../Views/AdminCine.php');

        }else if(isCapacityValid($updatedCapacity) && !isTicketValueValid($updatedPrice)){

            CineController::showMessage(5);
            require_once('../Views/AdminCine.php');

        }else if(!isCapacityValid($updatedCapacity) && !isTicketValueValid($updatedPrice)){

            CineController::showMessage(6);
            require_once('../Views/AdminCine.php');
        }
    }

    private function isCapacityValid($capacity){

        if($capacity <= 0){
            return 0;
        }else{
            return 1;
        }
    }

    private function isTicketValueValid($price){

        if($price <= 0){
            return 0;
        }else{
            return 1;
        }
    }

    public static function showMessage($messageNumber){

        switch ($messageNumber) {
            case 0:
                echo "<script> if(confirm('Agregado correctamente'));</script>";
                break;
            case 1:
                 echo "<script> if(confirm('Verifique que los datos no esten repetidos'));</script>";
                break;
            case 2:
                echo "<script> if(confirm('Modificado correctamente'));</script>";      
                break;
            case 3:
                echo "<script> if(confirm('Error al modificar los datos'));</script>";
                break;
            case 4:
                echo "<script> if(confirm('La capacidad debe ser mayor a 0'));</script>";
                break;
            case 5:
                echo "<script> if(confirm('El valor del ticket debe ser mayor a 0'));</script>";
                break;
            case 6:
                echo "<script> if(confirm('La capacidad y el valor del ticket deben ser mayor a 0'));</script>";
                break;
            default:
                # code...
                break;
        }
    }

}


?>