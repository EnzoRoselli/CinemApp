<?php 
namespace DAO;

require "../Config/Autoload.php";

use config\autoload as autoload;

autoload::Start();
use Model\User as User;


class UsersDAO  
{
    static private $UsersList;

    static public function Add(User $user)
    {
        array_push($this->UsersList,$user);
    }

    static public function Exists(User $user)
    {
        return in_array($user,$this->UsersList) ;
    }


}

?>