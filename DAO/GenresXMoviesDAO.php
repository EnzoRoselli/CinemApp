<?php

namespace DAO;

use Model\Genre as Genre;
use Model\Movie as Movie;
use Model\GenreXMovie as GenreXMovie;
use DAO\MoviesDAO as MoviesDAO;

class GenresXMoviesDAO
{
    private $genreXmovieList = array();
    private $connection;
    private $tableName = "genres_by_movies";


    public function add(GenreXMovie $genre_x_movie)
    {

        $query = "INSERT INTO " . " " . $this->tableName . " " .
            " (id_movie, id_genre) VALUES (:id_movie,:id_genre);";

        $parameters["id_movie"] = $genre_x_movie->getMovieId();
        $parameters["id_genre"] = $genre_x_movie->getGenreId();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {

            throw $ex;
        }
    }

    public function exists(GenreXMovie $genre_x_movie)
    {

        $query = "SELECT * FROM" . " " . $this->tableName . " WHERE id_movie=:id_movie AND id_genre=:id_genre";

        $parameters["id_movie"] = $genre_x_movie->getMovieId();
        $parameters["id_genre"] = $genre_x_movie->getGenreId();
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

        $this->genreXmovieList = array();

        $query = "SELECT * FROM" . ' ' . $this->tableName . " " . "order by id_movie asc";
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {

                $genre_x_movie = new GenreXMovie();

                $genre_x_movie->setMovieId($row['id_movie']);
                $genre_x_movie->setGenreId($row['id_genre']);

                array_push($this->genreXmovieList, $genre_x_movie);
            }

            return $this->genreXmovieList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMoviesByGenreId($genreId)
    {

        $moviesIdByGenre = array();

        $query = "SELECT m.*  FROM movies m 
            INNER JOIN genres_by_movies x ON m.id = x.id_movie 
            INNER JOIN showtimes s ON m.id = s.id_movie AND s.active = true
            INNER JOIN theaters t ON s.id_theater = t.id AND t.active = true
            WHERE x.id_genre = :id_genre
            GROUP BY m.id";


        $parameters["id_genre"] = $genreId;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {

                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setTitle($row['title']);
                $movie->setOriginalLanguage($row['original_language']);
                $movie->setDuration($row['duration']);
                $movie->setOverview($row['overview']);
                $movie->setReleaseDate($row['release_date']);
                $movie->setPosterPath($row['poster_path']);

                array_push($moviesIdByGenre, $movie);
            }

            return $moviesIdByGenre;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
