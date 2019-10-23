<?php
namespace DAO;

use DAO\IRepository as IRepository;
use Model\Showtime as Showtime;

class ShowtimesDAO implements IRepository{

    private $showtimesList  = array();
    private $connection;
    private $tableName = "showtimes";

    public function add(Showtime $showtimes)
    {
        try {
                if($this->existsShowtime($showtimes)){

                    $query = "INSERT INTO " . " " . $this->tableName . " " .
                        " (id_movie, id_cinema, view_date,hour,subtitles) VALUES
                                        (:id_movie,:id_cinema,:view_date,:hour,subtitles);";
    
    
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

    public function existsShowtime(Showtime $showtimes)
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

    public function delete($id)
    {

    
    }

}


?>