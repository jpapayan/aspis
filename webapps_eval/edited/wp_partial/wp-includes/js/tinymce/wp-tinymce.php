<?php require_once('AspisMain.php'); ?><?php
error_reporting(0);
$basepath = dirname(__FILE__);
function get_file ( $path ) {
if ( function_exists('realpath'))
 $path = realpath($path);
if ( !$path || !@is_file($path))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = @file_get_contents($path);
return $AspisRetTemp;
} }
$expires_offset = 31536000;
header('Content-Type: application/x-javascript; charset=UTF-8');
header('Vary: Accept-Encoding');
header('Expires: ' . gmdate("D, d M Y H:i:s",time() + $expires_offset) . ' GMT');
header("Cache-Control: public, max-age=$expires_offset");
if ( (isset($_GET[0]['c']) && Aspis_isset($_GET[0]['c'])) && 1 == deAspisWarningRC($_GET[0]['c']) && (isset($_SERVER[0]['HTTP_ACCEPT_ENCODING']) && Aspis_isset($_SERVER[0]['HTTP_ACCEPT_ENCODING'])) && false !== strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'gzip') && ($file = get_file($basepath . '/wp-tinymce.js.gz')))
 {header('Content-Encoding: gzip');
echo $file;
}else 
{{echo get_file($basepath . '/wp-tinymce.js');
}}exit();
