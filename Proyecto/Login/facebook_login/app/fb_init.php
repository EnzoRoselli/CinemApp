  
<?php

require 'src/facebook-sdk-v5/autoload.php';

session_start();
$fb = new Facebook\Facebook([
  'app_id' => '813232129072515',
  'app_secret' => 'd7aebd3aa8d6589c5f5bedb11ba9fb8d',
  'default_graph_version' => 'v2.2',
  ]);