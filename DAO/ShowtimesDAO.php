<?php

namespace DAO;


use Model\Showtime as Showtime;
use Model\Cine as Cine;
use DAO\LanguagesDAO as LanguagesDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\TheatersDAO as TheatersDAO;

class ShowtimesDAO
{

    private $showtimesList  = array();
    private $connection;
    private $tableName = "showtimes";

    public function __construct()
    {
        $this->LanguageDAO = new LanguagesDAO();
        $this->MoviesDAO = new MoviesDAO();
        $this->TheatersDAO = new TheatersDAO();
    }


    public function add(Showtime $showtime)
    {


        $query = "INSERT INTO " . " " . $this->tableName . " " .
            " (id_movie, id_theater,id_language,ticketAvaliable, view_date,hour,subtitles,active) VALUES
            (:id_movie,:id_theater,:id_language,:ticketAvaliable,:view_date,:hour,:subtitles,:active);";

        $parameters["id_theater"] = $showtime->getTheater()->getId();
        $parameters["id_movie"] = $showtime->getMovie()->getId();
        $parameters["ticketAvaliable"] = (int) $showtime->getTicketAvaliable();
        $parameters["active"] = $showtime->getActive();
        $parameters["view_date"] = $showtime->getDate();
        $parameters["hour"] = $showtime->getHour();
        $parameters["subtitles"] = $showtime->isSubtitle();
        $parameters["id_language"] = $showtime->getLanguage()->getId();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {

            throw $ex;
        }
    }

    public function exists(Showtime $showtimes)
    {


        $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id_movie = :id_movie AND id_theater = :id_theater AND view_date = :view_date AND hour = :hour";

        $parameters["id_movie"] = $showtimes->getMovie()->getMovieId();
        $parameters["id_theater"] = $showtimes->getTheater()->getId();
        $parameters["view_date"] = $showtimes->getDate();
        $parameters["hour"] = $showtimes->getHour();
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            if (!empty($resultSet)) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function searchById($id)
    {


        $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id = :id_showtime;";
        $parameters["id_showtime"] = $id;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            if (!empty($resultSet)) {
                $showtime = new Showtime();
                $showtime->setShowtimeId($resultSet[0]["id"]);

                $id_theater = $resultSet[0]['id_theater'];
                $Theater = $this->TheatersDAO->searchById($id_theater);
                $showtime->setTheater($Theater);

                $id_language = $resultSet[0]['id_language'];
                $language = $this->LanguageDAO->searchById($id_language);
                $showtime->setLanguage($language);

                $id_movie = $resultSet[0]['id_movie'];
                $movie = $this->MoviesDAO->searchById($id_movie);
                $showtime->setMovie($movie);


                $showtime->setDate($resultSet[0]['view_date']);
                $showtime->setHour($resultSet[0]['hour']);
                $showtime->setSubtitle($resultSet[0]['subtitles']);
                if ($resultSet[0]['active'] == 1) {
                    $showtime->setActive(true);
                } else {
                    $showtime->setActive(false);
                }
                $showtime->setTicketAvaliable($resultSet[0]['ticketAvaliable']);

                return $showtime;
            } else {
                return null;
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

        $query = "UPDATE" . " " . $this->tableName . " " . " SET active=:desactive WHERE id=:id";
        $parameters["id"] = $id;
        $parameters["desactive"] = 0;
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getAll()
    {



        $this->showtimesList = array();
        $query = "SELECT * FROM" . ' ' . $this->tableName . " " . " ORDER BY(view_date)";
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {
                $Showtime = new Showtime();
                $Showtime->setShowtimeId($row['id']);

                $idTheater = $row['id_theater'];
                $theater = $this->TheatersDAO->searchById($idTheater);
                $Showtime->setTheater($theater);

                $id_language = $row['id_language'];
                $language = $this->LanguageDAO->searchById($id_language);
                $Showtime->setLanguage($language);

                $id_movie = $row['id_movie'];
                $movie = $this->MoviesDAO->searchById($id_movie);
                $Showtime->setMovie($movie);

                $Showtime->setDate($row['view_date']);
                $Showtime->setHour($row['hour']);


                $Showtime->setSubtitle($row['subtitles']);
                if ($row['active'] == 1 && $theater->getActive() != 0) {
                    $Showtime->setActive(true);
                } else {
                    $Showtime->setActive(false);
                }
                if ($row['ticketAvaliable'] > $theater->getCapacity() && $row['active'] == 1) {
                    $Showtime->setTicketAvaliable($theater->getCapacity());
                    $this->modify($Showtime);
                } else {
                    $Showtime->setTicketAvaliable($row['ticketAvaliable']);
                }

                array_push($this->showtimesList, $Showtime);
            }

            return $this->showtimesList;
        } catch (\Throwable $th) {

            throw $th;
        }
    }


    public function getMovieShowtimes($movie)
    {



        $this->showtimesList = array();
        $query = "SELECT * FROM showtimes 
            inner join movies 
            on movies.id = showtimes.id_movie 
            where showtimes.id_movie = :id_movie ORDER BY(view_date)";

        $parameters["id_movie"] = $movie->getId();
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (isset($resultSet)) {

                foreach ($resultSet as $row) {
                    $Showtime = new Showtime();
                    $Showtime->setShowtimeId($row[0]);

                    $idTheater = $row['id_theater'];
                    $theater = $this->TheatersDAO->searchById($idTheater);
                    $Showtime->setTheater($theater);

                    $id_language = $row['id_language'];
                    $language = $this->LanguageDAO->searchById($id_language);
                    $Showtime->setLanguage($language);

                    $id_movie = $row['id_movie'];
                    $movie = $this->MoviesDAO->searchById($id_movie);
                    $Showtime->setMovie($movie);

                    $Showtime->setDate($row['view_date']);
                    $Showtime->setHour($row['hour']);

                    $Showtime->setSubtitle($row['subtitles']);
                    if ($row['active'] == 1 && $theater->getActive() != 0) {
                        $Showtime->setActive(true);
                    } else {
                        $Showtime->setActive(false);
                    }
                    if ($row['ticketAvaliable'] > $theater->getCapacity() && $row['active'] == 1) {
                        $Showtime->setTicketAvaliable($theater->getCapacity());
                        $this->modify($Showtime);
                    } else {
                        $Showtime->setTicketAvaliable($row['ticketAvaliable']);
                    }

                    array_push($this->showtimesList, $Showtime);
                }

                return $this->showtimesList;
            } else {
                return null;
            }
        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function getShowtimesOfAcinema($cinemaId)
    {
        $showtimesList = array();
        $query = "SELECT * from " . $this->tableName . " "
            . " inner join theaters on theaters.id=showtimes.id_theater 
             inner join cinemas on theaters.id_cinema=cinemas.id 
             where theaters.id_cinema=" . $cinemaId->getId();
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {
                $Showtime = new Showtime();
                $Showtime->setShowtimeId($row['id']);

                $idTheater = $row['id_theater'];
                $theater = $this->TheatersDAO->searchById($idTheater);
                $Showtime->setTheater($theater);

                $id_language = $row['id_language'];
                $language = $this->LanguageDAO->searchById($id_language);
                $Showtime->setLanguage($language);

                $id_movie = $row['id_movie'];
                $movie = $this->MoviesDAO->searchById($id_movie);
                $Showtime->setMovie($movie);

                $Showtime->setDate($row['view_date']);
                $Showtime->setHour($row['hour']);

                $Showtime->setSubtitle($row['subtitles']);

                if ($row['active'] == 1 && $theater->getActive() != 0) {
                    $Showtime->setActive(true);
                } else {
                    $Showtime->setActive(false);
                }
                if ($row['ticketAvaliable'] > $theater->getCapacity() && $row['active'] == 1) {

                    $Showtime->setTicketAvaliable($theater->getCapacity());

                    $this->modify($Showtime);
                } else {
                    $Showtime->setTicketAvaliable($row['ticketAvaliable']);
                }

                array_push($showtimesList, $Showtime);
            }
            return $showtimesList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getShowtimesMovieOfAday(Showtime $showtime)
    {

        $query = "select showtimes.id_theater from showtimes  where showtimes.view_date=:date and showtimes.id_movie=:id_movie group by showtimes.id_theater;";
        $parameters["date"] = $showtime->getDate();
        $parameters["id_movie"] = $showtime->getMovie()->getId();
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            if (!empty($resultSet)) {
                $id_theater = $resultSet[0]['id_theater'];
                return $id_theater;
            } else {
                return null;
            }
        } catch (\Throwable $th) {

            throw $th;
        }
    }
    public function modify(Showtime $showtime)
    {



        $query = "UPDATE " . " " . $this->tableName . " " . "SET id_language=:id_language, id_movie=:id_movie, id_theater=:id_theater, view_date=:view_date, hour=:hour, subtitles=:subtitles, active=:active, ticketAvaliable=:ticketAvaliable WHERE id=:id";

        $parameters["id_language"] = $showtime->getLanguage()->getId();
        $parameters["id_movie"] = $showtime->getMovie()->getId();
        $parameters["id_theater"] = $showtime->getTheater()->getId();
        $parameters["view_date"] = $showtime->getDate();
        $parameters["hour"] = $showtime->getHour();
        $parameters["subtitles"] = $showtime->isSubtitle();
        if ($showtime->getActive() == false) {
            $parameters["active"] = 0;
        } else {
            $parameters["active"] = 1;
        }

        $parameters["ticketAvaliable"] = $showtime->getTicketAvaliable();
        $parameters["id"] = $showtime->getShowtimeId();

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
