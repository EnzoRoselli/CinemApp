<?php 


require_once("../../Config/Autoload.php");

use Config\Autoload as Autoload;
Autoload::Start();
use Model\User as User;
use DAO\UsersDAO as UsersList;
session_start();


    if (isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])) {

    $userLoging=new User($_POST['LoginEmail'],$_POST['LoginPassword']);

    $UsersList=new UsersList();
    $UserInfo=$UsersList->ExistsLogin($newUser);
    if ($UserInfo!=false) {
        $_SESSION['loggedUser']=$UserInfo->getName();;
        echo "<script> alert('Logeo exitoso!');" ; 
    
        echo "window.location= '../../views/home.php'; </script> ";
       
    }else {
        echo "<script> alert('Los datos ingresados no concuerdan!');" ; 
        echo "window.location= '../LoginSignup.php'; </script> ";
    }
   
       
    }else {
        echo "<script> alert('Complete todos los campos!');" ; 
        echo "window.location= '../LoginSignup.php'; </script> ";
    }

?>