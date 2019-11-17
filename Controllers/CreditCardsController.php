<?php 
namespace Controllers;
use Model\CreditCard;
use DAO\CreditCardsDAO;
use Controllers\ShowtimeController as ShowtimeController;
class CreditCardsController  
{
    private $creditCardsDAO;
    private $showtimeController;

    public function __construct() {
        $this->CreditCardsDAO = new CreditCardsDAO();
        $this->showtimeController = new ShowtimeController();
    }


    public function add($cc_number)
    {    
        
        $creditCard=new CreditCard($cc_number,$_SESSION['idUserLogged']);
            if (!$this->creditCardsDAO->userContainsCC($cc_number,$_SESSION['idUserLogged'])) {
                $this->creditCardsDAO->add($creditCard);
            }else {
                //Ya existe
            }
    }

    public function showAdd($showtimeId)
    {
       $this->showtimeController->showBuy($showtimeId, true);
    }
}














?>