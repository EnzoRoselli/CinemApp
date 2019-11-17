<?php

namespace Controllers;

use Model\CreditCard as CreditCard;
use DAO\CreditCardsDAO as CreditCardsDAO;
use DAO\UsersDAO as UsersDAO;
use Controllers\ShowtimeController as ShowtimeController;

class CreditCardsController
{
    private $creditCardsDAO;
    private $showtimeController;

    public function __construct()
    {
        $this->creditCardsDAO = new CreditCardsDAO();
        $this->showtimeController = new ShowtimeController();
        $this->userDAO = new UsersDAO();
    }


    public function add($showtimeId="", $cc_number, $origin)
    {
        $advices = array();
        $creditCard = new CreditCard($cc_number);
        try {
            $creditCard->setUser($this->userDAO->searchById($_SESSION['idUserLogged']));

            if (!$this->creditCardsDAO->userContainsCC($cc_number, $_SESSION['idUserLogged'])) {
                $this->creditCardsDAO->add($creditCard);
                array_push($advices, ADDED);
            } else {
                array_push($advices, EXISTS);
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }finally{
            if($origin == 'buy'){
                $this->showtimeController->showBuy($showtimeId, false);
            }else{
                $this->showCreditCardList($advices);
            }
            
        }
    }

    public function delete($ccId){
        $advices = array();
        try{
            $this->creditCardsDAO->delete($ccId);
            array_push($advices, DELETED);
        }catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        }finally{
            $this->showCreditCardList($advices);
        }
        
    }

    public function showAdd($showtimeId)
    {
        $this->showtimeController->showBuy($showtimeId, true);
    }

    public function showCreditCardList($messages=""){
        $creditCardList = $this->creditCardsDAO->getCCbyUser($_SESSION['idUserLogged']);
        require_once(VIEWS . "/CreditCardTable.php");
    }
}
