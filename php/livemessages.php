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
$sql = new mysqli("localhost","username","password","sqlserver");
$messages = "SELECT * FROM (SELECT * FROM sqlserver.messages WHERE 1 ORDER BY timestamp DESC LIMIT 16) messages ORDER BY timestamp ASC";
$messages = $sql->query($messages);
echo '<div class="messages" id="messagebox">';
while($msg = $messages->fetch_assoc())
{
//if($msg['author']=='beau')
//{
//echo '<div class="message admin" style="font-family: Source Sans Pro; font-size: 18px"><img class="chatimg" src="'.$sess->getChatImageActual($msg['author_id']).'"/>';
//echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
//}
//elseif($msg['author']=='Logan'){
//	echo '<div class="message" style="color:#00FF00;font-family: Source Sans Pro; font-size: 18px"><img class="chatimg" src="'.$sess->getChatImageActual($msg['author_id']).'"/>';
//echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
//}
//elseif($msg['author']=='Yungvegan '){
//	echo '<div class="message" style="color:#FFBB00;font-family: Source Sans Pro; font-size: 18px"><img class="chatimg" src="'.$sess->getChatImageActual($msg['author_id']).'"/>';
//echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
//}
//elseif($msg['author']=='coco_in_da_crib'){
//	echo '<div class="message" style="color:#FF00FF; font-family: Source Sans Pro; font-size: 18px"><img class="chatimg" src="'.$sess->getChatImageActual($msg['author_id']).'"/>';
//echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
//}
if($msg['author']==$account['username'])
{
	echo '<div class="message" style = "font-family: Source Sans Pro; font-size: 18px; color: '.$account['color'].'"><img class="chatimg" src="'.$sess->getChatImageActual($msg['author_id']).'"/>';

	//old way-
	//'data:image/jpeg;base64,.$sess->getChatImageActual($msg['author_id'])['chatimage']
	
echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
}
	else {
		echo '<div class="message" style = "font-family: Source Sans Pro; font-size: 18px; color: white"><img class="chatimg" src="'.$sess->getChatImageActual($msg['author_id']).'"/>';

	//old way-
	//'data:image/jpeg;base64,.$sess->getChatImageActual($msg['author_id'])['chatimage']
	
		echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
	}
}
$sql->close();
}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}
?>