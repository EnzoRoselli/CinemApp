<?php

namespace Controllers;

use Model\Purchase as Purchase;
use Model\Showtime as Showtime;
use Model\Ticket as Ticket;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\UsersDAO as UsersDAO;
use DAO\TicketsDAO as TicketsDAO;
use DAO\CreditCardsDAO AS CreditCardsDAO;
use DAO\PurchasesDAO as PurchasesDAO;
use Controllers\ShowtimeController as ShowtimeController;
use Model\PHPMailer as PHPMailer;
use Model\Exceptionn as Exceptionn;
use Model\STMP;

class PurchaseController
{
    private $showtimeDao;
    private $showtimeController;
    private $usersDAO;
    private $ticketsDAO;
    private $creditCardsDAO;
    private $purchasesDAO;

    public function __construct()
    {
        $this->purchasesDAO = new PurchasesDAO();
        $this->creditCardsDAO=new CreditCardsDAO();
        $this->ticketsDAO=new TicketsDAO();
        $this->usersDAO = new UsersDAO();
        $this->showtimeController = new ShowtimeController();
        $this->showtimeDao = new ShowtimeDAO();
        
    }

    public function create($amount, $totalPrice, $showtimeId, $creditCardId)
    {
 

        if ( /*$amount<20 &&*/ $amount>0 && !empty($amount) && !empty($creditCardId)  && !empty($showtimeId)) {
            //Por si tiene la PC en ingles/español
            $showtime = $this->showtimeDao->searchById($showtimeId);
            if ($this->comprobateTicketsAvaliable($showtime,$amount)){
                if ($this->comprobateDateForDiscount($amount)) {
                    $price = ($showtime->getTheater()->getTicketValue() * $amount) * 0.25;
                }else {
                    $price = $showtime->getTheater()->getTicketValue() * $amount;
                }     
                $user = $this->usersDAO->searchById($_SESSION['idUserLogged']);
                $creditCard = $this->creditCardsDAO->userRegisteredWithCC($_SESSION['idUserLogged'],$creditCardId);
                $purchase = new Purchase(date("Y-m-d"), date("H:i:s"), $amount, $price);
                $purchase->setUser($user);
                $purchase->setcreditCard($creditCard);
                $this->purchasesDAO->add($purchase);
                $this->sendPurchaseEmail($purchase);
            $cero=0;
            $showtime->setTicketAvaliable(/*($showtime->getTicketAvaliable()-$amount)*/$cero);
         
                if ($showtime->getTicketAvaliable()==0) {
                    $showtime->setActive(false);
                    
                }

                $this->showtimeDao->modify($showtime);
              
                $purchase=$this->purchasesDAO->searchByPurchase($purchase);

                for ($i = 0; $i < $amount; $i++) {
                    //ASIGNAR QR
                    $ticket = new Ticket("",$purchase,$showtime);
                    $this->ticketsDAO->add($ticket);
                }        
            }  
    
        }else{
            
            //mensaje error;
        } 
        $this->showtimeController->showShowtimesListUser();


    }


    public function comprobateTicketsAvaliable($showtime,$amount)
    {
        if ($showtime->getTicketAvaliable()<$amount) {
            return false;
        }else {
            return true;
        }
    }
    public function comprobateDateForDiscount($amount)
    {
       if ((date("l") == "thursday" || date("l") == "martes" || date("l") == "wednesday" || date("l") == "miercoles") && $amount > 1) {
          return true;
       }else {
           return false;
       }
    }
    public function sendPurchaseEmail(Purchase $purchase)
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
        $mail->Subject = 'Thanks you for the purchase';
        $mail->Body    = '<BODY BGCOLOR="White">
<body>
<div Style="align:center;">
<p> PURCHASE INFORMATION </p>
<pre>
<p>'."Date: " .$purchase->getDate(). " - Hour: " .$purchase->getHour()."</p>
<p>TicketsAmount: " .$purchase->getTicketAmount()."</p>
<p>Credit Card: " . $purchase->getcreditCard()->getNumber()."</p>
<p>TOTAL: " .$purchase->getTotal()."</p>".

'</pre>
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
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    }

    public function showPurchasesStatistics($cinemasPurchases = "", $moviesPurchases = ""){

        require_once(VIEWS . "/PurchaseStatistics.php");
    }
}
