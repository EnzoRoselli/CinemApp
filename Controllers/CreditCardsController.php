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


    public function add($showtimeId, $cc_number)
    {

        $creditCard = new CreditCard($cc_number);
        try {
            $creditCard->setUser($this->userDAO->searchById($_SESSION['idUserLogged']));

            if (!$this->creditCardsDAO->userContainsCC($cc_number, $_SESSION['idUserLogged'])) {
                $this->creditCardsDAO->add($creditCard);
            } else {
                //Ya existe
            }
        } catch (\Throwable $th) {
            echo $th;
        }finally{
            $this->showtimeController->showBuy($showtimeId, false);
        }
    }

    public function showAdd($showtimeId)
    {
        $this->showtimeController->showBuy($showtimeId, true);
    }
}
