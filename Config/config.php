<?php namespace Config;

// BACK PATH
define("ROOT", dirname(__DIR__));
define('VIEWS', ROOT . '/Views');
define("JSON", ROOT . "/data");


//FRONT PATH
//  define("FRONT_ROOT", "http://localhost/CinemApp");


// //PARA LA COMPU DE MATI 
define("FRONT_ROOT", "http://localhost:90/CinemApp");       

//////////////////////////////////
define("VIEWS_PATH", FRONT_ROOT . "/Views");
define("CSS_PATH", VIEWS_PATH . "/css");
define("JS_PATH", VIEWS_PATH . "/js");
define("IMG_PATH", VIEWS_PATH . "/img");
//////////////////////////////



//DATABASE 
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_NAME","CINEMAPP");
define("DB_PASS", "root");
//PARA EL NEGRO
// define("DB_PASS", "");



?>