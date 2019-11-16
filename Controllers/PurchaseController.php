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
                $purchase=$this->purchasesDAO->searchByPurchase($purchase);
                for ($i = 0; $i < $amount; $i++) {
                    //ASIGNAR QR
                    $ticket = new Ticket("",$purchase,$showtime);
                    $this->ticketsDAO->add($ticket);
                }        
            }  
    $this->showtimeController->showShowtimesListUser();
        }else{
            
            //mensaje error;
        } 
       


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
}
