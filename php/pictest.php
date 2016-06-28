<?php

function getSizeFile($url) { 
if (substr($url,0,4)=='http') { 
$x = array_change_key_case(get_headers($url, 1),CASE_LOWER); 
if ( strcasecmp($x[0], 'HTTP/1.1 200 OK') != 0 ) { $x = $x['content-length'][1]; } 
else { $x = $x['content-length']; } 
} 
else { $x = @filesize($url); } 

return $x; 
} 

$f = fopen('../images/backgroundplanet.png','r');
$data = addslashes(fread($f, getSizeFile("../images/backgroundplanet.png")));
fclose($f);
//echo $data;
//echo '<img class="testimg" src="$data" />';

function binaryToImg($file, $mime) {
    
    $content = file_get_contents($file);
    $base64 = base64_encode($content);
    return('data:' . $mime . 'base64: ' . $base64);

}
$image = binaryToImg('$data','image/png');

echo '<img src="'.$image.'" alt="profile" />';

$sql = new mysqli("localhost","username","password","sqlserver");
$sql->close();
?>