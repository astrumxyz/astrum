//Sample code
<?php
//Set image
  $id = $_GET['id'];
  

  $link = mysql_connect("localhost","username","password","sqlserver");
  mysql_select_db("dvddb");
  $sql = "SELECT dvdimage FROM dvd WHERE id=$id";
  $result = mysql_query("$sql");
  $row = mysql_fetch_assoc($result);
  mysql_close($link);

  header("Content-type: image/jpeg");
  echo $row['dvdimage'];
?>