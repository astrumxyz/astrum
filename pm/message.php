
<?php 
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
setcookie("session","",time()-1,"/");
header('Location: ../');
}

else //user is signed in with valid cookie
{
$user_id = $account['id'];
    
}
}
else {
header('Location: ../');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Direct Message</title>
	
    <link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<link rel="icon" type = "image/x-icon" href="../favicon2.ico" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
	<script type='text/javascript' src='../js/livemessages.js'></script>
    <script type='text/javascript' src='../js/chat.js'></script>
</head>
<body>
    <?php 
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
echo '<div class="wrapperpm">';
//echo '<h1>direct message</h1>';
?>
	
	<div class="message-body">
		<div class="message-left">
			<ul>
				<?php
//
				$convoArray = array();
				
echo '<form class="usersearchpm" method="post"><input class="searchbarpm" name="searchbarpm"></input></form>';
//display user currently chatting with
    $con = mysqli_connect("localhost","username","password","sqlserver");
				
				if(isset($_GET['id'])){
					$user_two = trim(mysqli_real_escape_string($con, $_GET['id']));
					//check $user_two is valid
					$q = mysqli_query($con, "SELECT * FROM `accounts` WHERE id='$user_two' AND id!='$user_id'");
                    $second = mysqli_fetch_assoc($q);
                    //echo $q['username'];
                    echo "<a href='message.php?id={$second['id']}'><li><img class = 'dmCircle' src = '../images/chatCircle.png'/> {$second['username']}</li></a>";
					
					//------------------
				
                    //$num = mysqli_query($con, "SELECT * FROM `pm_messages` WHERE user_from=".$account['id']."");
				$numCon = mysqli_query($con, "SELECT * FROM `conversation` WHERE user_one=".$account['id']."");
					$numrows = mysqli_num_rows($numCon);
				while ($u = mysqli_fetch_assoc($numCon))
					{
					//get other users usernames to echo link
	$getUserTwo = mysqli_query($con, "SELECT * FROM `accounts` WHERE id=".$u['user_two']."");
		$s = mysqli_fetch_assoc($getUserTwo); //s[username] is a user that DOES have convo
					
					
					//$convoArray.append($s['username']);
					array_push($convoArray, $s['username']);
					//echo "<a href='message.php?id={$s['id']}'><li><img class = 'dmCircle' src = '../images/chatCircle.png'/>{$s['username']} </li></a>";
				}
if(isset($_POST['searchbarpm'])){
//	foreach($convoArray as $name)
//	{
//		echo $name;
//	}
//$sess->getUsers();
    $dbh = mysqli_connect("localhost","username","password","sqlserver");
                    $query = $_POST['searchbarpm'];
					$q = mysqli_query($dbh, "SELECT * FROM sqlserver.accounts WHERE username LIKE '%".$query."%'");
					//display all the results
					while($row = mysqli_fetch_assoc($q)){
						
//						$checkConvo = mysqli_query($dbh, "SELECT * FROM sqlserver.conversation WHERE user_one=".$user_id." AND user_two=".$row['id']."");
							
                        if($row['id']!= $user_id && $row['id']!= $second['id']) { //only output users they dont have convo going with because theyre already printed!!!
								
						if(in_array($row['username'], $convoArray)) {
 
    echo "<a href='message.php?id={$row['id']}'><li><img class = 'dmCircle' src = '../images/chatCircle.png'/> {$row['username']}</li></a>";
}
else {
    echo "<a href='message.php?id={$row['id']}'><li><img class = 'dmCircle' src = '../images/noChatCircle.png'/> {$row['username']}</li></a>";
}
				
                        }
					}
}//
				}

				?>
			</ul>
		</div>

		<div class="message-right">
			<!-- display message -->
			<div class="display-message">
			<?php

                $con = mysqli_connect("localhost","username","password","sqlserver");
				//check $_GET['id'] is set
				if(isset($_GET['id'])){
					$user_two = trim(mysqli_real_escape_string($con, $_GET['id']));
					//check $user_two is valid
					$q = mysqli_query($con, "SELECT `id` FROM `accounts` WHERE id='$user_two' AND id!='$user_id'");
					//valid $user_two
					if(mysqli_num_rows($q) == 1){
						//check $user_id and $user_two has conversation or not if no start one
						$conver = mysqli_query($con, "SELECT * FROM `conversation` WHERE (user_one='$user_id' AND user_two='$user_two') OR (user_one='$user_two' AND user_two='$user_id')");

						//they have a conversation
						if(mysqli_num_rows($conver) == 1){
							//fetch the converstaion id
							$fetch = mysqli_fetch_assoc($conver);
							$conversation_id = $fetch['id'];
						}else{ //they do not have a conversation
							//start a new converstaion and fetch its id
							$q = mysqli_query($con, "INSERT INTO `conversation` VALUES ('','$user_id',$user_two)");
							$conversation_id = mysqli_insert_id($con);
						}
					}else{
						die("Invalid $_GET ID.");
					}
				}else {
					die("Click On the Person to start Chating.");
				}
			?>
			</div>
			<!-- /display message -->

			<!-- send message -->
			<div class="send-message">
				<!-- store conversation_id, user_from, user_to so that we can send send this values to post_message_ajax.php -->
				<input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
				<input type="hidden" id="user_form" value="<?php echo base64_encode($user_id); ?>">
				<input type="hidden" id="user_to" value="<?php echo base64_encode($user_two); ?>">
				<div class="form-group">
<!--
					echo '<form class="submitmessage" method="post">';
echo '<textarea class="messagebox" name="messagebox" autofocus="autofocus"></textarea>';
echo '<input class="button entermessage" type="submit" name="entermessage"></input>';
echo '</form>';

-->
                    <textarea class="form-control" id="message" autofocus="autofocus"></textarea>
<input class="button btn-primary" id="reply" type="Submit"></input>
				<span id="error"></span>
			</div>
			<!-- / send message -->
		</div>
	</div>
	</div>
	<script type="text/javascript" src="pm.js"></script>	
</body>
</html>