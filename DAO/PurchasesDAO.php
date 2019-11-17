<?php  
namespace DAO;
use Model\Purchase as Purchase;
use DAO\UsersDAO as usersDAO;
use DAO\CreditCardsDAO as CreditCardsDAO;
class PurchasesDAO  
{
    private $tableName = "purchases";

    public function add(Purchase $purchase)
    {
        $query="INSERT into ". $this->tableName." (purchase_date,hour,ticketsAmount,total,id_user,id_cc) VALUES(:purchase_date,:hour,:ticketsAmount,:total,:id_user,:id_cc)" ;
        $parameters["purchase_date"] = $purchase->getDate();
        $parameters["hour"] = $purchase->getHour();
        $parameters["ticketsAmount"] = $purchase->getTicketAmount();
        $parameters["total"] = $purchase->getTotal();
        $parameters["id_user"] = $purchase->getUser()->getId();
        $parameters["id_cc"] = $purchase->getcreditCard()->getId();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function searchByPurchase($purchase)
    {
        $query = "SELECT * FROM ". $this->tableName." WHERE ticketsAmount=:ticketsAmount  and purchase_date=:purchase_date   and hour=:hour and   id_user=:id_user and   id_cc=:id_cc and total=:total";
        $parameters['purchase_date'] =$purchase->getDate() ;
        $parameters['hour'] = $purchase->getHour();
        $parameters['ticketsAmount'] = $purchase->getTicketAmount();
        $parameters['total'] = $purchase->getTotal();
        $parameters['id_user'] = $purchase->getUser()->getId();
        $parameters['id_cc'] = $purchase->getcreditCard()->getId();
        try {
            $this->connection = Connection::GetInstance();
            $ResultSet=$this->connection->Execute($query, $parameters);
            if (!empty($ResultSet)) {
                $Purchase = new Purchase();
                $purchase->setId($ResultSet[0]['id']);
                $purchase->setDate($ResultSet[0]['purchase_date']);
                $purchase->setHour($ResultSet[0]['hour']);
                $purchase->setTicketAmount($ResultSet[0]['ticketsAmount']);
                $purchase->setTotal($ResultSet[0]['total']);

                $usersDAO=new usersDAO();
                $user=$usersDAO->searchById($ResultSet[0]['id_user']);
                $purchase->setUser($user);

                $CreditCardsDAO=new CreditCardsDAO();
                $creditCard=$CreditCardsDAO->searchById($ResultSet[0]['id_cc']);
                $purchase->setcreditCard($creditCard);
                return $purchase;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function searchById($id)
    {
        $query="SELECT * FROM ".$this->tableName." WHERE id=:id";
        $parameters['id'] =$id;
         try {
            $this->connection = Connection::GetInstance();
            $ResultSet=$this->connection->Execute($query, $parameters);
            if (!empty($ResultSet)) {
                $Purchase = new Purchase();
                $Purchase->setId($ResultSet[0]['id']);
                $Purchase->setDate($ResultSet[0]['purchase_date']);
                $Purchase->setHour($ResultSet[0]['hour']);
                $Purchase->setTicketAmount($ResultSet[0]['ticketsAmount']);
                $Purchase->setTotal($ResultSet[0]['total']);

                $usersDAO=new usersDAO();
                $user=$usersDAO->searchById($ResultSet[0]['id_user']);
                $Purchase->setUser($user);

                $CreditCardsDAO=new CreditCardsDAO();
                $creditCard=$CreditCardsDAO->searchById($ResultSet[0]['id_cc']);
                $Purchase->setcreditCard($creditCard);
                return $Purchase;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}







































?>