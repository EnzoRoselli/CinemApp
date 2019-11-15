<?php

namespace DAO;

use Model\User as User;

class UsersDAO
{

    private $userList = array();
    private $connection;
    private $tableName = "users";


    public function add(User $user)
    {
        try {

            $query = "INSERT INTO " . " " . $this->tableName . " " .
                " (password, email, firstname, lastname, dni) VALUES
             (:password, :email, :firstname, :lastname, :dni);";

            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            $parameters["firstname"] = $user->getName();
            $parameters["lastname"] = $user->getLastName();
            $parameters["dni"] = $user->getDni();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {

            throw $ex;
        }
    }

    public function delete($username)
    {
        $user = $this->searchByusername($username);

        if (($key = array_search($user, $this->userList)) !== false) {
            $this->userList[$key]->setActive(false);
        }

        $this->saveData();
    }
    public function searchById($id)
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id=:id";
        $parameters["id"] = $id;
        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
           
            if (!empty($resultSet)) {
                $user = new User();
                $user->setId($resultSet[0]['id']);
                $user->setPassword($resultSet[0]['password']);
                $user->setEmail($resultSet[0]['email']);
                $user->setName($resultSet[0]['firstname']);
                $user->setLastName($resultSet[0]['lastname']);
                $user->setDni($resultSet[0]['dni']);
                return $user;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function searchByUsername($username)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE username=:username";

            $parameters["username"] = $username;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
        } catch (\Throwable $th) {
            throw $th;
        }

        return null;
    }

    public function getAll()
    {
        try {
            $this->userList = array();
            $query = "SELECT * FROM" . ' ' . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            foreach ($resultSet as $row) {

                $user = new User($row['email'], $row['password']);
                $user->setUsername($row['username']);
                $user->setName($row['name']);
                $user->setLastName($row['lastname']);
                $user->setDni($row['dni']);
                array_push($this->userList, $user);
            }
            return $this->userList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function correctCredentials(User $user)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE password=:password and email=:email";

            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            return $resultSet;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function existsDNI(User $user)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE dni=:dni";

            $parameters["dni"] = $user->getDni();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            return $resultSet;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function existsUserFromSignUp(User $user)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE dni=:dni or email=:email ";
            $parameters["dni"] = $user->getDni();
            $parameters["email"] = $user->getEmail();
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            //TESTEO SI EXISTE ALGUNO YA SEA CON DNI OR EMAIL, SI NINGUN REGISTRO SE RELACIONA SE CARGA
            if (empty($resultSet)) {
                return false;
            } else {
                //SI HAY UN REGISTRO QUE CONTIENE EL DNI O EMAIL, CORROBORRO CUAL ES, SI IGUAL EMAIL O DNI
                $errores = array();
                if (!empty($this->existsEmail($user))) {
                    array_push($errores, EMAIL_EXISTS);
                }
                if (!empty($this->existsDNI($user))) {
                    array_push($errores, ID_NUMBER_EXISTS);
                }
                return $errores;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function existsEmail(User $user)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE email=:email";

            $parameters["email"] = $user->getEmail();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            return $resultSet;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
