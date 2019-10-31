<?php
namespace Controllers;

use DAO\UsersDAO as UsersDAO;
use Model\User as User;
use PHPMailer\PHPMailer\Exception;


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

        if ($this->checkNotNullParameters($user)) {            
            try
            {               
                $NewUserComprobation= $this->usersDAO->existsUserFromSignUp($user);
                if($NewUserComprobation===false)
                {

                   $this->addConfirmation($user); /** una vez que comprueba que los datos son validos redirecciona a la pantalla de log in */              
                }
                else 
                {                 
                    $this->showLoginSignup($NewUserComprobation);           
                }
            }
            catch(\Throwable $ex) {
                var_dump($ex);
               echo 'Un error ha ocurrido';
            }
        }
    }
    
    
    public function loginAction(){
         
        if (isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])) {
            $UserLogging = new User($_POST['LoginEmail'], $_POST['LoginPassword']);
            echo ($_POST['LoginEmail']);
            try{

             $LoginComprobation = $this->usersDAO->correctCredentials($UserLogging);
             if(!$LoginComprobation){
                 $LoginErrors=array();
                 array_push($LoginErrors,LOGIN_FAILURE);
                 $this->showLoginSignup($LoginErrors);
             }
             else{
              
                 $_SESSION['loggedUser'] = $LoginComprobation[0]['lastname'];
                 HomeController::showMain();
             }
            }catch(Exception $e) {
                echo "asd";   /* catchear bien esta excepcin PONER ADVICE Y AVISAR*/ 
            }
        }
    }



    public function showHome($message = array()){
        echo $message;
        HomeController::showMain();
        /*
        if ($_GET['delete']) {
            require_once(VIEWS . "/home.php"."?delete=1");
        }else {
            HomeController::Index();
        }*/
       
    }

    public function showLoginSignup($message = array()){
        require_once(VIEWS . '/loginSignup.php');
    }

    public function addConfirmation($user){

        $this->usersDAO->add($user); 
        $this->showLoginSignup(SIGNUP_SUCCESS);
    }


    private function checkNotNullParameters($user){
        if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null)
            return true;
        else
            return false;
    }
}
?>

