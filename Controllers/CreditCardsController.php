<?php 

use Model\CreditCard;
use DAO\CreditCardsDAO;
class CreditCardsController  
{
    private $creditCardsDAO;
    

    public function __construct() {
        $this->CreditCardsDAO = new CreditCardsDAO();
    }


    public function add()
    {    
        $creditCard=new CreditCard($cc_number,$_SESSION['idUserLogged']);
            if (!$this->creditCardsDAO->userContainsCC($cc_number,$_SESSION['idUserLogged'])) {
                $this->creditCardsDAO->add($creditCard);
            }else {
                //Ya existe
            }
    }

    public function showAdd()
    {
        //require_once(VIEWS. "/"); llamar al pop up para agregar una cc
    }
}














?>