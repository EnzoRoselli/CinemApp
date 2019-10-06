<?php 
namespace Controllers;
// require_once ("../Model/Cine.php");

/*-*/ 
require "../Config/Autoload.php";
Use Config\Autoload as Autoload;

Autoload::start();

    Use Model\Cine as Cine;
    Use DAO\CineRepository as daoCine;

    if($_POST){
        $name = $_POST['name'];
        $adress = $_POST['adress'];
        $capacity = $_POST['capacity'];
        $price = $_POST['price'];

        $cine = new Cine($name, $adress, $capacity, $price);
        
        $cineDao = new daoCine();
        $cineDao->add($cine);
        $cineDao->getAll();
        

    }
?>