
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

$pass1=$_POST['passwordText']; //name of input
    echo $pass1;    

$pass=$_POST['oldPass']; //name of input
    echo $pass;

echo $account['username'];

$dbh = new mysqli("localhost","username","password","sqlserver");
    $checkforpass = "SELECT password FROM accounts WHERE username='".$account['username']."'";

$checkforpass = $dbh->query($checkforpass); //make query
$checkforpass = $checkforpass->fetch_assoc(); //prepare sql
$checkforpass = $checkforpass['password'];

echo $checkforpass;

if($checkforpass==$pass)
{
    echo 'they got the password!';
    
    $change = "UPDATE accounts SET password='".$pass1."' WHERE username='".$account['username']."'";
    //$change = $dbh->query($change);
    $dbh->query($change); //make query
		$dbh->close();
    
    header("Refresh:0"); 
    //change password
    
}
else {
    
    echo 'incorrect password';
    header("Refresh:0");
}

?>