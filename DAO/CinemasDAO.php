<?php

use DAO\CinemasDAO;


namespace DAO;

use DAO\IRepository as IRepository;
use Model\Cine as Cine;

class CinemasDAO implements IRepository
{

    private $cineList  = array();
    private $connection;
    private $tableName = "cinemas";

    public function add(Cine $cine)
    {
        if ($this->existsCine($cine)==null) {  
        try {

            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (cinema_name, address, capacity,ticket_value) VALUES
                                 (:name,:address,:capacity,:ticket_value);";


            $parameters["name"] = $cine->getName();
            $parameters["address"] = $cine->getAddress();
            $parameters["capacity"] = $cine->getCapacity();
            $parameters["ticket_value"] = $cine->getTicketValue();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $ex) {
            return false;
            throw $ex;
        }
    }
    }

    public function existsCine(Cine $cine)
    {

        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE cinema_name=:cineName and address=:cineAddress";

            $parameters["cineName"] = $cine->getName();
            $parameters["cineAddress"] = $cine->getAddress();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            if ($resultSet==null) {
                return null;
            }else{
                return true;    
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }

 
    }

    public function delete($id)
    {

        $comprobationID = $this->searchById($id);

        if ($comprobationID!=null) {
            $query = "DELETE" . " " ."FROM". " ". $this->tableName . " " . " WHERE id=:id";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        }
    }
    public function activateCinema($id)
    {
        if ($this->searchById($id)) {
            
            $query = "UPDATE" . " " . $this->tableName . " " . " SET active=:active WHERE id=:id";
            
            $parameters["id"] = $id;
            $parameters["active"] = 1;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            
        }
    }
    public function desactivateCinema($id)
    {
        if ($this->searchById($id)) {
            $query = "UPDATE" . " " . $this->tableName . " " . " SET active=:active WHERE id=:id";
            $parameters["id"] = $id;
            $parameters["active"] = 0;
          
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            
        }
    }

    public function searchById($id)
    {
      
        try {
            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id=:id";

            $parameters["id"] = $id;
            
            $this->connection = Connection::GetInstance();
         
            $resultSet = $this->connection->Execute($query,$parameters);
            if ($resultSet!=null) {
                $updateCinema=new Cine();
                $updateCinema->setID($resultSet[0]["id"]);
                $updateCinema->setName($resultSet[0]["cinema_name"]);
                $updateCinema->setAddress($resultSet[0]["address"]);
                $updateCinema->setCapacity($resultSet[0]["capacity"]);
                $updateCinema->setTicketValue($resultSet[0]["ticket_value"]);
                $updateCinema->setActive($resultSet[0]["active"]);
                
                return $updateCinema;
            }else {
                return null;
            }
          
        } catch (\Throwable $th) {
            throw $th;
        }

        return null;
    }

    public function modifyCine($cine) //si los valores son vacios , que no se updatee
    {

        try {
            
            $query = "UPDATE " . " " . $this->tableName . " " . "SET cinema_name=:name, address=:address, capacity=:capacity, ticket_value=:ticket_value WHERE id=:id";

            $parameters["name"] = $cine->getName();
            $parameters["address"] = $cine->getAddress();
            $parameters["capacity"] = $cine->getCapacity();
            $parameters["ticket_value"] = $cine->getTicketValue();
            $parameters["id"] = $cine->getId();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }
        return false;
    }





    public function getAll()
    {

        try {
            $this->cineList = array();
            $query = "SELECT * FROM" . ' ' . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {

                $cine = new Cine();
                $cine->setId($row['id']);
                $cine->setName($row['cinema_name']);
                $cine->setAddress($row['address']);
                $cine->setCapacity($row['capacity']);
                $cine->setTicketValue($row['ticket_value']);
                if($row['active'] == 1){
                    $cine->setActive(true);
                }else{
                    $cine->setActive(false);
                }
                
                array_push($this->cineList, $cine);
            }
            return $this->cineList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
