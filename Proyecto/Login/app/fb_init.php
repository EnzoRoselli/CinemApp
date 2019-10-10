<?php 

require 'src/facebook-sdk-v5/autoload.php';

session_start();

$fb=new Facebook\Facebook([
    'app_id'=>'2441738829278000',
    'app_secret' =>'c24e1dfc46b1823c28da0ea3a3cb2b6c',
'default_graph_version'=> 'v4.0',



])


?>