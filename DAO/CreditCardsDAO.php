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
        $query = "INSERT INTO ". $this->tableName." "."(cc_number,id_user) VALUES(:cc_number,:id_user)";
        $parameters["cc_number"] = $CreditCard->getNumber();
        $parameters["id_user"] = $CreditCard->getUser()->getId();

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }
    public function userRegisteredWithCC($id_user,$id)
    {
        $query = "SELECT * FROM ". $this->tableName." WHERE id_user=:id_user and id=:id";
        $parameters['id_user']=$id_user;
        $parameters['id']=$id;
        try {
            $this->connection = Connection::GetInstance();
            $ResultSet=$this->connection->Execute($query, $parameters);

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
        $ResultSet= $this->connection->Execute($query, $parameters);

        if (!empty($ResultSet)) {
            foreach ($ResultSet as $item) {
                $CreditCard=new CreditCard();
                $CreditCard->setId($item['id']);
                $CreditCard->setNumber($item['cc_number']);

                $usersDAO=new usersDAO();
                $user=$usersDAO->searchById($item['id_user']);
                $CreditCard->setUser($user);
              
                array_push($CreditCardsList,$CreditCard);
            }
            return $CreditCardsList;
        }
    
    } catch (\Throwable $th) {
        throw $th;
    }

    }

    public function userContainsCC($cc_number,$id_user)
    {
        $query = "SELECT * FROM ".$this->tableName." WHERE id_user=:id_user and cc_number=:cc_number";
        $parameters["id_user"] = $id_user;
        $parameters["cc_number"] = $cc_number;
        try {
            $this->connection = Connection::GetInstance();
            $ResultSet= $this->connection->Execute($query, $parameters);
            if (!empty($ResultSet)) {
                return true;
            }else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}


























?>