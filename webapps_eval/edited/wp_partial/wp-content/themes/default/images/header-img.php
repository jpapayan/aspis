<?php require_once('AspisMain.php'); ?><?php
$img = 'kubrickheader.jpg';
if ( !function_exists('imagecreatefromjpeg'))
 exit(header("Location: kubrickheader.jpg"));
$default = false;
$vars = array('upper' => array('r1','g1','b1'),'lower' => array('r2','g2','b2'));
foreach ( $vars as $var =>$subvars )
{if ( (isset($_GET[0][$var]) && Aspis_isset($_GET[0][$var])))
 {foreach ( $subvars as $index =>$subvar )
{$length = strlen(deAspisWarningRC($_GET[0][$var])) / 3;
$v = substr(deAspisWarningRC($_GET[0][$var]),$index * $length,$length);
if ( $length == 1)
 $v = '' . $v . $v;
$$subvar = hexdec($v);
if ( $$subvar < 0 || $$subvar > 255)
 $default = true;
}}else 
{{$default = true;
}}}if ( $default)
 list($r1,$g1,$b1,$r2,$g2,$b2) = array(105,174,231,65,128,182);
$im = imagecreatefromjpeg($img);
$white = imagecolorat($im,15,15);
$h = 182;
$corners = array(0 => array(25,734),1 => array(23,736),2 => array(22,737),3 => array(21,738),4 => array(21,738),177 => array(21,738),178 => array(21,738),179 => array(22,737),180 => array(23,736),181 => array(25,734),);
for ( $i = 0 ; $i < $h ; $i++ )
{$x1 = 19;
$x2 = 740;
imageline($im,$x1,18 + $i,$x2,18 + $i,$white);
}for ( $i = 0 ; $i < $h ; $i++ )
{$x1 = 20;
$x2 = 739;
$r = ($r2 - $r1 != 0) ? $r1 + ($r2 - $r1) * ($i / $h) : $r1;
$g = ($g2 - $g1 != 0) ? $g1 + ($g2 - $g1) * ($i / $h) : $g1;
$b = ($b2 - $b1 != 0) ? $b1 + ($b2 - $b1) * ($i / $h) : $b1;
$color = imagecolorallocate($im,$r,$g,$b);
if ( array_key_exists($i,$corners))
 {imageline($im,$x1,18 + $i,$x2,18 + $i,$white);
list($x1,$x2) = $corners[$i];
}imageline($im,$x1,18 + $i,$x2,18 + $i,$color);
}header("Content-Type: image/jpeg");
imagejpeg($im,'',92);
imagedestroy($im);
;
?>
<?php 