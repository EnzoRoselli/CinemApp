<?php 
session_start();
unset($_SESSION['facebook_access_token']);
header('Location: LoginSignup.php');