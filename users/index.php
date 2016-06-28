<!DOCTYPE html>
 <html>
<head>
<title>astrum chat</title>
 <link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
<link rel="icon" type = "image/x-icon" href="../favicon2.ico" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type='text/javascript' src='../js/script.js'></script>
	<script type='text/javascript' src='../js/home.js'></script>
<script type='text/javascript' src='../js/livemessages.js'></script>
<script type='text/javascript' src='../js/users.js'></script>
</head>
<body style = "background: url('../images/cyanwhitebackground.png');background-size:cover;background-attachment:fixed";>
<?php
include("../php/Session.class.php");
$sess = new Session();
$sess->Init();
$cookie = isset($_COOKIE["session"]);
if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is signed in with invalid cookie
{
setcookie("session","",time()-1,"/");
header('Location: ../');
}
else //user is signed in with valid cookie
{
if(isset($_POST['logout'])){
 $sess->Logout($account['username']);
}
}
echo '<div class="header">';
echo '<div id="menutoggle">
  <span></span>
  <span></span>
  <span></span>
</div>';
	echo '<p class= "title">ASTRUM.XYZ</p>';
echo '</div>';
echo '<div class="menubar">';
echo '<nav class="circle">';    
echo '<ul>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/home">'.$account['username'].'</a></li>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/chat">chat</a></li>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/settings">settings</a></li>';
echo '<li class="menubutton"><a class="menutext" href="http://astrum.xyz/users">users</a></li>';
echo '</ul>';
echo '<form class="logoutframe" method="post" id="logout"><input class="logout" type="submit" name="logout" value="logout"></input></form>';
echo'</div>';
echo '<div class="wrapper">';
echo '<form class="usersearch" method="post"><input class="searchbar" name="searchbar"></input><input type="submit" class="submitsearch" value="search" name="submitsearch"></input></form>';
if(isset($_POST['submitsearch']) || isset($_POST['searchbar'])){
$sess->getUsers();
echo '</div>';
}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}
?>
</body>
</html>