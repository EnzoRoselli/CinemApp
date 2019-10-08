<?php 

    if (isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])) {
        //Mandar los datos de los post a una query para corroborar
        //Caso que acceda
        if ($comprobationLogin) {
            header('');//A la pagina principal
        }else{
            echo "<script> if(confirm('Error al ingresar los datos, vuelva a intentarlo !'));";  
            echo "window.location = '../LoginSignup.php'; </script>";

        }
    }









?>