<!DOCTYPE html>
<html>
	<head>
	<title>Astrum Profile</title>
	<link rel='stylesheet' type='text/css' href='../../css/stylesheet.css'/>
	<link rel="icon" type = "image/x-icon" href="../../favicon2.ico" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type='text/javascript' src='../../js/script.js'></script>
    <script type='text/javascript' src='../../js/home.js'></script>
	
	
	</head>

	<body>
<?php

include("../../php/Session.class.php");
$sess = new Session();
$sess->Init();

//Get profile username		
$path = dirname($_SERVER['PHP_SELF']);
$position = strrpos($path,'/') + 1;
$username=substr($path,$position);
//echo "User is ".$username;		

$cookie = isset($_COOKIE["session"]);

if($cookie) //check if cookie exists for login
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
if($account==0) //user is singed in with invalid cookie
{
setcookie("session","",time()-1);
header('Location: ../home'); //this isnt working
	
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
echo '<div class="wrapper">';
echo '<h1 class = "profileh">'.$username.'</h1>';

}

}
else {
	header('Location: ../');
	
}

//Get user id for image		
$sql = new mysqli("localhost","username","password","sqlserver");
		$id = "SELECT * FROM sqlserver.accounts WHERE username ='".$username."'";
		//echo $id;
		//$id = "SELECT id FROM sqlserver.accounts WHERE username =";
		$id=$sql->query($id);
		$sql->close();
		$id=$id->fetch_assoc();
		//echo $id['id'];
		
		//echo $id['time']."\n";
		//echo $id['blurb'];
		
		$yr = (string) $id['time'];
		$yr = substr($yr,0,4);
		
		$mnth = (string) $id['time'];
		$mnth = substr($mnth,5,2);
		
		$day = (string) $id['time'];
		$day = substr($day,8,2);
		//echo $day;
		
		$blurb = $id['blurb'];
		if($blurb == "")
		{
			$blurb = "They haven't told us anything yet!";
		}
		
		//sql for status update
		$sql = new mysqli("localhost","username","password","sqlserver");
		
		$status = $id['status'];
		if($status == null)
		{
			$status = "offline";
			$stat = "UPDATE sqlserver.accounts SET status = 'offline' WHERE username='".$username."'";
		$stat = $sql->query($stat);
			
		}
		
		$time = (string) $id['lastOnline'];
		$timeElapse = substr($time,11, 2);
		
		
		$current = mktime();
		$elapsed = strtotime($time);

		//update status to display
		if(($current-$elapsed >= 32000 && $current-$elapsed <= 72000) && ($status == "online" || $status == "away"))
		{
			//over 2 hrs
			$stat2 = "UPDATE sqlserver.accounts SET status = 'away' WHERE username='".$username."'";
		$stat2 = $sql->query($stat2);
			$status = "away";
		}
		elseif ($current-$elapsed >= 72000 && ($status == "online" || $status == "away"))
		{
			$status = "offline";
			$stat3 = "UPDATE sqlserver.accounts SET status = 'offline' WHERE username='".$username."'";
		$stat3 = $sql->query($stat3);
		}
		
		$mood = $id['moodStatus'];
		if($mood == null)
		{
			$mood = "(we assume they're) pretty good";
		}
		
//Image		
		
$dbh = new PDO("mysql:host=localhost;dbname=sqlserver", 'username', 'password');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
//Get user image
$sql = "SELECT image, image_type FROM imageblob WHERE user_id= ".$id['id'];//test
//$sql = "SELECT image, image_type FROM imageblob WHERE user_id=".$id;		
   
/*** prepare the sql ***/
$stmt = $dbh->prepare($sql);
/*** exceute the query ***/
$stmt->execute(); 
/*** set the fetch mode to associative array ***/
$stmt->setFetchMode(PDO::FETCH_ASSOC);
/*** set the header for the image ***/
$array = $stmt->fetch();
 /*** check we have a single image and type ***/
 if((sizeof($array) == 2) && empty($array['image']) == false)
 {
     
     $imgdata = $array['image']; //store img src
	 $src = 'data:image/jpeg;base64,'.$imgdata;
	 //echo 'There are images';
 }
 else
 {
	 //echo 'no images';
	 $src = '../../images/noimage3.png';

 }

		
echo '<div class = "profileimage">';
echo '<img src="'.$src.'"/></div>';

echo '<p class = statHeader>Activity: '.$status.'</p>';
		echo '<p class = statHeader2>Status: '.$mood.'</p>';

echo '<h3>Date Joined</h3>';
echo '<p class = profiletxt>'.$mnth." ".$day." ".$yr.'</p>';
echo '<h3 class = profileHeader>Who is '.$username.'?';
if($id['admin']==1)
{
	echo '<img class="adminIco" title="This user is an Administrator" src="../../images/admin.png"></img>';
}
echo '</h3>';
echo '<p class = profiletxt>'.$blurb.'</p>';
		
echo '</div>';
		
?>
</body>
</html>