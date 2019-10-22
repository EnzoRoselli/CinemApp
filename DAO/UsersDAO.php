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
            " (email, password, name) VALUES
             (:email,:password,:name);";

            $parameters["name"] = $user->getEmail();
            $parameters["address"] = $user->getPassword();
            $parameters["capacity"] = $user->getName();

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

    public function searchByUsername($username)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . "WHERE username=:username";

            $parameters["username"] = $username;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
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

        
    public function existsUser(User $user)
    {
        try {

            $query = "SELECT * FROM " . " " . $this->tableName . "WHERE username=:username and email=:email";

            $parameters["username"] = $user->getUsername();
            $parameters["email"] = $user->getEmail();

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }

        return null;
    }
    
}

?>

