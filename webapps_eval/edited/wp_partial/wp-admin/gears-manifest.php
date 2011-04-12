<?php require_once('AspisMain.php'); ?><?php
error_reporting(0);
define('ABSPATH',dirname(dirname(__FILE__)) . '/');
require (ABSPATH . '/wp-admin/includes/manifest.php');
$files = get_manifest();
header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Content-Type: application/x-javascript; charset=UTF-8');
;
?>
{
"betaManifestVersion" : 1,
"version" : "<?php echo $man_version;
;
?>",
"entries" : [
<?php $entries = '';
foreach ( $files as $file  )
{if ( !isset($file[1]))
 $entries .= '{ "url" : "' . $file[0] . '" },' . "\n";
elseif ( !isset($file[2]))
 $entries .= '{ "url" : "' . $file[0] . '?' . $file[1] . '" },' . "\n";
else 
{$entries .= '{ "url" : "' . $file[0] . '", "src" : "' . $file[0] . '?' . $file[1] . '", "ignoreQuery" : true },' . "\n";
}}echo trim(trim($entries),',');
;
?>

]}
<?php 