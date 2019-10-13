<?php 
namespace Controllers;

require_once("../Config/Autoload.php");
include ('../Config/Constants/CineConstants.php');

Use Config\Autoload as Autoload;
Use Model\Cine as Cine;
Use DAO\CineRepository as daoCine;

Autoload::start();

    
if($_POST){

    $cineController=new CineController();

    if($_POST[CINE_ID] !== ""){

        $cineController->updateCinema();

    }else if($_POST[CINE_ID] == ""){

        $cineController->createCinema();
    }
}

class CineController{

    private $cineRepository;

    public function __construct()
    {
        $this->cineRepository = new daoCine();
    }

    public function updateCinema(){

        $updatedId=$_POST[CINE_ID];
        $updatedName=$_POST[CINE_NAME];
        $updatedAdress=$_POST[CINE_ADRESS];
        $updatedCapacity=$_POST[CINE_CAPACITY];
        $updatedPrice=$_POST[CINE_TICKETVALUE];

        $modifiedCinema = new Cine($updatedName,$updatedAdress,$updatedCapacity,$updatedPrice);
        $modifiedCinema->setId($updatedId);

        if($this->cineRepository->modifyCine($modifiedCinema)){

            echo "<script> if(confirm('Modificado correctamente'));";
            echo "window.location ='../Views/AdminCine.php'; </script>";
        }else{
            echo "<script> if(confirm('Error al modificar los datos'));";
            echo "window.location ='../Views/AdminCine.php'; </script>";
        }
    }

    public function createCinema(){
        

        $name = $_POST[CINE_NAME];
        $adress = $_POST[CINE_ADRESS];
        $capacity = $_POST[CINE_CAPACITY];
        $price = $_POST[CINE_TICKETVALUE];

        $cine = new Cine($name, $adress, $capacity, $price);
        
        if($this->cineRepository->add($cine)){

            echo "<script> if(confirm('Agregado correctamente'));";
            echo "window.location ='../Views/AdminCine.php'; </script>";
        }else{
            echo "<script> if(confirm('Verifique que los datos no esten repetidos'));";
            echo "window.location ='../Views/AdminCine.php'; </script>";
        }
    }
}


?>