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

        if(isset($_POST[CINE_NAME])){

            $name = $_POST[CINE_NAME];
            $adress = $_POST[CINE_ADRESS];
            $capacity = $_POST[CINE_CAPACITY];
            $price = $_POST[CINE_TICKETVALUE];
    
            $cine = new Cine($name, $adress, $capacity, $price);
            
            $cineDao->add($cine);
            $cineDao->getAll();
        }
        
        if(isset($_POST[CINE_NAME . "update"])){

            $id=$_GET['update'];

            $nameUpdate=$_POST[CINE_NAME . "update"];

            $cine = new Cine($nameUpdate);
            $cine->setId($id);

            $cineDao->modifyCine($cine);

        }
    }
?>