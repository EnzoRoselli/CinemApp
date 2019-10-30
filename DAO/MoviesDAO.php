<?php

namespace DAO;

use Controllers\MovieController as MovieController;
use Model\Movie as Movie;
//CASTEAR EN LOS SEARCHBYID
class MoviesDAO
{
    private $moviesList  = array();
    private $connection;
    private $tableName = "movies";

    public function add(Movie $movie)
    {
        try {
            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (title, duration,original_language,overview,release_date,adult,poster_path) VALUES
                (:title,:duration,:original_language,:overview,:release_date,:adult,:poster_path);";

            $parameters["title"] = $movie->getTitle();
            $parameters["duration"] = $movie->getDuration();
            $parameters["original_language"] = $movie->getOriginalLanguage();
            $parameters["overview"] = $movie->getOverview();
            $parameters["release_date"] = $movie->getReleaseDate();
            if($movie->getAdult()){
                $parameters["adult"] = 1;
            }else{
                $parameters["adult"] = 0;
            }
            $parameters["poster_path"] = $movie->getPosterPath();
            
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {

            throw $ex;
        }
    }
    public function exists($movie)
    {

        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE title=:title";

            $parameters["title"] = $movie;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet) ) {
                $movie = new Movie();
                $movie->setId($resultSet[0]['id']);
                $movie->setTitle($resultSet[0]['title']);
                $movie->setDuration($resultSet[0]['duration']);
                $movie->setOriginalLanguage($resultSet[0]['original_language']);
                $movie->setOverview($resultSet[0]['overview']);
                $movie->setReleaseDate($resultSet[0]['release_date']);
                $movie->setAdult($resultSet[0]['adult']);
                $movie->setPosterPath($resultSet[0]['poster_path']);
                return $movie;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll(){
        try {
            //$movieController=new MovieController();
            //$movieController->sendToDataBase();
            $this->moviesList = array();
            $query = "SELECT * FROM" . ' ' . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {

                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setTitle($row['title']);
                $movie->setOriginalLanguage($row['original_language']);
                $movie->setDuration($row['duration']);
                $movie->setOverview($row['overview']);
                $movie->setReleaseDate($row['release_date']);
                $movie->setPosterPath($row['poster_path']);
                if($row['adult'] == 1){
                    $movie->setAdult(true);
                }else{
                    $movie->setAdult(false);
                }
                
                array_push($this->moviesList, $movie);
            }

            return $this->moviesList;
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

            $resultSet = $this->connection->Execute($query, $parameters);
            if ($resultSet != null) {
                $movie = new Movie();
                $movie->setId((int) $resultSet[0]["id"]);
                $movie->setTitle($resultSet[0]["title"]);
                $movie->setDuration($resultSet[0]["duration"]);
                $movie->setOriginalLanguage($resultSet[0]["original_language"]);
                $movie->setOverview($resultSet[0]["overview"]);
                $movie->setReleaseDate($resultSet[0]["release_date"]);
                $movie->setAdult($resultSet[0]["adult"]);
                $movie->setPosterPath($resultSet[0]["poster_path"]);

                return $movie;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete($id)
    {
        try {
            $query = "DELETE" . " " . "FROM" . " " . $this->tableName . " " . " WHERE id=:id";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}
