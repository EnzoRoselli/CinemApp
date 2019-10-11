<?php 
namespace Controllers;
// require_once ("../Model/Cine.php");

/*-*/ 
require_once("../Config/Autoload.php");
Use Config\Autoload as Autoload;
include ('../Config/Constants/CineConstants.php');

Autoload::start();

    Use Model\Cine as Cine;
    Use DAO\CineRepository as daoCine;

    if($_POST){

        $cineDao = new daoCine();

        if($_POST[CINE_ID] !== ""){

            $idUpdate=$_POST[CINE_ID];
            $nameUpdate=$_POST[CINE_NAME];
            $adressUpdate=$_POST[CINE_ADRESS];
            $capacityUpdate=$_POST[CINE_CAPACITY];
            $priceUpdate=$_POST[CINE_TICKETVALUE];

            $cine = new Cine($nameUpdate,$adressUpdate,$capacityUpdate,$priceUpdate);
            $cine->setId($idUpdate);
            
            if($cineDao->modifyCine($cine)){

                echo "<script> if(confirm('Modificado correctamente'));";
                echo "window.location ='../Views/AdminCine.php'; </script>";
            }else{
                echo "<script> if(confirm('Error al modificar los datos'));";
                echo "window.location ='../Views/AdminCine.php'; </script>";
            }

        }else if($_POST[CINE_ID] == ""){

            if(isset($_POST[CINE_NAME])){

                $name = $_POST[CINE_NAME];
                $adress = $_POST[CINE_ADRESS];
                $capacity = $_POST[CINE_CAPACITY];
                $price = $_POST[CINE_TICKETVALUE];
        
                $cine = new Cine($name, $adress, $capacity, $price);
                
                if($cineDao->add($cine)){

                    echo "<script> if(confirm('Agregado correctamente'));";
                    echo "window.location ='../Views/AdminCine.php'; </script>";
                }else{
                    echo "<script> if(confirm('Verifique que los datos no esten repetidos'));";
                    echo "window.location ='../Views/AdminCine.php'; </script>";
                }
            }
        }
    }
?>