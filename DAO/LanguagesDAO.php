<?php

namespace DAO;

use Model\Language as Language;

class LanguagesDAO
{
    private $connection;
    private $tableName = "languages";
    private  $LanguagesList = array();

    public function add($language)
    {
        try {
            if (!$this->exists($language)) {

                $query = "INSERT INTO " . " " . $this->tableName . " " .
                    " (name_language) VALUES (:name_language);";

                $parameters["name_language"] = $language;

                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
        } catch (\Throwable $ex) {

            throw $ex;
        }
    }

    public function addAll()
    {
        try {

            $languages = array();
            array_push($languages, "English", "Spanish", "French", "Italian", "Portuguese");

            foreach ($languages as $language) {
                if (!$this->exists($language)) {


                    $query = "INSERT INTO " . " " . $this->tableName . " " .
                        " (name_language) VALUES (:name_language);";

                    $parameters["name_language"] = $language;

                    $this->connection = Connection::GetInstance();
                    $this->connection->ExecuteNonQuery($query, $parameters);
                }
            }
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }
    public function exists($language)
    {

        $query = "SELECT * FROM " . " " . $this->tableName . " WHERE name_language = :name_language;";

        $parameters["name_language"] = $language;
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


        $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id=:id";

        $parameters["id"] = $id;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if ($resultSet != null) {
                $Language = new Language();
                $Language->setID($resultSet[0]["id"]);
                $Language->setName($resultSet[0]["name_language"]);
                return $Language;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function searchByName($language)
    {


        $query = "SELECT * FROM " . " " . $this->tableName . " WHERE name_language=:name_language";

        $parameters["name_language"] = $language;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if ($resultSet != null) {
                $language = new Language();
                $language->setID($resultSet[0]["id"]);
                $language->setName($resultSet[0]["name_language"]);
                return $language;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete($name)
    {

        $query = "DELETE" . " " . "FROM" . " " . $this->tableName . " " . " WHERE name=:name";
        $parameters["name"] = $name;
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


        $this->addAll();
        $query = "SELECT * FROM" . ' ' . $this->tableName;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {

                $Language = new Language();
                $Language->setId($row['id']);
                $Language->setName($row['name_language']);

                array_push($this->LanguagesList, $Language);
            }
            return $this->LanguagesList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
