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
                    echo '<script type="text/javascript">
                    alert("Los datos que intenta ingresar corresponden a un usuario existente en nuestra base de datos");
               </script>';             
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

    public function logoutAction(){
        session_destroy();
        echo '<script type="text/javascript">
        alert("La sesion se ha cerrado con éxito");
   </script>';
        session_start();
        HomeController::showMain();
    }


    /*public function showHome($message = array()){
  
        //HomeController::showMain();
        if ($message == '1') {

            //session_destroy();
            $_SESSION['delete'] = 1;
            echo 'Sesion destruida con exito';
            <var></var>
            
        }else {
            HomeController::showMain();
        }
       
    }*/

    public function showLoginSignup($message = array()){
        require_once(VIEWS . '/loginSignup.php');
    }

    public function addConfirmation($user){

        $this->usersDAO->add($user); 
        echo '<script type="text/javascript">
        alert("Usuario creado exitosamente, por favor inicie sesion con sus credenciales");
   </script>';
   $advices=array();
   array_push($advices,SIGNUP_SUCCESS);
        $this->showLoginSignup($advices);
    }


    private function checkNotNullParameters($user){
        if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null)
            return true;
        else
            return false;
    }
}
?>

