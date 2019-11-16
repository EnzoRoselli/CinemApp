<?php
namespace Controllers;

use DAO\UsersDAO as UsersDAO;
use Model\User as User;
use PHPMailer\PHPMailer\Exception;
use Controllers\ShowtimeController as ShowtimeController;


class UserController
{
    private $usersDAO;
    private $ShowtimeController;

    public function __construct()
    {
        $this->usersDAO = new UsersDAO();
        $this->ShowtimeController = new ShowtimeController();
    }


    public function createUser() /// DEBIERA SER LLAMADO POR LA VISTA DE SIGNUP
    {
        $user = $this->setParameters();

        if ($this->checkNotNullParameters($user)){ 

            if($this->validateEmail($user->getEmail())){                      
                try
                {               
                    $NewUserComprobation= $this->usersDAO->existsUserFromSignUp($user);
                    if($NewUserComprobation===false)
                    {
                    $this->addConfirmation($user); /** una vez que comprueba que los datos son validos redirecciona a la pantalla de log in */ 

                    }
                    else{          
                        $this->showLoginSignup(SIGNUP_FAILURE);           
                    }
                }
                catch(\Throwable $ex) {
                    var_dump($ex);
                echo 'Un error ha ocurrido';
                }
            }
            else{
                $this->showLoginSignup(EMAIL_DOMAIN_ERROR);
            }
        }
        else{     
            $this->showLoginSignup(INCOMPLETE_INPUTS);
        }
    }
    




    public function loginAction(){
   
        if (!empty($_POST['LoginEmail']) && !empty( $_POST['LoginPassword'])) {
            $UserLogging = new User($_POST['LoginEmail'], $_POST['LoginPassword']);
            try{
                $LoginComprobation = $this->usersDAO->correctCredentials($UserLogging);
                if(!$LoginComprobation){                    /**ES FALSE CUANDO NO EXISTE EN BASE DE DATOS */
                    $this->showLoginSignup(WRONG_CREDENTIALS);
                }
                else{              
                    $_SESSION['loggedUser'] = $LoginComprobation[0]['lastname'];
                    $_SESSION['idUserLogged'] = $LoginComprobation[0]['id'];
                    if (!empty($_SESSION['showtimeBuying'])) {
                        $this->ShowtimeController->showBuy($_SESSION['showtimeBuying']);
                    }else {
                        HomeController::showMain();  
                    }
                                                      /**HABRIA QUE MOSTRAR MENSAJE DE EXITO EN LA VISTA */
                }
            }catch(Exception $e) {
                echo "Ha ocurrido un error, por favor intentelo nuevamente";   /* catchear bien esta excepcin PONER ADVICE Y AVISAR*/ 
            }
        }
        else {          
            $this->showLoginSignup(INCOMPLETE_INPUTS);
        }
    }

    public function logoutAction(){
        session_destroy();
        //$this->ShowMessage(LOGOUT_SUCCESS); /**ESTO HAY QUE CAMBIARLO PARA QUE EL MENSAJE SALGA EN LAS VIEWS */
        session_start();
        HomeController::showMain();
    }


    public function showLoginSignup($message = array()){
        require_once(VIEWS . '/loginSignup.php');
    }



    public function addConfirmation($user){

        $this->usersDAO->add($user); 
        $this->showLoginSignup(SIGNUP_SUCCESS);
    }


    
    public function setParameters() /**SI LOS INDEX ESTAN SETEADOS CREA UN USUARIO, SINO DEVUELVE FALSE */
    {
        if (isset($_POST['SignupEmail'], $_POST['SignupPassword'], $_POST['SignupName'], $_POST['SignupLastName'], $_POST['SignupDNI'])){
            
            $email = filter_var($_POST['SignupEmail'],FILTER_SANITIZE_EMAIL);
            $password = $_POST['SignupPassword'];            
            $user = new User($email, $password);
            $user->setName($_POST["SignupName"]);
            $user->setLastName($_POST["SignupLastName"]);
            $user->setDni($_POST["SignupDNI"]);
            return $user;
        }
        else {
            return false;
        }
    }





    private function checkNotNullParameters($user){ /**user es false si no estan todos los parametros post, luego chequea que esten bien setteados los valores del user */
        if($user){
            if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null){
                $this->checkInputFormat($user);
                return true;
            }
            else{
                return false;
            }
        }else{
            return false;
        }
    }

 
    public function checkInputFormat($user)    /*CHEQUEA que los nombres no contengan numeros y que los DNI sean solo numeros, sin espacios*/
    {
        if($this->checkNameFormat($user->getName()) && $this->checkNameFormat($user->getLastName()) && ctype_digit($user->getDni())){
            return true;
        }else{
            return false;
        }
    }

    
    public function checkNameFormat($name) /* CHEQUEA QUE EL ARRAY PASADO CONTENGA SOLO LETRAS */
    {   
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            return true;
        }
        else {
            return false;
        }
    }

 
    
    function validateEmail($email){    /* CHEQUEA QUE EL DOMINIO DEL EMAIL PASADO SE ENCUENTRE ENTRE LOS CONSIDERADOS VALIDOS */
 
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
