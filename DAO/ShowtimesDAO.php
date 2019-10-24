<?php
namespace DAO;

use DAO\IRepository as IRepository;
use Model\Showtime as Showtime;

class ShowtimesDAO {

    private $showtimesList  = array();
    private $connection;
    private $tableName = "showtimes";

    public function add(Showtime $showtimes)
    {
        try {
                if($this->exists($showtimes)){

                    $query = "INSERT INTO " . " " . $this->tableName . " " .
                        " (id_movie, id_cinema, view_date,hour,subtitles) VALUES
                                        (:id_movie,:id_cinema,:view_date,:hour,:subtitles);";
    
    
                    $parameters["id_movie"] = $showtimes->getMovie()->getMovieId();
                    $parameters["id_cinema"] = $showtimes->getCinema()->getId();
                    $parameters["view_date"] = $showtimes->getDate();
                    $parameters["hour"] = $showtimes->getHour();
                    $parameters["subtitles"] = $showtimes->getSubtitles();
    
                    $this->connection = Connection::GetInstance();
                    $this->connection->ExecuteNonQuery($query, $parameters);

                }

            } catch (\Throwable $ex) {

                throw $ex;
            }
    }

    public function exists(Showtime $showtimes)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id_movie = :id_movie AND id_cinema = :id_cinema AND view_date = :view_date AND hour = :hour";

            $parameters["id_movie"] = $showtimes->getMovie()->getMovieId();
            $parameters["id_cinema"] = $showtimes->getCinema()->getId();
            $parameters["view_date"] = $showtimes->getDate();
            $parameters["hour"] = $showtimes->getHour();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);

            return true;
        } catch (\Throwable $th) {

            throw $th;
        }

    }

    public function searchById($id)
    {
        try {

           $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id = :id_showtime;";
            $parameters["id_showtime"] = $id;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            if (!empty($resultSet)) {
                $showtime=new Showtime();
                $showtime->setShowtimeId($resultSet[0]["id"]);
                $showtime->setMovie($resultSet[0]["movie"]);
                $showtime->setCinema($resultSet[0]["cinema"]);
                $showtime->setDate($resultSet[0]["date"]);
                $showtime->setHour($resultSet[0]["hour"]);
                $showtime->setLanguage($resultSet[0]["language"]);
                $showtime->setSubtitle($resultSet[0]["subtitle"]);
                $showtime->setActive($resultSet[0]["active"]);

                $showtime->setTicketAvaliable($resultSet[0]["ticketAvaliable"]);
                return $showtime;
            }else{
            return null;
        } 
    }catch (\Throwable $th) {

        throw $th;
    } }

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

}


?>