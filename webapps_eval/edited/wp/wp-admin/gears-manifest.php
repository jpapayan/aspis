<?php require_once('AspisMain.php'); ?><?php
error_reporting(0);
define(('ABSPATH'),(deconcat2(Aspis_dirname(Aspis_dirname(array(__FILE__,false))),'/')));
require (deconcat12(ABSPATH,'/wp-admin/includes/manifest.php'));
$files = get_manifest();
header(('Expires: Wed, 11 Jan 1984 05:00:00 GMT'));
header((deconcat2(concat1('Last-Modified: ',attAspis(gmdate(('D, d M Y H:i:s')))),' GMT')));
header(('Cache-Control: no-cache, must-revalidate, max-age=0'));
header(('Pragma: no-cache'));
header(('Content-Type: application/x-javascript; charset=UTF-8'));
;
?>
{
"betaManifestVersion" : 1,
"version" : "<?php echo AspisCheckPrint($man_version);
;
?>",
"entries" : [
<?php $entries = array('',false);
foreach ( $files[0] as $file  )
{if ( (!((isset($file[0][(1)]) && Aspis_isset( $file [0][(1)])))))
 $entries = concat($entries,concat2(concat2(concat1('{ "url" : "',attachAspis($file,(0))),'" },'),"\n"));
elseif ( (!((isset($file[0][(2)]) && Aspis_isset( $file [0][(2)])))))
 $entries = concat($entries,concat2(concat2(concat(concat2(concat1('{ "url" : "',attachAspis($file,(0))),'?'),attachAspis($file,(1))),'" },'),"\n"));
else 
{$entries = concat($entries,concat2(concat2(concat(concat2(concat(concat2(concat1('{ "url" : "',attachAspis($file,(0))),'", "src" : "'),attachAspis($file,(0))),'?'),attachAspis($file,(1))),'", "ignoreQuery" : true },'),"\n"));
}}echo AspisCheckPrint(Aspis_trim(Aspis_trim($entries),array(',',false)));
;
?>

]}
<?php 