<!DOCTYPE html>
<html>
	<head>
	<title>Astrum</title>
	<link rel='stylesheet' type='text/css' href='css/loginsheet.css'/>
	<link rel="icon" type = "image/x-icon" href="favicon2.ico" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type='text/javascript' src='js/script.js'></script>
    <script type='text/javascript'  src="js/login.js"></script>
    <script type='text/javascript' src="js/three.min.js"></script>
    <script type='text/javascript' src="js/tween/TweenMax.min.js"></script>
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script src="http://threejs.org/examples/js/controls/OrbitControls.js"></script>
        <script src="js/stats.min.js"></script>
        
	</head>
<body>
<?php
include("php/Session.class.php");
$sess = new Session();
$sess->Init();
$cookie = isset($_COOKIE["session"]); //mmm...cookiessss...
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
header('Location: /home');
}
}
else { //user is not logged in, display login screen
if(isset($_POST['login'])){
	$sess->Login();
}
echo '<div class="wrapper">';
echo '<div class="container">';
echo '<h1 id="titleHead">Astrum</h1>';
echo '<div id ="planet"></div>';
echo '<form class="form" id="login" method="post">';
echo '<input type="text" placeholder="Username" name="username">';
echo '<input type="password" placeholder="Password" name="password">';
echo '<button type="submit" id="login-button" name="login">Login</button>';
echo '</form>';
echo '<a href="/register" style="text-decoration: none;font-size:14px; color: white;z-index:3;position:relative">dont have an account? go sign up</a>';

//echo '<div class="about">Z&S</div>';
echo '<div></div>';
echo '<a class ="about" href="/about">Z&S</a>';
    
echo '</div>';
echo '<ul class="bg-bubbles">';
echo '<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>';
echo '</ul>';
echo '</div>';
//echo '</form>';
//echo '</div>';
} //end of login screen
?>
    <script type='text/javascript' src="js/planet.js"></script>

</body>
</html>