<?php 
namespace DAO;

use Controllers\SearchMovieController;
use Model\Movie;

class MoviesDAO  
{
    private $moviesList  = array();
    private $connection;
    private $tableName = "movie";

    public function add(Movie $movie)
    {
        try {
                    $query = "INSERT INTO " . " " . $this->tableName . " " .
                        " (id, title, duration,original_language,overview,release_date,adult,poster_path) VALUES
                                        (:id,:title,:duration,:original_language,:overview,:release_date,:adult,:poster_path);";
    
    
                    $parameters["id"] = $movie->getMovieId();;
                    $parameters["title"] = $movie->getTitle();
                    $parameters["duration"] = $movie->getDuration();
                    $parameters["original_language"] = $movie->getOriginalLanguage();
                    $parameters["overview"] = $movie->getOverview();
                    $parameters["release_date"] = $movie->etReleaseDate();
                    $parameters["adult"] = $movie->getAdult();
                    $parameters["poster_path"] = $movie->getSubtitles();
    
                    $this->connection = Connection::GetInstance();
                    $this->connection->ExecuteNonQuery($query, $parameters);
                

            } catch (\Throwable $ex) {

                throw $ex;
            }
    }
    public function exists(Movie $movie)
    {
       
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE title=:title";

            $parameters["title"] = $movie->getTitle();
           
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

    public function searchById($id)
    {
      
        try {
            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id=:id";

            $parameters["id"] = $id;
            
            $this->connection = Connection::GetInstance();
         
            $resultSet = $this->connection->Execute($query,$parameters);
            if ($resultSet!=null) {
                $Movie=new SearchMovieController();
                $Movie->setID($resultSet[0]["id"]);
                $Movie->setTitle($resultSet[0]["title"]);
                $Movie->setDuration($resultSet[0]["duration"]);
                $Movie->setOriginalLanguage($resultSet[0]["original_language"]);
                $Movie->setOverview($resultSet[0]["overview"]);
                $Movie->getReleaseDate($resultSet[0]["release_date"]);
                $Movie->getAdult($resultSet[0]["adult"]);
                $Movie->getPosterPath($resultSet[0]["poster_path"]);
                
                return $Movie;
            }else {
                return null;
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
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }



    
}













?>