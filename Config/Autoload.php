<?php namespace Config;

class Autoload {
     public static function start() {
          spl_autoload_register(function($classNotFound)
          {
               
               $class = dirname(__DIR__). '\\' . $classNotFound . '.php';
    
               include_once($class);
          });
     }
}

?>
