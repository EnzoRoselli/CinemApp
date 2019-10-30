<?php
    namespace DAO;
    use Model\Genre as Genre;

    class GenresDAO{
        private $genreList;
        private $connection;
        private $tableName = "genres";

        public function __construct(){
            $this->genreList = array();
        }

        public function add(Genre $genre)
    {
        try {
            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (genre_name) VALUES
                (:genre_name);";
            $parameters["genre_name"] = $genre->getName();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function getAll(){
        try {
            $this->genreList = array();
            $query = "SELECT * FROM" . ' ' . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {
                $genre = new Genre();
                $genre->setId($row['id']);
                $genre->setName($row['genre_name']);
                array_push($this->genreList, $genre);
            }
            return $this->genreList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    }
?>