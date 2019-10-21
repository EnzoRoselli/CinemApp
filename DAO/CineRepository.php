<?php

namespace DAO;

use DAO\IRepository as IRepository;
use Model\Cine as Cine;

//define("FILE_DIR", JSON ."/cine.json");

/*mandar al config.php*/

class CineRepository implements IRepository
{

    private $cineList  = array();
    private $connection;
    private $tableName = "cinemas"; //agregar nombre de la tabla

    public function add(Cine $cine)
    {
        if ($cine->getCapacity() > 0 && $cine->getTicketValue() > 0) {

            if (!existsCine($cine)) {
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
                } catch (\Throwable $ex) {
                    throw $ex;
                }
            }
        } else {
            $errorMsj = array();
            array_push($errorMsj, "El precio o la capacidad no pueden ser menor o igual que 0");
        }
    }

    public function existsCine(Cine $cine)
    {

        try {

            $query = "SELECT * FROM " . " " . $this->tableName . "WHERE name=:cineName and address=:cineAddress";

            $parameters["cineName"] = $cine->getName();
            $parameters["cineAddress"] = $cine->getAddress();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }

        return null;
    }

    public function delete($id)
    {
        $cine = $this->searchById($id);
        if ($cine != null) {
            $query = "DELETE FROM " . " " . $this->tableName . " " . "WHERE id=:id";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        if (($key = array_search($cine, $this->cineList)) !== false) {
            $this->cineList[$key]->setActive(false);
        }
    }

    public function searchById($id)
    {


        try {
            $query = "SELECT * FROM " . " " . $this->tableName . "WHERE id=:id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return $resultSet;
        } catch (\Throwable $th) {
            throw $th;
        }

        return null;
    }

    public function modifyCine($cine) //si los valores son vacios , que no se updatee
    {
        if (isset($cine->getName()) && isset($cine->getAddress()) && $cine->getCapacity()>0 && $cine->getTicketValue()>0) { 
        try {

            $query = "UPDATE " . " " . $this->tableName . " " . "SET name=:name, address=:address, capacity=:capacity, ticket_value=:ticket_value";

            $parameters["name"] = $cine->getName();
            $parameters["address"] = $cine->getAddress();
            $parameters["capacity"] = $cine->getCapacity();
            $parameters["ticket_value"] = $cine->getTicketValue();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }
    }else{
        return false;
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

                array_push($this->cineList, $cine);
            }
            return $this->cineList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
