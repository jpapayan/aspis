<?php require_once('AspisMain.php'); ?><?php
$img = array('kubrickheader.jpg',false);
if ( (!(function_exists(('imagecreatefromjpeg')))))
 Aspis_exit(header(("Location: kubrickheader.jpg")));
$default = array(false,false);
$vars = array(array('upper' => array(array(array('r1',false),array('g1',false),array('b1',false)),false,false),'lower' => array(array(array('r2',false),array('g2',false),array('b2',false)),false,false)),false);
foreach ( $vars[0] as $var =>$subvars )
{restoreTaint($var,$subvars);
{if ( ((isset($_GET[0][$var[0]]) && Aspis_isset( $_GET [0][$var[0]]))))
 {foreach ( $subvars[0] as $index =>$subvar )
{restoreTaint($index,$subvar);
{$length = array(strlen(deAspis(attachAspis($_GET,$var[0]))) / (3),false);
$v = Aspis_substr(attachAspis($_GET,$var[0]),array($index[0] * $length[0],false),$length);
if ( ($length[0] == (1)))
 $v = concat(concat1('',$v),$v);
${$subvar[0]} = Aspis_hexdec($v);
if ( ((deAspis(${$subvar[0]}) < (0)) || (deAspis(${$subvar[0]}) > (255))))
 $default = array(true,false);
}}}else 
{{$default = array(true,false);
}}}}if ( $default[0])
 list($r1,$g1,$b1,$r2,$g2,$b2) = deAspisList(array(array(array(105,false),array(174,false),array(231,false),array(65,false),array(128,false),array(182,false)),false),array());
$im = attAspis(imagecreatefromjpeg($img[0]));
$white = attAspis(imagecolorat($im[0],(15),(15)));
$h = array(182,false);
$corners = array(array(0 => array(array(array(25,false),array(734,false)),false,false),1 => array(array(array(23,false),array(736,false)),false,false),2 => array(array(array(22,false),array(737,false)),false,false),3 => array(array(array(21,false),array(738,false)),false,false),4 => array(array(array(21,false),array(738,false)),false,false),177 => array(array(array(21,false),array(738,false)),false,false),178 => array(array(array(21,false),array(738,false)),false,false),179 => array(array(array(22,false),array(737,false)),false,false),180 => array(array(array(23,false),array(736,false)),false,false),181 => array(array(array(25,false),array(734,false)),false,false),),false);
for ( $i = array(0,false) ; ($i[0] < $h[0]) ; postincr($i) )
{$x1 = array(19,false);
$x2 = array(740,false);
imageline($im[0],$x1[0],((18) + $i[0]),$x2[0],((18) + $i[0]),$white[0]);
}for ( $i = array(0,false) ; ($i[0] < $h[0]) ; postincr($i) )
{$x1 = array(20,false);
$x2 = array(739,false);
$r = (($r2[0] - $r1[0]) != (0)) ? array($r1[0] + (($r2[0] - $r1[0]) * ($i[0] / $h[0])),false) : $r1;
$g = (($g2[0] - $g1[0]) != (0)) ? array($g1[0] + (($g2[0] - $g1[0]) * ($i[0] / $h[0])),false) : $g1;
$b = (($b2[0] - $b1[0]) != (0)) ? array($b1[0] + (($b2[0] - $b1[0]) * ($i[0] / $h[0])),false) : $b1;
$color = attAspis(imagecolorallocate($im[0],$r[0],$g[0],$b[0]));
if ( array_key_exists(deAspisRC($i),deAspisRC($corners)))
 {imageline($im[0],$x1[0],((18) + $i[0]),$x2[0],((18) + $i[0]),$white[0]);
list($x1,$x2) = deAspisList(attachAspis($corners,$i[0]),array());
}imageline($im[0],$x1[0],((18) + $i[0]),$x2[0],((18) + $i[0]),$color[0]);
}header(("Content-Type: image/jpeg"));
imagejpeg($im[0],(''),(92));
imagedestroy($im[0]);
;
?>
<?php 