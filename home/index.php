<!DOCTYPE html>
<html>
	<head>
	<title>Astrum</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<link rel="icon" type = "image/x-icon" href="../favicon2.ico" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
    <script type='text/javascript' src='../js/home.js'></script>
	</head>
<body style='background:#53e3a6'> 
<?php
//;background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);"
include("../php/Session.class.php");
$sess = new Session();
$sess->Init();

echo '<div class="wrapper"></div>';

$cookie = isset($_COOKIE["session"]); //mmm...cookiessss...

if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is singed in with invalid cookie
{
setcookie("session","",time()-1);
header('Location: /home');
	
}

else //user is signed in with valid cookie
{

if(isset($_POST['logout'])){
    $sess->Logout($account['username']);
}
	
	//update last seen
	$sql2 = new mysqli("localhost","username","password","sqlserver");
		$stat = "UPDATE sqlserver.accounts SET status = 'online' WHERE username='".$account['username']."'";
		$stat = $sql2->query($stat);
		
		$t = "UPDATE sqlserver.accounts SET lastOnline = now() WHERE username='".$account['username']."'"; //may have to switch to mktime();
		$t = $sql2->query($t);
		$sql2->close();

echo '<div class="header">';
//echo '<img id="menutoggle" src="../images/menuiconwhite.png"></img>';
echo '<div class = "menubox">';
echo '<div id="menutoggle">
  <span></span>
  <span></span>
  <span></span>
</div>';
echo '</div>';
echo '<a href = "#" class= "title">ASTRUM.XYZ</a>';
echo '</div>';
echo '<div class="menubar">';
echo '<nav class="circle">';    
echo '<ul>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/home">'.$account['username'].'</a></li>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/chat">chat</a></li>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/settings">settings</a></li>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/users">users</a></li>';
	echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/pm">dm</a></li>';
echo '</ul>';
echo '</nav>'; 
    
echo '<form class="logoutframe" method="post" id="logout"><input class="logout" type="submit" name="logout" value="logout"></input></form>';
echo'</div>';
    
echo '<h1 class="headertext">Welcome back.</h1>';
    
}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}

?>
</body>
</html>