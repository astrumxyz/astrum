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
if(isset($_FILES["file"]["type"]))
{
$validextensions = array("jpeg", "jpg", "png");
$maxsize = 99999999;
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < $maxsize)//Approx. 100kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {

$size = getimagesize($_FILES['file']['tmp_name']);
$type = $size['mime'];
$imgfp = fopen($_FILES['file']['tmp_name'], 'rb');
$size = $size[3];
$name = $_FILES['file']['name'];

$sql = new mysqli("localhost","username","password","sqlserver");
$imgfp64 = base64_encode(stream_get_contents($imgfp));
$update = "UPDATE sqlserver.imageblob set image='".$imgfp64."', image_type='".$type."', image_name='".$name."', image_size='".$size."' where user_id=".$account['id'];
$sql->query($update);
	
//small image
	$w=50;$h=50;
	list($width, $height) = getimagesize($_FILES['file']['tmp_name']);
    $r = $width / $height;
    
        if ($w/$h > $r) { 
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
	
    $src = imagecreatefromjpeg($_FILES['file']['tmp_name']);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	ob_start();
	imagejpeg($dst,null);
	$dst=ob_get_clean();
	
	$dst = base64_encode($dst);
			$update2 = "UPDATE sqlserver.imageblob set chatimage='".$dst."' where user_id=".$account['id'];
			
			$sql->query($update2);
			 
	//-------------------------------------

$q = "SELECT image, image_type FROM sqlserver.imageblob WHERE user_id=".$account['id'];
$q=$sql->query($q);
$q=$q->fetch_assoc();
	
$sql->close();	
echo '<img src="data:image/jpeg;base64,'.$q['image'].'"/>';
}
}

}
}
else { //user is not logged in, return to login screen
header('Location: ../');
}

	//gd resize func
	function resize_image($file, $w, $h) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    
        if ($w/$h > $r) { 
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
	}
?>