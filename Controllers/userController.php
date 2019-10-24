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

    public function createUser()
    {
        $email = $_POST['SignupEmail'];
        $password = $_POST['SignupPassword'];
        
        $user = new User($email, $password);
        $user->setName($_POST["SignupName"]);
        $user->setLastName($_POST["SignupLastName"]);
        $user->setDni($_POST["SignupDNI"]);

        if ($this->checkInputParameters($user)) {
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


    /*  -- CREAR METODO QUE CHEQUEE EN BD QUE NO EXISTA EL DNI Y MAIL INGRESADOS  checkRegisterData
        -- ARMAR EL showLoginSignupMenu
    */ 

    private function checkInputParameters($user){
        if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null)
            return true;
        else
            return false;
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

            case 4:
                return "El usuario que intenta registrar ya se encuentra en nuestra base de datos";
                break;

            default:


                break;
        }
    }
}
?>

