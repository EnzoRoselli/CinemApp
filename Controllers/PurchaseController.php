<?php 

namespace Controllers;
use Model\Purchase as Purchase;
use Model\Showtime as Showtime;
use Model\Ticket as Ticket;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\UsersDAO as UsersDAO;
use Controllers\ShowtimeController as ShowtimeController;

class PurchaseController  
{
    private $showtimeDao;
    private $showtimeController;
    private $usersDAO;

    public function __construct()
    {
        $this->$usersDAO=new UsersDAO();
        $this->showtimeController=new ShowtimeController();
        $this->showtimeDao = new ShowtimeDAO();
    }

    public function create($amount, $totalPrice, $showtimeId,$creditCardId)
    {
        $showtime = $this->showtimeDao->searchById($showtimeId);
         
        if (!empty($showtime)) {
            //Por si tiene la PC en ingles/español
            if ((date("l") =="thursday" || date("l") =="martes" || date("l") =="wednesday" || date("l") =="miercoles") && $amount>1) 
            $price=($showtime->getTicketValue()*$amount)*0.25;
            }else {
                $price = $showtime->getTicketValue()*$amount;
            }
            $user=$this->usersDAO->searchById($_SESSION['idUserLogged']);
            //LUEGO DE HACER EL DAO DE TARJETAS, HACER EL SEARCHBYNUMBER DE LA TARJETA
            $creditCard=$this->creditCardsDAO->searchById($creditCardId);
            $purchase = new Purchase(date("Y-m-d"),date("H:i:s"),$amount,$price,$user,$creditCard);
            for ($i=0; $i < count($amount); $i++) { 
                $ticker = new Ticket();
            }

            
        }
        if ($price!=$totalPrice) {
            //Mandar mensaje de que modifico
           $this->showtimeController->showBuy($showtimeId);
        }

       //tomar total, y el amount, una vez hecha corroboracion de si existe la showtime, etc, 
       //hacer un for count del amount, y crear ticjets POST haber creado la purhcase
     

    }else{
        //mandar mensaje de que modifico


    }

}
   














?>