<?php

namespace Controllers;

use DAO\UsersDAO as UsersDAO;
use Model\User as User;
use PHPMailer\PHPMailer\Exception;
use Controllers\ShowtimeController as ShowtimeController;
use Model\PHPMailer as PHPMailer;
use Model\Exceptionn as Exceptionn;
use Model\STMP;



class UserController
{
    private $usersDAO;
    private $ShowtimeController;

    public function __construct()
    {
        $this->usersDAO = new UsersDAO();
        $this->ShowtimeController = new ShowtimeController();
    }


    public function createUser($signupName, $signupLastName, $signupDni, $signupEmail, $signupPassword) /// DEBIERA SER LLAMADO POR LA VISTA DE SIGNUP
    {
        $user = $this->setParameters($signupName, $signupLastName, $signupDni, $signupEmail, $signupPassword);

        if ($this->checkNotNullParameters($user)) {

            if ($this->validateEmail($user->getEmail())) {
                try {
                    $NewUserComprobation = $this->usersDAO->existsUserFromSignUp($user);
                    if ($NewUserComprobation === false) {
                        $this->addConfirmation($user);
                        /** una vez que comprueba que los datos son validos redirecciona a la pantalla de log in */
                    } else {
                        $this->showLoginSignup(SIGNUP_FAILURE);
                    }
                } catch (\Throwable $ex) {
                    $this->showLoginSignup(DB_ERROR);
                }
            } else {
                $this->showLoginSignup(EMAIL_DOMAIN_ERROR);
            }
        } else {
            $this->showLoginSignup(INCOMPLETE_INPUTS);
        }
    }

  


    public function sendPasswordRecuperation($email)
    {
        $recuperationCode = $this->codeGenerator();
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'cinemappsupputn@gmail.com';                     // SMTP username
            $mail->Password   = 'UTNATR100';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('cinemappsupputn@gmail.com', 'CinemApp');
            $emailToSend = $email;
            $mail->addAddress($emailToSend, 'User');     // Add a recipient

            // VAN ARCHIVOS O IMAGENES
            // // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Reset your password';
            $mail->Body    = '<BODY BGCOLOR="White">
            <body>
                <div Style="align:center;">
                    <p>THIS IS THE CODE TO RESET THE PASSWORD: ' . $recuperationCode . '</p>
                    <p>
                        <img  src="https://lh3.googleusercontent.com/xlISFVMMAlhalr1rhAWU9fketwaeMyakXsxCqzp7KlUNFMZVokoJZVtDjHuOsy3m9Z8" alt= "IMAGE_NAME" height:100px >
                    </p>
                </div>

                </br>

                <div style=" height="40" align="left">
                    <font size="3" color="#000000" style="text-decoration:none;font-family:Lato light">
                <div class="info" Style="align:left;"> 

                <br>

                <p>Company:   CinemApp   </p> 
                <br>
                </div>
                </br>
                <p>-----------------------------------------------------------------------------------------------------------------</p>
                </br>
                <p>( This is an automated message, please do not reply to this message, if you have any queries please contact CinemAppSuppUTN@gmail.com )</p>
                </font>
                </div>
            </body>';


            $mail->send();
            require_once(VIEWS . "/RecuperatePassword.php");
        } catch (Exceptionn $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    public function passwordForgotten()
    {
        require_once(VIEWS . "/ForgotPassword.php");
    }

    public function testRecuperation($code)
    { }

    public function loginAction($LoginEmail = "", $LoginPassword = "")
    {
        if (!empty($LoginEmail) && !empty($LoginPassword)) {
            $UserLogging = new User($LoginEmail, $LoginPassword);
            try {
                $LoginComprobation = $this->usersDAO->correctCredentials($UserLogging);
                if (!$LoginComprobation) {
                    /**ES FALSE CUANDO NO EXISTE EN BASE DE DATOS */
                    $this->showLoginSignup(WRONG_CREDENTIALS);
                } else {

                    if ($LoginComprobation[0]['email'] == 'admin@gmail.com') {
                        $_SESSION['loggedAdmin'] = $LoginComprobation[0]['lastname'];
                        $_SESSION['idUserLogged'] = $LoginComprobation[0]['id'];
                    } else {

                        $_SESSION['loggedUser'] = $LoginComprobation[0]['lastname'];
                        $_SESSION['idUserLogged'] = $LoginComprobation[0]['id'];
                    }

                    if (!empty($_SESSION['showtimeBuying'])) {
                        $this->ShowtimeController->showBuy($_SESSION['showtimeBuying']);
                    } else {
                        HomeController::showMain();
                    }
                }
            } catch (Exception $e) {

                $this->showLoginSignup(DB_ERROR);
            }
        } else {
            $this->showLoginSignup(INCOMPLETE_INPUTS);
        }
    }

    public function logoutAction()
    {
        session_destroy();
        session_start();
        HomeController::showMain();
    }


    public function showLoginSignup($message = array())
    {
        require_once(VIEWS . '/loginSignup.php');
    }



    public function addConfirmation($user)
    {

        $this->usersDAO->add($user);
        $this->showLoginSignup(SIGNUP_SUCCESS);
    }



    public function setParameters($signupName, $signupLastName, $signupDni, $signupEmail, $signupPassword)
    /**SI LOS INDEX ESTAN SETEADOS CREA UN USUARIO, SINO DEVUELVE FALSE */
    {
        if ($signupDni > 2147483647 || $signupDni < -2147483648) {
            return false;
        } else {
            if (isset($signupName, $signupLastName, $signupDni, $signupEmail, $signupPassword)) {

                $email = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
                $user = new User($email, $signupPassword);
                $user->setName($signupName);
                $user->setLastName($signupLastName);
                $user->setDni($signupDni);
                return $user;
            } else {
                return false;
            }
        }
    }


    private function checkNotNullParameters($user)
    {
        /**user es false si no estan todos los parametros post, luego chequea que esten bien setteados los valores del user */
        if ($user) {
            if ($user->getName() != null && $user->getLastName() != null && $user->getDni() != null && $user->getEmail() != null && $user->getPassword() != null) {
                $this->checkInputFormat($user);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function checkInputFormat($user)    /*CHEQUEA que los nombres no contengan numeros y que los DNI sean solo numeros, sin espacios*/
    {
        if ($this->checkNameFormat($user->getName()) && $this->checkNameFormat($user->getLastName()) && ctype_digit($user->getDni())) {
            return true;
        } else {
            return false;
        }
    }


    public function checkNameFormat($name) /* CHEQUEA QUE EL ARRAY PASADO CONTENGA SOLO LETRAS */
    {
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            return true;
        } else {
            return false;
        }
    }



    function validateEmail($email)
    {    /* CHEQUEA QUE EL DOMINIO DEL EMAIL PASADO SE ENCUENTRE ENTRE LOS CONSIDERADOS VALIDOS */

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $splittedEmail = explode("@", $email);
            $domain = array_pop($splittedEmail);
            $validDomains = array('hotmail.com', 'hotmail.com.ar', 'gmail.com', 'outlook.com', 'yahoo.com', 'yahoo.com.ar');

            if (in_array($domain, $validDomains)) {
                return true;
            } else {
                return false; ///NO EXISTE EL DOMINIO     
            }
        } else {
            return false; // FORMATO INVALIDO
        }
    }
}
