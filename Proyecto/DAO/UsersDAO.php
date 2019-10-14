<?php 

namespace DAO;


use Model\User as User;


class UsersDAO  
{
    static private $UsersList=array();

    public function __construct() {
       
    }

    public function GetAll(){
        UsersDAO::RetrieveData();

        return UsersDAO::$UsersList;
    }


    static public function Add(User $user)
    {
            
        UsersDAO::RetrieveData();
        array_push(UsersDAO::$UsersList,$user);
        UsersDAO::SaveData();
    }

   

    public function Exists(User $user){
        UsersDAO::RetrieveData();
        if(!empty(UsersDAO::$UsersList)){
            return in_array($user,UsersDAO::$UsersList) ;
        }else {
            return false;
        }
    }

    static private function SaveData()
    {
        $arrayToEncode = array();

        foreach(UsersDAO::$UsersList as $user)
        {
            $valuesArray["email"] = $user->getEmail();
            $valuesArray["password"] = $user->getPassword();
            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        
        file_put_contents('../../Data/users.json', $jsonContent);
    }

   static private function RetrieveData()
    {
        UsersDAO::$UsersList = array();

        if(file_exists('../../Data/users.json'))
        {
            $jsonContent = file_get_contents('../../Data/users.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $user = new User($valuesArray["email"], $valuesArray["password"]);
                array_push(UsersDAO::$UsersList, $user);
            }
        }
    }


}

?>

