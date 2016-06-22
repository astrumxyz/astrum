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
if($msg['author']=='beau')
{
echo '<div class="message admin"><img class="chatimg" src="data:image/jpeg;base64,'.$sess->getChatImage($msg['author_id'])['chatimage'].'"></img>';
echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
}
elseif($msg['author']=='Logan'){
	echo '<div class="message" style="color:#00FF00"><img class="chatimg" src="data:image/jpeg;base64,'.$sess->getChatImage($msg['author_id'])['chatimage'].'"></img>';
echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
}
elseif($msg['author']=='Yungvegan '){
	echo '<div class="message" style="color:#FFBB00"><img class="chatimg" src="data:image/jpeg;base64,'.$sess->getChatImage($msg['author_id'])['chatimage'].'"></img>';
echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
}
elseif($msg['author']=='coco_in_da_crib'){
	echo '<div class="message" style="color:#FF00FF"><img class="chatimg" src="data:image/jpeg;base64,'.$sess->getChatImage($msg['author_id'])['chatimage'].'"></img>';
echo '<div style="float:left">'.$msg['author']." : ".$msg['content'].'</div></div>';
}
else {
echo '<div class="message"><img class="chatimg" src="data:image/jpeg;base64,'.$sess->getChatImage($msg['author_id'])['chatimage'].'"></img>';
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