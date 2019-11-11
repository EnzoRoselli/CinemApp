<?php

namespace DAO;

use Model\Theater as Theater;
use DAO\CinemasDAO as  CinemasDAO;

class TheatersDAO
{

    private $connection;
    private $tableName = "theaters";
    private $cinemasDAO;

    public function __construct() {
        $this->cinemasDAO = new cinemasDAO();
    }

    public function add(Theater $theater)
    {        
            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (theater_name, id_cinema, active,ticket_value, capacity) VALUES
                                 (:theater_name,:id_cinema,:active,:ticket_value, :capacity);";

            $parameters["theater_name"] = $theater->getName();
            $parameters["id_cinema"] = $theater->getCinema()->getId();
            $parameters["active"] = $theater->getActive();
            $parameters["ticket_value"] = $theater->getTicketValue();
            $parameters["capacity"] = $theater->getCapacity();

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }    
    }

    public function exists(Theater $theater)
    {
       
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE ". $this->tableName . ".id_cinema=:id_cinema and theater_name=:theater_name";

            $parameters["id_cinema"] = $theater->getCinema()->getId();
            $parameters["theater_name"] = $theater->getName();
           
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
                $theater=new Theater();
                $theater->setId($resultSet[0]["id"]);
                $theater->setName($resultSet[0]["theater_name"]);
                $cinema=$this->cinemasDAO->searchById($resultSet[0]['id_cinema']);
                $theater->setCinema($cinema);
                $theater->setActive($resultSet[0]["active"]);
                $theater->setTicketValue($resultSet[0]["ticket_value"]);
                $theater->setCapacity($resultSet[0]["capacity"]);
            
                return $theater;
            }else {
                return null;
            }
          
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modify(Theater $theater) 
    {

        try {
            
            $query = "UPDATE " . " " . $this->tableName . " " . "SET theater_name=:theater_name,
            id_cinema=:id_cinema, active=:active, ticket_value=:ticket_value, capacity=:capacity WHERE id=:id";
            
            $parameters["id"] = $theater->getId();
            $parameters["theater_name"] = $theater->getName();
            $parameters["id_cinema"] = $theater->getCinema()->getId();
            $parameters["active"] = $theater->getActive();
            $parameters["ticket_value"] = $theater->getTicketValue();
            $parameters["capacity"] = $theater->getCapacity();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getSortedTheatersByCineId($CineId)
    {
        try {
            
            $theaterList=array();

            $query ="SELECT * FROM ".$this->tableName." ". "
            INNER JOIN cinemas ON ". $this->tableName.".id_cinema =cinemas.:cinema_id 
            ORDER BY (".$this->tableName.".theater_name) DESC";

            $parameters["cinema_id "] = $CineId;
            
            $this->connection = Connection::GetInstance();
            $resultSet=$this->connection->Execute($query, $parameters);
        
            foreach ($resultSet as $row) {
                $theater = new Theater();
                $theater->setId($row['id']);
                $theater->setName($row['theater_name']);

                $cinema = $this->cinemasDAO->searchById($row['id_cinema']);
                $theater->setCinema($cinema);

                $theater->setActive($row['active']);
                $theater->setTicketValue($row['ticket_value']);
                $theater->setCapacity($row['capacity']);

                array_push($theaterList,$theater);
            }

            return $theaterList;
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function getAll()
    {

        try {
            
            $theaterList=array();

            $query = "SELECT * FROM" . ' ' . $this->tableName;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {

                $theater = new Theater();
                $theater->setId($row['id']);
                $theater->setName($row['theater_name']);

                $cinema = $this->cinemasDAO->searchById($row['id_cinema']);
                $theater->setCinema($cinema);

                if($row['active'] == 1){
                    $theater->setActive(true);
                }else{
                    $theater->setActive(false);
                }
                
                $theater->setTicketValue($row['ticket_value']);
                $theater->setCapacity($row['capacity']);
                
                array_push($theaterList, $theater);
            }
            return $theaterList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
