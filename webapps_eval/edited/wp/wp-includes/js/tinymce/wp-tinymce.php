<?php require_once('AspisMain.php'); ?><?php
error_reporting(0);
$basepath = Aspis_dirname(array(__FILE__,false));
function get_file ( $path ) {
if ( function_exists(('realpath')))
 $path = Aspis_realpath($path);
if ( ((denot_boolean($path)) || (denot_boolean(@attAspis(is_file($path[0]))))))
 return array(false,false);
return @attAspis(file_get_contents($path[0]));
 }
$expires_offset = array(31536000,false);
header(('Content-Type: application/x-javascript; charset=UTF-8'));
header(('Vary: Accept-Encoding'));
header((deconcat2(concat1('Expires: ',attAspis(gmdate(("D, d M Y H:i:s"),(time() + $expires_offset[0])))),' GMT')));
header((deconcat1("Cache-Control: public, max-age=",$expires_offset)));
if ( ((((((isset($_GET[0][('c')]) && Aspis_isset( $_GET [0][('c')]))) && ((1) == deAspis($_GET[0]['c']))) && ((isset($_SERVER[0][('HTTP_ACCEPT_ENCODING')]) && Aspis_isset( $_SERVER [0][('HTTP_ACCEPT_ENCODING')])))) && (false !== strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'gzip'))) && deAspis(($file = get_file(concat2($basepath,'/wp-tinymce.js.gz'))))))
 {header(('Content-Encoding: gzip'));
echo AspisCheckPrint($file);
}else 
{{echo AspisCheckPrint(get_file(concat2($basepath,'/wp-tinymce.js')));
}}Aspis_exit();
