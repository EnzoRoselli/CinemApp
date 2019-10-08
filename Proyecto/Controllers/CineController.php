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
        $name = $_POST[CINE_NAME];
        $adress = $_POST[CINE_ADRESS];
        $capacity = $_POST[CINE_CAPACITY];
        $price = $_POST[CINE_TICKETVALUE];

        $cine = new Cine($name, $adress, $capacity, $price);
        
        $cineDao = new daoCine();
        $cineDao->add($cine);
        $cineDao->getAll();
        

    }
?>