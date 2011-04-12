<?php
session_start();

$RandomStr = md5(microtime());// md5 to generate the random string

$ResultStr = substr($RandomStr,0,5);//trim 5 digit 

$NewImage =imagecreatefromjpeg("captcha.jpg");//image create by existing image and as back ground 

$LineColor = imagecolorallocate($NewImage,51,182,240);//line rgb(175, 207, 228)
$TextColor = imagecolorallocate($NewImage, 213, 78, 33);//text color

imageline($NewImage,1,1,40,40,$LineColor);//create line 1 on image 
imageline($NewImage,1,100,60,0,$LineColor);//create line 2 on image 
imageline($NewImage,1,50,50,0,$LineColor);//create line 3 on image 
imageline($NewImage,0,20,100,15,$LineColor);//create line 5 on image 

imagestring($NewImage, 5, 20, 10, $ResultStr, $TextColor);// Draw a random string horizontally 

$_SESSION['1k2j48djh'] = md5($ResultStr);// carry the data through session

header("Content-type: image/jpeg");// out out the image 

imagejpeg($NewImage);//Output image to browser 

?>