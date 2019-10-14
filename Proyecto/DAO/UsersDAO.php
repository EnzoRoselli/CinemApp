<?php 
namespace DAO;

require "../Config/Autoload.php";

use config\autoload as autoload;

autoload::Start();
use Model\User as User;


class UsersDAO  
{
    static private $UsersList=array();
    public function __construct() {
       
    }

    public function GetAll(){
        $this->RetrieveData();

        return $this->userList;
    }


    static public function Add(User $user)
    {
            
        $this->RetrieveData();
        array_push($this->UsersList,$user);
        $this->SaveData();
    }

    static public function Exists(User $user)
    {
        return in_array($user,$this->UsersList) ;
    }

    static private function SaveData()
    {
        $arrayToEncode = array();

        foreach(UsersDAO::$userList as $user)
        {
            $valuesArray["name"] = $user->getFirstName();
            $valuesArray["email"] = $user->getLastName();
            $valuesArray["password"] = $user->getDni();


            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents('../Data/users.json', $jsonContent);
    }


}

?>

