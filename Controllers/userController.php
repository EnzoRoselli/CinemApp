<?php
namespace Controllers;

use DAO\UsersDAO as UsersDAO;
use Model\User as User;
use Throwable;

class UserController
{

    private $usersDAO;
    public function __construct()
    {
        $this->usersDAO = new UsersDAO();
    }

    public function determinateUpdateCreate()
    {
        if ($_POST) {
            if ($_POST[CINE_ID] != "") {
         
                $this->updateCinema();
            } else if ($_POST[CINE_ID] == "") {
           
                $this->createCinema();
            }
          
        }
    }

    public function createUser()
    {

        $email = $_POST['SignupEmail'];
        $password = $_POST['SignupPassword'];
        
        $user = new User($email, $password);
        $user->setName($_POST["SignupName"]);
        $user->setLastName($_POST["SignupLastName"]);
        $user->setDni($_POST["SignupDNI"]);

        if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null) {
            if($this->checkRegisterData()){
                try{
                    $this->usersDAO->add($user); 
                    $advice =  UserController::showMessage(0);
                }catch (\Throwable $ex) {
                    $advice =  UserController::showMessage(1);
                }
                finally{ $this->showLoginSignupMenu();
                }
            }
            else{
                $advice =  UserController::showMessage(4);
                require_once (VIEWS . "/LoginSignUp.php");
            }

            }
        }


    /*  -- CREAR METODO QUE CHEQUEE EN BD QUE NO EXISTA EL DNI Y MAIL INGRESADOS
        -- ARMAR EL showLoginSignupMenu
    */ 

    private function isCapacityValid($capacity)
    {

        if ($capacity <= 0) {
            return false;
        } else {
            return true;
        }
    }

    private function isTicketValueValid($price)
    {

        if ($price <= 0) {
            return false;
        } else {
            return true;
        }
    }

    public function showCinemaMenu()
    {
       

        $cines = $this->usersDAO->getAll();
        if (isset($_GET['delete'])) {

            $id = $_GET['delete'];
            $this->usersDAO->delete($id);
        
            $cines = $this->usersDAO->getAll();
            require_once(VIEWS  . '/AdminCine.php');
        } else if (isset($_GET['update'])) {

            $cineUpdate = new Cine();
            $id = $_GET['update'];
            $cineUpdate = $this->usersDAO->searchById($id);
            //Abre el pop up
            echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})                </script>";
       
            require_once(VIEWS  . "/AdminCine.php");
        } else if (isset($_GET['activate']) || isset($_GET['desactivate'])) {

            if (isset($_GET['activate'])) {
                
                $this->activateCinema($_GET['activate']);
            } else {
                $this->desactivateCinema($_GET['desactivate']);
            }
            $cines = $this->usersDAO->getAll();
            require_once(VIEWS  . "/AdminCine.php");
        } else {
            $cines = $this->usersDAO->getAll();
            require_once(VIEWS  . "/AdminCine.php");
        }
        require_once(VIEWS  . "/AdminCine.php");

    }

    public function delete()
    {
        $this->usersDAO->delete($_GET['id']);
    }
    public function update()
    {
        var_dump($_GET);
        if ($_GET['']) {
           
        }
       $this->usersDAO->modifyCine($_GET['id']);
    }

    public function activateCinema($id)
    {

        $this->usersDAO->activateCinema($id);
    }

    public function desactivateCinema($id)
    {

        $this->usersDAO->desactivateCinema($id);
    }

    public static function showMessage($messageNumber)
    {

        switch ($messageNumber) {
            case 0:
                return "Agregado correctamente";
                break;
            case 1:
                return "Verifique que los datos no esten repetidos";
                break;
            case 2:
                return "Modificado correctamente";
                break;
            case 3:
                return "Sin modificacion";
                break;
            
            default:


                break;
        }
    }
}
?>

