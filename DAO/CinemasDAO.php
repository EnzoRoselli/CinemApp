<?php

use DAO\CinemasDAO;


namespace DAO;

use Model\Cine as Cine;
use Model\Showtime as Showtime;
use Model\Theater as Theater;

class CinemasDAO
{

    private $cineList  = array();
    private $connection;
    private $tableName = "cinemas";

    public function add(Cine $cine)
    {


        $query = "INSERT INTO " . " " . $this->tableName . " " .
            " (cinema_name, address, active) VALUES
                                 (:name,:address,:active);";


        $parameters["name"] = $cine->getName();
        $parameters["address"] = $cine->getAddress();
        $parameters["active"] = $cine->getActive();

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function exists(Cine $cine)
    {


        $query = "SELECT * FROM " . " " . $this->tableName . " WHERE cinema_name=:cineName and address=:cineAddress";

        $parameters["cineName"] = $cine->getName();
        $parameters["cineAddress"] = $cine->getAddress();
        try {

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            if ($resultSet == null) {
                return false;
            } else {
                return true;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {

        $query = "DELETE" . " " . "FROM" . " " . $this->tableName . " " . " WHERE id=:id";
        $parameters["id"] = $id;
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function activate($id)
    {

        $query = "UPDATE" . " " . $this->tableName . " " . " SET active=:active WHERE id=:id";
        $parameters["id"] = $id;
        $parameters["active"] = 1;
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function desactivate($id)
    {

        $query = "UPDATE" . " " . $this->tableName . " " . " SET active=:active WHERE id=:id";
        $parameters["id"] = $id;
        $parameters["active"] = 0;
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function isAShowtimeMovieInACinemaToday(Showtime $showtime)
    {

        $query = " select cinema_name from " . $this->tableName . " 
           inner join theaters on theaters.id_cinema=cinemas.id
           inner join showtimes on showtimes.id_theater=theaters.id
           where showtimes.id_movie=:id_movie and showtimes.view_date=:view_date";

        $parameters["id_movie"] = $showtime->getMovie()->getId();
        $parameters["view_date"] = $showtime->getDate();

        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {

                return $resultSet[0]['cinema_name'];
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function searchById($id)
    {


        $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id=:id";
        $queryTheater = "SELECT * FROM " . " theaters WHERE theaters.id_cinema  =:id";
        $parameters["id"] = $id;
        $cinema = null;
        try {
            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);
            $resultSetTheater = $this->connection->Execute($queryTheater, $parameters);

            if ($resultSet != null) {
                $cinema = new Cine();
                $cinema->setID($resultSet[0]["id"]);
                $cinema->setName($resultSet[0]["cinema_name"]);
                $cinema->setAddress($resultSet[0]["address"]);
                $cinema->setActive($resultSet[0]["active"]);
            }

            foreach ($resultSetTheater as $key) {
                $theater = new Theater();
                $theater->setId($key['id']);
                $theater->setName($key['theater_name']);
                $theater->setCinema($cinema);
                $theater->setActive($key['active']);
                $theater->setTicketValue($key['ticket_value']);
                $theater->setCapacity($key['capacity']);
                $cinema->addTheater($theater);
            }
            return $cinema;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modify($cine)
    {



        $query = "UPDATE " . " " . $this->tableName . " " . "SET cinema_name=:name, address=:address WHERE id=:id";

        $parameters["name"] = $cine->getName();
        $parameters["address"] = $cine->getAddress();
        $parameters["id"] = $cine->getId();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {


        $this->cineList = array();

        $query = "SELECT * FROM" . ' ' . $this->tableName;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {

                $cine = new Cine();
                $cine->setId($row['id']);
                $cine->setName($row['cinema_name']);
                $cine->setAddress($row['address']);
                if ($row['active'] == 1) {
                    $cine->setActive(true);
                } else {
                    $cine->setActive(false);
                }

                $queryTheaters = "SELECT * FROM theaters
                INNER JOIN " . $this->tableName . " on theaters.id_cinema = " . $row['id'] . " group by(theaters.id)";

                $resultSetTheaters = $this->connection->Execute($queryTheaters);

                foreach ($resultSetTheaters as $key) {
                    $theater = new Theater();
                    $theater->setId($key['id']);
                    $theater->setName($key['theater_name']);
                    $theater->setCinema($cine);
                    $theater->setActive($key['active']);
                    $theater->setTicketValue($key['ticket_value']);
                    $theater->setCapacity($key['capacity']);
                    $cine->addTheater($theater);
                }

                array_push($this->cineList, $cine);
            }
            return $this->cineList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
