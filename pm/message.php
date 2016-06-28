
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
	<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel='stylesheet' type='text/css' href='../css/stylesheet.css'/>
	<link rel="icon" type = "image/x-icon" href="../favicon2.ico" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type='text/javascript' src='../js/script.js'></script>
	<script type='text/javascript' src='../js/livemessages.js'></script>
    <script type='text/javascript' src='../js/chat.js'></script>
</head>
<body>
	
	<div class="message-body">
		<div class="message-left">
			<ul>
				<?php
					//show all the users expect me
                $dbh = mysqli_connect("localhost","username","password","sqlserver");
                    
					$q = mysqli_query($dbh, "SELECT * FROM `accounts` WHERE id!='$user_id'");
					//display all the results
					while($row = mysqli_fetch_assoc($q)){
						echo "<a href='message.php?id={$row['id']}'><li> {$row['username']}</li></a>";
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
					<textarea class="form-control" id="message" placeholder="Enter Your Message"></textarea>
				</div>
				<button class="btn btn-primary" id="reply">Submit</button> 
				<span id="error"></span>
			</div>
			<!-- / send message -->
		</div>
	</div>
	
	<script type="text/javascript" src="pm.js"></script>	
</body>
</html>