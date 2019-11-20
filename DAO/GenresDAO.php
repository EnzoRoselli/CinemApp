<?php

namespace DAO;

use Model\Genre as Genre;

class GenresDAO
{
    private $genreList;
    private $connection;
    private $tableName = "genres";

    public function __construct()
    {
        $this->genreList = array();
    }

    public function add(Genre $genre)
    {

        $query = "INSERT INTO " . " " . $this->tableName . " " .
            " (genre_name) VALUES
                (:genre_name);";
        $parameters["genre_name"] = $genre->getName();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }
    public function exists(Genre $genre)
    {

        $query = "SELECT * FROM" . " " . $this->tableName . " WHERE genre_name=:genre_name";
        $parameters["genre_name"] = $genre->getName();
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

    public function getAll()
    {

        $this->genreList = array();
        $query = "SELECT * FROM" . ' ' . $this->tableName;
        try {
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

    public function getGenresByMovieId($movieId)
    {
        $genreList = array();

        $query = "select genres.genre_name from " . $this->tableName . " " . "
        inner join genres_by_movies on genres_by_movies.id_genre=genres.id and genres_by_movies.id_movie=:movieId;";
        $parameters["movieId"] = $movieId;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            foreach ($resultSet as $genreName) {
                array_push($genreList, $genreName['genre_name']);
            }
            return $genreList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
