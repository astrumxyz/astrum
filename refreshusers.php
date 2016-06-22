<?php
echo 'refreshing userbase';
$sql = new mysqli("localhost","username","password","sqlserver");
$d = "DELETE FROM `accounts` WHERE username LIKE '%&%'";
$sql->query($d);
$d = "DELETE FROM `accounts` WHERE username=''";
$sql->query($d);
$u = 'SELECT `username` FROM sqlserver.accounts WHERE 1';
$u = $sql->query($u);
while($user = $u->fetch_assoc())
{
echo $user['username'];
$username = $user['username'];
$oldmask = umask(0);
mkdir('users/'.$username,0777);
copy('php/index.php','users/'.$username.'/index.php');
umask($oldmask);
}
?>