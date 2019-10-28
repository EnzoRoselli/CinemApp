<?php
namespace DAO;


use Model\Showtime as Showtime;
use DAO\CinemasDAO as CinemasDAO;
use DAO\LanguagesDAO as LanguagesDAO;
 use DAO\MoviesDAO as MoviesDAO;

class ShowtimesDAO {

    private $showtimesList  = array();
    private $connection;
    private $tableName = "showtimes";

    public function __construct() {
        $this->LanguageDAO=new LanguagesDAO();
        $this->CinemasDAO=new CinemasDAO();
        $this->MoviesDAO=new MoviesDAO();
    }
 

    public function add(Showtime $showtime)
    {
        try {

            $query = "INSERT INTO " . " " . $this->tableName . " " .
            " (id_movie, id_cinema,id_language,ticketAvaliable, view_date,hour,subtitles,active) VALUES
            (:id_movie,:id_cinema,:id_language,:ticketAvaliable,:view_date,:hour,:subtitles,:active);";
            
            $parameters["id_cinema"] = $showtime->getCinema()->getId();
            $parameters["id_movie"] = $showtime->getMovie()->getId();
            $parameters["ticketAvaliable"] = $showtime->getTicketAvaliable();
            $parameters["active"] = $showtime->getActive();
            $parameters["view_date"] = $showtime->getDate();
            $parameters["hour"] = $showtime->getHour();
            $parameters["subtitles"] = $showtime->isSubtitle();
            $parameters["id_language"] = $showtime->getLanguage()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
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
            if (!empty($resultSet)) {
                return true;
            }else {
                return false;
            }

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

                $id_cinema=$resultSet[0]['id_cinema'];
                $cinema=$this->CinemasDAO->searchById($id_cinema);
                $showtime->setCinema($cinema);

                $id_language=$resultSet[0]['id_language'];
                $language=$this->LanguageDAO->searchById($id_language);
                $showtime->setLanguage($language);

                $id_movie=$resultSet[0]['id_movie'];
                $movie=$this->MoviesDAO->searchById($id_movie);
                $showtime->setMovie($movie);

                
                $showtime->setDate($resultSet[0]['view_date']);
                $showtime->setHour($resultSet[0]['hour']);
                $showtime->setSubtitle($resultSet[0]['subtitles']);
                if($resultSet[0]['active'] == 1){
                    $showtime->setActive(true);
                }else{
                    $showtime->setActive(false);
                }
                $showtime->setTicketAvaliable($resultSet[0]['ticketAvaliable']);

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

    public function getAll()
    {
        
        try {
            $this->showtimesList = array();
            $query = "SELECT * FROM" . ' ' . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {

                $Showtime = new Showtime();
                $Showtime->setShowtimeId($row['id']);

                $id_cinema=$row['id_cinema'];
                $cinema=$this->CinemasDAO->searchById($id_cinema);
                $Showtime->setCinema($cinema);

                $id_language=$row['id_language'];
                $language=$this->LanguageDAO->searchById($id_language);
                $Showtime->setLanguage($language);

                $id_movie=$row['id_movie'];
                $movie=$this->MoviesDAO->searchById($id_movie);
                $Showtime->setMovie($movie);

                $Showtime->setDate($row['view_date']);
                $Showtime->setHour($row['hour']);
                $Showtime->setSubtitle($row['subtitles']);
                if($row['active'] == 1){
                    $Showtime->setActive(true);
                }else{
                    $Showtime->setActive(false);
                }
                $Showtime->setTicketAvaliable($row['ticketAvaliable']);
                
                array_push($this->showtimesList, $Showtime);
            }
            return $this->showtimesList;
        } catch (\Throwable $th) {
            var_dump($th);
            throw $th;
        }
    }
    public function modify(Showtime $showtime) 
    {

        try {
            
            $query = "UPDATE " . " " . $this->tableName . " " . "SET id_language=:id_language, id_movie=:id_movie, id_cinema=:id_cinema, view_date=:view_date, hour=:hour, subtitles=:subtitles, active=:active, ticketAvaliable=:ticketAvaliable WHERE id=:id";

            $parameters["id_language"] = $showtime->getLanguage()->getId();
            $parameters["id_movie"] = $showtime->getMovie()->getId();
            $parameters["id_cinema"] = $showtime->getCinema()->getId();
            $parameters["view_date"] = $showtime->getDate();
            $parameters["hour"] = $showtime->getHour();
            $parameters["subtitles"] = $showtime->isSubtitle();
            $parameters["active"] = $showtime->getActive();
            $parameters["ticketAvaliable"] = $showtime->getTicketAvaliable();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}


?>