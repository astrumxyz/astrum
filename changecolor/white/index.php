
<?php

session_start();
include("../../php/Session.class.php");
$sess = new Session();
$sess->Init();
$cookie = isset($_COOKIE["session"]); 
if($cookie) 
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
}


echo 'color easter egg!';

$dbh = new mysqli("localhost","username","password","sqlserver");
 $change = "UPDATE accounts SET color= '#ffffff' WHERE username='".$account['username']."'";
    $change = $dbh->query($change);
    $dbh->query($change); //make query
		$dbh->close();

header("Refresh:0; url=../../chat");

?>