<!DOCTYPE html>
<html>
	<head>
	<title>register</title>
	<link rel='stylesheet' type='text/css' href='../css/loginsheet.css'/>
	<link rel="icon" type = "image/x-icon" href="../favicon2.ico" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
    <script src="../js/login.js"></script>
	</head>

	<body>
<?php
		
session_start();
$_SESSION['error'] = "no";
echo $_SESSION['error'];

include("../php/Session.class.php");
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
header('Refresh:0');
}

else //user is signed in with valid cookie
{
header('Location: ../');
}
}
else { //user is not logged in, display login screen

if(isset($_POST['create'])){
	$sess->CreateAccount($_SERVER['REMOTE_ADDR']);
}

echo '<div class="wrapper">';
echo '<div class="container">';
echo '<h1 id="titleHead">register</h1>';

echo '<form class="form" id="login" method="post" style="padding-top: 70px">';
if($_SESSION['error']=="yes")
{
echo '<p class="regError"style="padding-bottom: 20px;color: white;z-index:3;position:relative;font-size: 12px;">sorry, username taken!</p>';
}
echo '<input type="text" placeholder="Username" name="username">';
echo '<input type="password" placeholder="Password" name="password">';
echo '<button type="submit" id="login-button" name="create">Register</button>';
echo '</form>';
echo '<a href="../" style="text-decoration: none;color: white;z-index:3;position:relative;font-size: 14px;">already have an account? log in.</a>';
echo '</div>';
echo '<ul class="bg-bubbles">';
echo '<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>';
echo '</ul>';
echo '</div>';
//echo '</form>';

//echo '</div>';

} //end of login screen

?>
</body>
</html>