<?php
    namespace Controllers;

    class HomeController
    {
        public function Index($message = "")
        {
            // Proceso
            require_once(VIEWS."/header.php");
            require_once(VIEWS."/home.php");
            require_once(VIEWS."/footer.php");
        }        
    }
?>