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
        UsersDAO::RetrieveData();

        return UsersDAO::$usersList;
    }


    static public function Add(User $user)
    {
            
        UsersDAO::RetrieveData();
        array_push(UsersDAO::$usersList,$user);
        UsersDAO::SaveData();
    }

    static public function Exists(User $user)
    {
        return in_array($user,UsersDAO::$usersList) ;
    }

    static private function SaveData()
    {
        $arrayToEncode = array();

        foreach(UsersDAO::$usersList as $user)
        {
            $valuesArray["email"] = $user->getLastName();
            $valuesArray["password"] = $user->getDni();
            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents('../Data/users.json', $jsonContent);
    }

    private function RetrieveData()
    {
        UsersDAO::$usersList = array();

        if(file_exists('../Data/users.json'))
        {
            $jsonContent = file_get_contents('../Data/users.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $user = new User($valuesArray["email"], $valuesArray["password"]);
                array_push(UsersDAO::$usersList, $user);
            }
        }
    }


}

?>

