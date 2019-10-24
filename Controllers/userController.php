<?php
namespace Controllers;

use DAO\UsersDAO as UsersDAO;
use Model\User as User;
use PHPMailer\PHPMailer\Exception;
use Throwable;

class UserController
{
    private $usersDAO;

    public function __construct()
    {
        $this->usersDAO = new UsersDAO();
    }

    public function createUser() /// DEBIERA SER LLAMADO POR LA VISTA DE SIGNUP
    {
        $email = $_POST['SignupEmail'];
        $password = $_POST['SignupPassword'];
        
        $user = new User($email, $password);
        $user->setName($_POST["SignupName"]);
        $user->setLastName($_POST["SignupLastName"]);
        $user->setDni($_POST["SignupDNI"]);

        if ($this->checkInputParameters($user)) {
            if($this->s()){
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

    public function showHome($message = null){
        require_once(VIEWS_PATH . "home.php");
    }

    public function showLoginView($message = null){
        require_once(VIEWS_PATH . "loginSignup.php");
    }

    public function loginAction(){

        if (isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])) {
            
            $loggingUser = new User($_POST['LoginEmail'], $_POST['LoginPassword']);
                
            try{

             $UserInfo = $this->usersDAO->existsUser($loggingUser);
             if(!$UserInfo){
                 $this->showLoginView(LOGIN_FAILURE);
             }
             else{
                 $_SESSION['loggedUser'] = $UserInfo[0]['lastName'];
                 $this->showHome();
             }
            }catch(Exception $e) {
                echo "asd";   /* catchear bien esta excepcin*/ 
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
}
?>

