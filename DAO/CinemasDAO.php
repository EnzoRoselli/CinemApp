<?php

use DAO\CinemasDAO;


namespace DAO;

use DAO\IRepository as IRepository;
use Model\Cine as Cine;
//Fijarse de no mostrar toodos los cines, sino los activos, o agregar un filtro de si quiere ver los activos nomas

class CinemasDAO implements IRepository
{

    private $cineList  = array();
    private $connection;
    private $tableName = "cinemas";

    public function add(Cine $cine)
    {        
        try {

            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (cinema_name, address, capacity,ticket_value, active) VALUES
                                 (:name,:address,:capacity,:ticket_value, :active);";


            $parameters["name"] = $cine->getName();
            $parameters["address"] = $cine->getAddress();
            $parameters["capacity"] = $cine->getCapacity();
            $parameters["ticket_value"] = $cine->getTicketValue();
            $parameters["active"] = $cine->getActive();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }    
    }

    public function exists(Cine $cine)
    {
       
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE cinema_name=:cineName and address=:cineAddress";

            $parameters["cineName"] = $cine->getName();
            $parameters["cineAddress"] = $cine->getAddress();
           
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            if ($resultSet==null) {
                return false;
            }else{
                return true;    
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {    
        try {
            $query = "DELETE" . " " ."FROM". " ". $this->tableName . " " . " WHERE id=:id";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    public function activate($id)
    {        
        try {
            $query = "UPDATE" . " " . $this->tableName . " " . " SET active=:active WHERE id=:id";
            $parameters["id"] = $id;
            $parameters["active"] = 1;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    public function desactivate($id)
    {
        try{
            $query = "UPDATE" . " " . $this->tableName . " " . " SET active=:active WHERE id=:id";
            $parameters["id"] = $id;
            $parameters["active"] = 0;
          
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $th) {
            throw $th;
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
                $cinema=new Cine();
                $cinema->setID($resultSet[0]["id"]);
                $cinema->setName($resultSet[0]["cinema_name"]);
                $cinema->setAddress($resultSet[0]["address"]);
                $cinema->setCapacity($resultSet[0]["capacity"]);
                $cinema->setTicketValue($resultSet[0]["ticket_value"]);
                $cinema->setActive($resultSet[0]["active"]);
                
                return $cinema;
            }else {
                return null;
            }
          
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modify($cine) 
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
