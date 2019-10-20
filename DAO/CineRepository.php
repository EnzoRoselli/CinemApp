<?php

namespace DAO;

use DAO\IRepository as IRepository;
use Model\Cine as Cine;

//define("FILE_DIR", JSON ."/cine.json");

/*mandar al config.php*/

class CineRepository implements IRepository
{

    private $cineList = array();
    private $connection;
    private $tableName = "cinemas"; //agregar nombre de la tabla

    public function add(Cine $cine)
    {
        
        try {
            
            $query = "INSERT INTO " . " " . $this->tableName . " " . 
            " (cinema_name, address, capacity,ticket_value) VALUES
             (:name,:address,:capacity,:ticket_value);";

            //----------------Y ACA ARMARIA LA QUERY--------
            //cinema_name, address, capacity,ticket_value,active

            $parameters["name"] = $cine->getName();
            $parameters["address"] = $cine->getAdress();
            $parameters["capacity"] = $cine->getCapacity();
            $parameters["ticket_value"] = $cine->getTicketValue();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function existsId($id)
    {
        $flag = false;

        foreach ($this->cineList as $key) {
            if ($key->getId() == $id) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }

    public function existsNameAndAdress($name, $adress)
    {
        $flag = false;

        foreach ($this->cineList as $key) {
            if ($key->getName() === $name && $key->getAdress() === $adress) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }

    public function areCapacityAndPriceValid($capacity, $ticketValue)
    {

        if ($capacity == 0 || $ticketValue == 0) {

            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $cine = $this->searchById($id);

        if (($key = array_search($cine, $this->cineList)) !== false) {
            $this->cineList[$key]->setActive(false);
        }

        $this->saveData();
    }

    public function searchById($id)
    {


        try {

            $query = "SELECT * FROM " . " " . $this->tableName . "WHERE id=:id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
        } catch (\Throwable $th) {
            throw $th;
        }

        return null;
    }

    public function modifyCine($cine)
    {


        try {

            $query = "UPDATE " . " " . $this->tableName . "SET name=:name, adress=:adress, capacity=:capacity, ticket_value=:ticket_value";

            $parameters["name"] = $cine->getName();
            $parameters["address"] = $cine->getAdress();
            $parameters["capacity"] = $cine->getCapacity();
            $parameters["ticket_value"] = $cine->getTicketValue();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }


        $this->getData();
        $cineToModify = $this->searchById($cine->getId());

        if ($cineToModify  !== null) {

            if (($key = array_search($this->searchById($cine->getId()), $this->cineList)) !== false) {

                if ($cineToModify != $cine) {

                    if ($cineToModify->getName() !== "") {

                        $cineToModify->setName($cine->getName());
                    }

                    if ($cineToModify->getAdress() !== "") {

                        $cineToModify->setAdress($cine->getAdress());
                    }

                    if ($cine->getCapacity() !== "") {

                        $cineToModify->setCapacity($cine->getCapacity());
                    }

                    if ($cine->getTicketValue() !== "") {

                        $cineToModify->setTicketValue($cine->getTicketValue());
                    }

                    $this->cineList[$key] = $cineToModify;
                    $this->saveData();

                    return true;
                }
            }
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
                $cine->setAdress($row['address']);
                $cine->setCapacity($row['capacity']);
                $cine->setTicketValue($row['ticket_value']);
                
                array_push($this->cineList, $cine);
            }
            return $this->cineList;
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}
