<?php

session_start();
include("Session.class.php");
$sess = new Session();
$sess->Init();
$cookie = isset($_COOKIE["session"]); 
//if($cookie) 
//{
//$cookie = $_COOKIE["session"];
//$account = $sess->Verify($cookie);
//}

$sess->Logout();
header('Location: ../register');

?>