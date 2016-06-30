
<?php

session_start();
include("../php/Session.class.php");
$sess = new Session();
$sess->Init();
$cookie = isset($_COOKIE["session"]); 
if($cookie) 
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
}


//$blurbtxt=$_POST["blurbEdit"]; //name of input

$action = $_POST['action'];
switch($action){
	case 'test': changeStatFunc();break;
}

function changeStatFunc() {
	
	$dbh = new mysqli("localhost","username","password","sqlserver");
 $change = "UPDATE accounts SET status= 'offline' WHERE username='".$account['username']."'";
    $change = $dbh->query($change);
    $dbh->query($change); //make query
		$dbh->close();
}


?>