<?php namespace Config;

// BACK PATH
define("ROOT", dirname(__DIR__));
define('VIEWS', ROOT . '/Views');
define("JSON", ROOT . "/data");

//Path to your project's root folder

//FRONT PATH
define("FRONT_ROOT", "http://localhost/Proyecto");
// //PARA LA COMPU DE MATI 
// define("FRONT_ROOT", "http://localhost:90/Final-Tp-Lab4");
define("VIEWS_PATH", FRONT_ROOT . "/Views");
define("CSS_PATH", VIEWS_PATH . "/css");
define("JS_PATH", VIEWS_PATH . "/js");
define("IMG_PATH", VIEWS_PATH . "/img");


// echo ROOT;
// echo FRONT_ROOT;
// echo VIEWS_PATH;
// echo CSS_PATH;
// echo JS_PATH;
// echo IMG_PATH;

//DATABASE 
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_NAME","CINEMAPP");
//define("DB_PASS","");
define("DB_PASS","");



?>

