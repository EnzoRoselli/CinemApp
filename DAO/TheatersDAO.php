<?php

namespace DAO;

use Model\Theater as Theater;
use DAO\CinemasDAO as  CinemasDAO;
//Fijarse de no mostrar toodos los cines, sino los activos, o agregar un filtro de si quiere ver los activos nomas

class TheatersDAO
{

    private $cineList  = array();
    private $connection;
    private $tableName = "theaters";
    private $cinemasDAO;

    public function __construct() {
        $this->cinemasDAO = new cinemasDAO();
    }

    public function add(Theater $theater)
    {        
        try {

            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (theater_number, id_cinema, active,ticket_value, capacity) VALUES
                                 (:theater_number,:id_cinema,:active,:ticket_value, :capacity);";


            $parameters["theater_number"] = $theater->getNumber();
            $parameters["id_cinema"] = $theater->getCinema();
            $parameters["active"] = $theater->getActive();
            $parameters["ticket_value"] = $theater->getTicketValue();
            $parameters["capacity"] = $theater->getCapacity();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }    
    }

    public function exists(Theater $theater)
    {
       
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id_cinema=:id_cinema and theater_number=:theater_number";

            $parameters["id_cinema"] = $theater->getCinema()->getId();
            $parameters["theater_number"] = $theater->getNumber();
           
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

    public function getSortedTheatersByCineId($CineId)
    {
        try {
            
        $TheaterList=array();
        $query ="SELECT * FROM ".$this->tableName." ". "
        INNER JOIN cinemas ON ". $this->tableName.".id_cinema =cinemas.:cinema_id 
        ORDER BY (".$this->tableName.".theater_number) DESC";
        $parameters["cinema_id "] = $CineId;
        $this->connection = Connection::GetInstance();
       $resultSet=$this->connection->Execute($query, $parameters);

       foreach ($resultSet as $item) {
        $Theater=new Theater();
        $Theater->setId($item['id']);
        $Theater->setNumber($item['theater_number']);

        $cinema=$this->cinemasDAO->searchById($item['id_cinema']);
        $Theater->setCinema($cinema);

        $Theater->setActive($item['active']);
        $Theater->setTicketValue($item['ticket_value']);
        $Theater->setCapacity($item['capacity']);

        array_push($TheaterList,$Theater);
       }
       return $TheaterList;
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

?>