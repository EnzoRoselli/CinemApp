<?php

namespace Controllers;

use Model\Purchase as Purchase;
use Model\QR_ as QR;
use Model\Ticket as Ticket;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\UsersDAO as UsersDAO;
use DAO\TicketsDAO as TicketsDAO;
use DAO\CreditCardsDAO AS CreditCardsDAO;
use DAO\PurchasesDAO as PurchasesDAO;
use DAO\QRsDAO as QRsDAO;
use Controllers\ShowtimeController as ShowtimeController;
use Controllers\MailsController as MailsController;


class PurchaseController
{
    private $showtimeDao;
    private $showtimeController;
    private $usersDAO;
    private $ticketsDAO;
    private $creditCardsDAO;
    private $purchasesDAO;
    private $QRsDAO;
    private $mailsController;

    public function __construct()
    {
        $this->purchasesDAO = new PurchasesDAO();
        $this->creditCardsDAO=new CreditCardsDAO();
        $this->ticketsDAO=new TicketsDAO();
        $this->usersDAO = new UsersDAO();
        $this->showtimeController = new ShowtimeController();
        $this->showtimeDao = new ShowtimeDAO();
        $this->QRsDAO=new QRsDAO();
        $this->mailsController=new MailsController();
        
    }

    public function create($amount, $totalPrice , $showtimeId, $creditCardId)
    {
        $advices = array();

        if ( $amount<20 && $amount>0 && !empty($amount) && !empty($creditCardId)  && !empty($showtimeId)) {
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
               
          
            $showtime->setTicketAvaliable(($showtime->getTicketAvaliable()-$amount));
         
                if ($showtime->getTicketAvaliable()==0) {
                    $showtime->setActive(false);
                    
                }

                $this->showtimeDao->modify($showtime);
              
                $purchase=$this->purchasesDAO->searchByPurchase($purchase);
                
                
                for ($i = 0; $i < $amount; $i++) {
                    
                    $ticket = new Ticket("",$purchase,$showtime);
                    $this->ticketsDAO->add($ticket);
                    $ticketQr=new QR();
                    $ticketQr->setTicket($ticket);
                    $this->QRsDAO->add($ticketQr);     
                }   
                   
                $qrsToSend=$this->QRsDAO->getByPurchase($purchase);

                $this->mailsController->sendPurchaseEmail($purchase,$qrsToSend);
                array_push($advices, BUY_SUCCESS);
            }  
    
        }else{
            
            array_push($advices, BUY_NOT_SUCCESS);
        } 
        $this->showtimeController->showShowtimesListUser(null, $advices);


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
    

    public function showPurchasesStatistics($cinemasPurchases = "", $moviesPurchases = ""){

        require_once(VIEWS . "/PurchaseStatistics.php");
    }
}
