<?php 
namespace Controllers;
// require_once ("../Model/Cine.php");


require_once ("../Config/Autoload.php");

    Use Model\Cine as Cine;
    Use DAO\CineRepository as daoCine;

    if($_POST){
        $name = $_POST['name'];
        $adress = $_POST['adress'];
        $capacity = $_POST['capacity'];
        $price = $_POST['price'];

        $cine = new Cine($name, $adress, $capacity, $price);
        
        var_dump($cine);
        
        $cineDao = new daoCine();
        $cineDao->add($cine);
        echo "---------------------SOY getALL------------------------------------------------------<br>";
        $cineDao->getAll();
        

    }
?>