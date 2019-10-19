<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

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
    $emailToSend=$_GET['email'];
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
    <p>
    <img  src="https://lh3.googleusercontent.com/xlISFVMMAlhalr1rhAWU9fketwaeMyakXsxCqzp7KlUNFMZVokoJZVtDjHuOsy3m9Z8" alt= "IMAGE_NAME" height:100px >
    </p>
    </div>
    </br>
    <div style=" height="40" align="left">

    <font size="3" color="#000000" style="text-decoration:none;font-family:Lato light">
    <div class="info" Style="align:left;">

    <p>Your password will be reset</p>

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
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



