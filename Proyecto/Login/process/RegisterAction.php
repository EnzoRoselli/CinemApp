<?php

require_once("../../config/autoload.php");

use config\autoload as Autoload;
Autoload::Start();
use Model\User as User;
use DAO\UsersDAO as UsersList;



    if (isset($_POST['SignupEmail']) && isset($_POST['SignupPassword'])){
        $UsersList=new UsersList();
        $newUser=new User($_POST['SignupEmail'],$_POST['SignupPassword']);     
        
        if ( $UsersList->Exists($newUser)) {
            echo "<script> alert('El usuario que intenta registrar ya se encuentra!');" ; 
            echo "window.location= '../LoginSignup.php'; </script> ";
        }else {
            $UsersList->add($newUser);
            echo "<script> alert('Se creó el usuario correctamente!');" ; 
            echo "window.location= '../LoginSignup.php'; </script> ";
        }
          

    }else {
        echo "<script> alert('Ingrese todos los campos para registrarse!');" ; 
        echo "window.location= '../LoginSignup.php'; </script> ";
    }
