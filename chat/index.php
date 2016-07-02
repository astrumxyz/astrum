<!DOCTYPE html>
<html>
	<head>
	<title>astrum chat</title>
	<link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<link rel="icon" type = "image/x-icon" href="../favicon2.ico" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
	<script type='text/javascript' src='../js/livemessages.js'></script>
    <script type='text/javascript' src='../js/chat.js'></script>
	</head>

	<body>
		
<?php

include("../php/Session.class.php");
$sess = new Session();
$sess->Init();
		
//echo '<div class="wrapper"></div>';

$cookie = isset($_COOKIE["session"]);

if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is singed in with invalid cookie
{
setcookie("session","",time()-1,"/");
header('Location: ../');
}

else //user is signed in with valid cookie
{

if(isset($_POST['logout'])){
	 $sess->Logout($account['username']);
}

if(isset($_POST['entermessage']) || isset($_POST['messagebox'])){
	$sess->EnterMessage($account);
}

//update last seen
	$sql2 = new mysqli("localhost","username","password","sqlserver");
		$stat = "UPDATE sqlserver.accounts SET status = 'online' WHERE username='".$account['username']."'";
		$stat = $sql2->query($stat);
		
		$t = "UPDATE sqlserver.accounts SET lastOnline = mktime() WHERE username='".$account['username']."'"; //may have to switch to mktime();
		$t = $sql2->query($t);
		$sql2->close();

echo '<div class="header">';
echo '<div id="menutoggle">
  <span></span>
  <span></span>
  <span></span>
</div>';
echo '<a href = "../" class= "title">ASTRUM.XYZ</a>';
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
    
echo '<form class="logoutframe" method="post" id="logout"><input class="logout" type="submit" name="logout" value="logout"></input></form>';
echo'</div>';
    
echo '<div class="chatframe">';

echo '<div class="messages" id="messagebox">';
    
echo '</div>';

echo '<form class="submitmessage" method="post">';
echo '<textarea class="messagebox" name="messagebox" autofocus="autofocus"></textarea>';
echo '<input class="button entermessage" type="submit" name="entermessage"></input>';
echo '</form>';
echo '</div>';
}
}

else { //user is not logged in, return to login screen
header('Location: ../');
}

?>
</body>
</html>