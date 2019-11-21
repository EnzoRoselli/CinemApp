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

    /*
    @param shotimeId: to return to the view with it's showtime
    */
    public function add($showtimeId="", $cc_number = "", $sec_code = "", $origin)
    {
        $advices = array();

        if($this->validateCCNumber($cc_number)){
            
            if($this->validateSecurityCode($sec_code)){
               
                $creditCard = new CreditCard($cc_number, null, $sec_code);
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

            }else{
                array_push($advices, SEC_CODE_ERROR);
                $this->showCreditCardList($advices);
            }

        }else{
            array_push($advices, CC_NUMBER_ERROR);
            $this->showCreditCardList($advices);
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
        require_once(VIEWS . '/ValidateUserSession.php');
        $creditCardList = $this->creditCardsDAO->getCCbyUser($_SESSION['idUserLogged']);
        require_once(VIEWS . "/CreditCardTable.php");
    }

    public function validateCCNumber($cc_number){

        $length = strlen($cc_number);

        if($length == 16){
            return true;
        }else{
            return false;
        }
    }

    public function validateSecurityCode($sec_code){

        $length = strlen($sec_code);

        if($length == 3){
            return true;
        }else{
            return false;
        }
    }
}
