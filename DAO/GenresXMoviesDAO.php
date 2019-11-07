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
        try {
            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (id_movie, id_genre) VALUES (:id_movie,:id_genre);";

            $parameters["id_movie"] = $genre_x_movie->getMovieId();
            $parameters["id_genre"] = $genre_x_movie->getGenreId();
            
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {

            throw $ex;
        }
    }

    public function exists(GenreXMovie $genre_x_movie)
    {
        try {
            $query = "SELECT * FROM" . " " . $this->tableName . " WHERE id_movie=:id_movie AND id_genre=:id_genre";

            $parameters["id_movie"] = $genre_x_movie->getMovieId();
            $parameters["id_genre"] = $genre_x_movie->getGenreId();

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
        try {
            $this->genreXmovieList = array();

            $query = "SELECT * FROM" . ' ' . $this->tableName . " " . "order by id_movie asc";

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

    public function getMoviesByGenresIds($genreIds){

        $moviesDAO = new MoviesDAO();
        $allMovies = $moviesDAO->getAll();
        $moviesList = array();
        $genreXmovieList = $this->getGenresXMoviesByGenresIds($genreIds);

        for ($i=0; $i < count($allMovies); $i++) { 
            
            $counter=0;

            for ($j=0; $j < count($genreXmovieList); $j++) { 
                
                if($allMovies[$i]->getId() == $genreXmovieList[$j]->getMovieId()){

                    $counter++;
                }
                
                if($counter == count($genreIds)){    
                    
                    array_push($moviesList, $allMovies[$i]);
                    break;
                }
            }
        }

        return $moviesList;
    }

    public function getGenresXMoviesByGenresIds($genreIds){

        $this->genreXmovieList = array();

        foreach ($genreIds as $genreId) {
            
            $query = "SELECT * FROM" . ' ' . $this->tableName . " " . "WHERE id_genre = :id_genre";

            $parameters["id_genre"] = $genreId;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {

                $genre_x_movie = new GenreXMovie();

                $genre_x_movie->setMovieId($row['id_movie']);
                $genre_x_movie->setGenreId($row['id_genre']);

                array_push($this->genreXmovieList, $genre_x_movie);
            }
        }

        return $this->genreXmovieList;
    }

    

}
