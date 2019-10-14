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

   

    public function ExistsRegister(User $user){
        UsersDAO::RetrieveData();
        if(!empty(UsersDAO::$UsersList)){
            for ($i=0; $i < count(UsersDAO::$UsersList); $i++) { 
                if ($user->getEmail()==UsersDAO::$UsersList[$i]->getEmail()){
                    return false;
                }
            }
        }
            return $user;
        
    }

    public function ExistsLogin(User $user){
        UsersDAO::RetrieveData();
        if(!empty(UsersDAO::$UsersList)){
            for ($i=0; $i < count(UsersDAO::$UsersList); $i++) { 
                if ($user->getEmail()==UsersDAO::$UsersList[$i]->getEmail() && $user->getPassword()()==UsersDAO::$UsersList[$i]->getPassword()){
                    return UsersDAO::$UsersList[$i];
                }
            }
        }
            return false;
        
    }
    static private function SaveData()
    {
        $arrayToEncode = array();

        foreach(UsersDAO::$UsersList as $user)
        {
            $valuesArray["email"] = $user->getEmail();
            $valuesArray["password"] = $user->getPassword();
            $valuesArray['name']=$user->getName();
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
                $user->setName($valuesArray["name"]);
                array_push(UsersDAO::$UsersList, $user);
            }
        }
    }


}

?>

