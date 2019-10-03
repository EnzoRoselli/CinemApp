<?php

namespace Config;

spl_autoload_register(function($classPath)
{
   
    $class = dirname(__DIR__). '\\' . $classPath . '.php';
    
    include_once($class);
    
});

?>
