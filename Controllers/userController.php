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

        if ($this->checkNotNullParameters($user)) {            
            try
            {
                $UserDNI = $this->usersDAO->existsDNI($user);
                if($UserDNI)
                {
                    $UserEmail = $this->usersDAO->existsEmail($user);
                    if($UserEmail)
                    {
                        $this->addConfirmation($user); /** una vez que comprueba que los datos son validos redirecciona a la pantalla de log in */
                    }
                    else
                    {
                        $this->showLoginSignupView(EMAIL_EXISTS);    
                    }
                }
                else 
                {
                    $this->showLoginSignupView(ID_NUMBER_EXISTS);
                }
            }
            catch(\Throwable $ex) {
               echo 'Un error ha ocurrido';
            }
        }
    }
    
    
    public function loginAction(){

        if (isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])) {
            
            $loggingUser = new User($_POST['LoginEmail'], $_POST['LoginPassword']);
                
            try{

             $UserDNI = $this->usersDAO->correctCredentials($loggingUser);
             if(!$UserDNI){
                 $this->showLoginSignupView(LOGIN_FAILURE);
             }
             else{
                 $_SESSION['loggedUser'] = $UserDNI[0]['lastName'];
                 $this->showHome();
             }
            }catch(Exception $e) {
                echo "asd";   /* catchear bien esta excepcin*/ 
            }
        }
    }



    public function showHome($message = null){
        require_once(VIEWS_PATH . "home.php");
    }

    public function showLoginSignupView($message = null){
        require_once(VIEWS_PATH . "loginSignup.php");
    }

    public function addConfirmation($user){

        $this->usersDAO->add($user); 
        $this->showLoginSignupView(SIGNUP_SUCCESS);
    }


    private function checkNotNullParameters($user){
        if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null)
            return true;
        else
            return false;
    }
}
?>

