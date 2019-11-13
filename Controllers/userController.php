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
        $email = filter_var($_POST['SignupEmail'],FILTER_SANITIZE_EMAIL);
        $password = $_POST['SignupPassword'];
        
        $user = new User($email, $password);
        $user->setName($_POST["SignupName"]);
        $user->setLastName($_POST["SignupLastName"]);
        $user->setDni($_POST["SignupDNI"]);
     
        if ($this->checkNotNullParameters($user)) { 
            if($this->validateEmail($email)){                      
            try
            {               
                $NewUserComprobation= $this->usersDAO->existsUserFromSignUp($user);
                if($NewUserComprobation===false)
                {
                   $this->addConfirmation($user); /** una vez que comprueba que los datos son validos redirecciona a la pantalla de log in */ 

                }
                else 
                {    
                    $this->ShowMessage(SIGNUP_FAILURE);       
                    $this->showLoginSignup();           
                }
            }
            catch(\Throwable $ex) {
                var_dump($ex);
               echo 'Un error ha ocurrido';
            }
        }else 
        {
            echo 'dominio invalidoooo';
        }
            # code...
        
        }
        else{
                $this->ShowMessage(INCOMPLETE_INPUTS);      
                $this->showLoginSignup();
        }
    }
    


  /*  public function checkPostSet()
    {
        if (isset($_POST['SignupEmail'], $_POST['SignupPassword'], $_POST['SignupName'], $_POST['SignupLastName'], $_POST['SignupDNI'])){
            return true;
        }
    }*/


    public function loginAction(){
         
        if (isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])) {
            $UserLogging = new User($_POST['LoginEmail'], $_POST['LoginPassword']);

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
                echo "Ha ocurrido un error, por favor intentelo nuevamente";   /* catchear bien esta excepcin PONER ADVICE Y AVISAR*/ 
            }
        }
    }

    public function logoutAction(){
        session_destroy();
        $this->ShowMessage(LOGOUT_SUCCESS);
        session_start();
        HomeController::showMain();
    }


    public function showLoginSignup($message = array()){
        require_once(VIEWS . '/loginSignup.php');
    }

    public function addConfirmation($user){

        $this->usersDAO->add($user); 
        $this->ShowMessage(SIGNUP_SUCCESS);
        $this->showLoginSignup();
    }


    private function checkNotNullParameters($user){
        if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null){
            $this->checkInputFormat($user);
            return true;
        }
        else{
            return false;
        }
    }

    /*CHEQUEA que los nombres no contengan numeros y que los DNI sean solo numeros, sin espacios*/
    public function checkInputFormat($user)
    {
        if($this->checkNameFormat($user->getName()) && $this->checkNameFormat($user->getLastName()) && ctype_digit($user->getDni()) )
            return true;
        else {
            return false;
        }
    }

    /* CHEQUEA QUE EL ARRAY PASADO CONTENGA SOLO LETRAS */
    public function checkNameFormat($name)
    {   
        $name = domain_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            return true;
        }
        else {
            return false;
        }
    }

    /* CHEQUEA QUE EL DOMINIO DEL EMAIL PASADO SE ENCUENTRE ENTRE LOS CONSIDERADOS VALIDOS */
    
    function validateEmail($email){
 
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $splittedEmail = explode("@",$email);
        $domain = array_pop($splittedEmail);
        $validDomains = array('hotmail.com','hotmail.com.ar', 'gmail.com','outlook.com', 'yahoo.com', 'yahoo.com.ar');

        if(in_array($domain, $validDomains)){
        return true;
        }else{
            return false; ///NO EXISTE EL DOMINIO     
        } 
        }else{
            return false; // FORMATO INVALIDO
        }
 }


    public function ShowMessage($message)
    {
        echo '<script type="text/javascript">
        alert('. $message .');
        </script>';   
    }
}
