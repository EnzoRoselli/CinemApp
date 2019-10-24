<?php
 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	require "Config/Autoload.php";
    require "Config/Config.php";
	require "Config/Constants/CineConstants.php";
	require "Config/Constants/ShowtimeConstants.php";
	require "Config/Constants/UserConstants.php";
//	require "Controllers/ExceptionController.php" y hacer el use despues

	use Config\Autoload as Autoload;
	use Config\Router 	as Router;
	use Config\Request 	as Request;
		
	Autoload::start();

	session_start();

	Router::Route(new Request());

?>