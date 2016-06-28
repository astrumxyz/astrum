<!DOCTYPE html>
<html>
	<head>
	<title>ζeta</title>
	<link rel='stylesheet' type='text/css' href='css/stylesheet.css'/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type='text/javascript' src='js/script.js'></script>
	</head>

	<body style = "background: url('images/backgroundplanet.png');background-size:cover;background-attachment:fixed";>
<?php

include("../../php/Session.class.php");
$sess = new Session();
$sess->Init();

$cookie = isset($_COOKIE["session"]);

if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is singed in with invalid cookie
{
setcookie("session","",time()-1);
}

else //user is signed in with valid cookie
{

if(isset($_POST['logout'])){
	$sess->Logout();
}

echo '<div class="menu">';
echo '<div class="menutext">'.$account['username'].'</div>';
echo '<a class="menubutton" href="/chat">chat</a>';

echo '<form class="menubutton logoutframe" method="post"><input class="logout logoutbutton" type="submit" name="logout" value="logout"></input></form>';
echo '</div>';
}

}

$path = dirname($_SERVER['PHP_SELF']);
$position = strrpos($path,'/') + 1;
$username=substr($path,$position);
echo $username;

?>
</body>
</html>