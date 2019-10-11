<?php 


require_once("../config/autoload.php");

use config\autoload as Autoload;
Autoload::Start();
use Model\User as User;
use DAO\UsersDAO as UsersList;
session_start();
$UsersList=new UsersList();


    if (isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])) {
    $userLoging=new User($_POST['LoginEmail'],$_POST['LoginPassword']);//HACERLO IF LO DE ABAJO!! Y PONERLE EL SCRIPT AL SEGUNDO ARGUMENTO
    $UsersList->Exists($userLoging) ?  header('../../views/AdminCine.php') : array_push($_SESSION['LoginErrors'],'Los datos ingresaos no coinciden') ;
       
    }

?>