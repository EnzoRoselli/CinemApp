<?php 

namespace DAO;

use Model\CreditCard as CreditCard;
use DAO\UsersDAO as usersDAO;

//FALTA LA IMPLEMENTACION DEL QR
class CreditCardsDAO  
{
    private $tableName="credit_cards";

    public function add(CreditCard $CreditCard)
    {
        $query = "INSERT INTO ". $this->tableName." "."(cc_number,id_user,cc_company) VALUES(:cc_number,:id_user,:cc_company)";
        $parameters["cc_number"] = $CreditCard->getNumber();
        $parameters["id_user"] = $CreditCard->getUser()->getId();
        $parameters["cc_company"] = $CreditCard->getCompany();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }
    public function userRegisteredWithCC($user_id,$number)
    {
        $query = "SELECT * FROM ". $this->tableName." WHERE user_id=:user_id and cc_number=:number";
        $parameters['user_id']=$user_id;
        $parameters['number']=$number;
        try {
            $this->connection = Connection::GetInstance();
            $ResultSet=$this->connection->ExecuteNonQuery($query, $parameters);
            if (!empty($ResultSet)) {
                $CreditCard = new CreditCard();
                $CreditCard->setId($ResultSet[0]['id']);
                $usersDAO=new usersDAO();
                $user=$usersDAO->searchById($ResultSet[0]['id_user']);
                $CreditCard->setUser($user);

                $CreditCard->setNumber($ResultSet[0]['cc_number']);
                return $CreditCard;
            }
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function searchById($Id)
    {
        $query="SELECT * FROM ". $this->tableName." WHERE id=:id";
        $parameters["id"] = $Id;
        try {
            $this->connection = Connection::GetInstance();
           $ResultSet= $this->connection->ExecuteNonQuery($query, $parameters);
            if(!empty($ResultSet)){
                $CreditCard=new CreditCard();
                $CreditCard->setId($ResultSet[0]['id']);
                $CreditCard->setNumber($ResultSet[0]['cc_number']);

                $usersDAO=new usersDAO();
                $user=$usersDAO->searchById($ResultSet[0]['id_user']);
                $CreditCard->setUser($user);
              
                $CreditCard->setCompany($ResultSet[0]['cc_company']);
                return $CreditCard;
            }
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function getCCbyUser($id_user)
    {
        $CreditCardsList=array();
        $query = "SELECT * FROM ". $this->tableName. " WHERE id_user=:id_user";
        $parameters["id_user"] = $id_user;
    try {
        $this->connection = Connection::GetInstance();
        $ResultSet= $this->connection->ExecuteNonQuery($query, $parameters);
        if (!empty($ResultSet)) {
            foreach ($ResultSet as $item) {
                $CreditCard=new CreditCard();
                $CreditCard->setId($$item['id']);
                $CreditCard->setNumber($item['cc_number']);

                $usersDAO=new usersDAO();
                $user=$usersDAO->searchById($item['id_user']);
                $CreditCard->setUser($user);
              
                $CreditCard->setCompany($item['cc_company']);
                array_push($CreditCardsList,$CreditCard);
            }
            return $CreditCardsList;
        }
    
    } catch (\Throwable $th) {
        throw $th;
    }

    }
}


























?>