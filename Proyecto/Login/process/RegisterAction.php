<?php



    if (isset($_POST['SignupName']) && isset($_POST['SignupEmail']) && isset($_POST['SignupPassword'])){
        //Testeamos que no se encuentre en la base de datos; Hacer la query
        $newUser=new User($_POST['SignupName'],$_POST['SingupEmail'],$_POST['SignupPassword']);

    }



?>