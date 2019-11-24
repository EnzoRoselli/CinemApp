<?php 
namespace Controllers;

use Model\Purchase;
use DAO\UsersDAO;
use Model\PHPMailer;
use Model\Exceptionn;
use Model\SMTP;
class MailsController 
{
    private $usersDAO;
    public function __construct() {
        $this->usersDAO = new UsersDAO();
    }
    function codeGenerator()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
    public function sendPasswordRecuperation($email)
    {
        $advices = array();
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
            
            array_push($mail->ErrorInfo);
        }
    }

    public function sendPurchaseEmail(Purchase $purchase,$qrsToSend)
    {
        $user = $this->usersDAO->searchById($_SESSION['idUserLogged']);
        $mail = new PHPMailer(true);

    try {
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
        $emailToSend = $user->getEmail();
        $mail->addAddress($emailToSend, 'User');     // Add a recipient
   // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Thank you for the purchase';
       
           foreach ($qrsToSend as $item) {
            $photo=$item->getFileName();
           $mail->AddEmbeddedImage("QR/temp/$photo","qr");
   
           }
        
        $mail->Body    = '<BODY BGCOLOR="White">
<body>
<div Style="align:center;">
<p> PURCHASE INFORMATION  </p>
<pre>
<p>'."Date:". $purchase->getDate() ." - Hour: " .$purchase->getHour()."</p>
<p>TicketsAmount: " .$purchase->getTicketAmount()."</p>
<p>Credit Card: " . $purchase->getcreditCard()->getNumber()."</p>
<p>TOTAL: " .$purchase->getTotal()."</p>".'
</pre>
<p>
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
        
    } catch (Exceptionn $e) {
        array_push($advices, DB_ERROR . $mail->ErrorInfo);
    }
    }
}















?>