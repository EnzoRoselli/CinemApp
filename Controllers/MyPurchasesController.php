<?php
namespace Controllers;
use DAO\PurchasesDAO as PurchaseDAO;

class MyPurchasesController{

    private $purchaseDAO;

    public function __construct()
    {
        $this->purchaseDAO = new PurchaseDAO();
    }

    public function showPurchases(){

        $userPurchases = array();
        $advices = array();

        try {

            $userPurchases = $this->getPurchasesByUserId($_SESSION['idUserLogged']);

            $this->showMyPurchases($userPurchases);

        } catch (\Throwable $th) {

            array_push($advices, DB_ERROR);
            $this->showMyPurchases($userPurchases, $advices);
        }

          
    }

    public function getPurchasesByUserId($userId){

        $userPurchases = array();

        $userPurchases = $this->purchaseDAO->getPurchasesByUserId($userId);
   
        return $userPurchases;
    }

    public function showMyPurchases($userPurchases = array(), $messages = ""){

        require_once(VIEWS . '/ValidateUserSession.php');
        require_once(VIEWS  . '/MyPurchases.php');
    }
}

?>