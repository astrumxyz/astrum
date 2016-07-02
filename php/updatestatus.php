
<?php

session_start();
include("../php/Session.class.php");
$sess = new Session();
$sess->Init();
$cookie = isset($_COOKIE["session"]); 
if($cookie) 
{
$cookie = $_COOKIE["session"];
$account = $sess->Verify($cookie);
}


//$blurbtxt=$_POST["blurbEdit"]; //name of input
//if($_GET['link'] == '1'){
//    $stat = "chipper";
//    $dbh = new mysqli("localhost","username","password","sqlserver");
// $change = "UPDATE accounts SET moodStatus=".$stat." WHERE username='".$account['username']."'";
//    $change = $dbh->query($change);
//    $dbh->query($change); //make query
//		$dbh->close();
//   
//}
if (isset($_GET['update'])){
 if ($uniqid= $_GET['link1'])
 {
     $stat = "chipper";
 }
elseif($uniqid= $_GET['link2'])
 {
     $stat = "bored";
 }
    elseif($uniqid= $_GET['link3'])
 {
     $stat = "depressed";
 }
    elseif($uniqid= $_GET['link4'])
 {
     $stat = "tired";
 }
    elseif($uniqid= $_GET['link5'])
 {
     $stat = "hungry";
 }
    elseif($uniqid= $_GET['link6'])
 {
     $stat = "lonely";
 }
    elseif($uniqid= $_GET['link7'])
 {
     $stat = "social";
 }
    elseif($uniqid= $_GET['link8'])
 {
     $stat = "irritated";
 }
    elseif($uniqid= $_GET['link9'])
 {
     $stat = "ecstatic";
 }
    elseif($uniqid= $_GET['link10'])
 {
     $stat = "not too happy";
 }
    elseif($uniqid= $_GET['link11'])
 {
     $stat = "pretty good";
 }
    
    
  $dbh = new mysqli("localhost","username","password","sqlserver");
 $change = "UPDATE accounts SET moodStatus= '$stat' WHERE username='".$account['username']."'";
    $change = $dbh->query($change);
    $dbh->query($change); //make query
		$dbh->close();
}

 header("Refresh:0; url=../settings/index.php");


?>