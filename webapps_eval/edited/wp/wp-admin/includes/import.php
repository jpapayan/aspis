<?php require_once('AspisMain.php'); ?><?php
function get_importers (  ) {
global $wp_importers;
if ( is_array($wp_importers[0]))
 AspisInternalFunctionCall("uasort",AspisPushRefParam($wp_importers),AspisInternalCallback(Aspis_create_function(array('$a, $b',false),array('return strcmp($a[0], $b[0]);',false))),array(0));
return $wp_importers;
 }
function register_importer ( $id,$name,$description,$callback ) {
global $wp_importers;
if ( deAspis(is_wp_error($callback)))
 return $callback;
arrayAssign($wp_importers[0],deAspis(registerTaint($id)),addTaint(array(array($name,$description,$callback),false)));
 }
function wp_import_cleanup ( $id ) {
wp_delete_attachment($id);
 }
function wp_import_handle_upload (  ) {
if ( (!((isset($_FILES[0][('import')]) && Aspis_isset( $_FILES [0][('import')])))))
 {arrayAssign($file[0],deAspis(registerTaint(array('error',false))),addTaint(__(array('File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.',false))));
return $file;
}$overrides = array(array('test_form' => array(false,false,false),'test_type' => array(false,false,false)),false);
arrayAssign($_FILES[0][('import')][0],deAspis(registerTaint(array('name',false))),addTaint(concat2($_FILES[0][('import')][0]['name'],'.txt')));
$file = wp_handle_upload($_FILES[0]['import'],$overrides);
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 return $file;
$url = $file[0]['url'];
$type = $file[0]['type'];
$file = Aspis_addslashes($file[0]['file']);
$filename = Aspis_basename($file);
$object = array(array(deregisterTaint(array('post_title',false)) => addTaint($filename),deregisterTaint(array('post_content',false)) => addTaint($url),deregisterTaint(array('post_mime_type',false)) => addTaint($type),deregisterTaint(array('guid',false)) => addTaint($url)),false);
$id = wp_insert_attachment($object,$file);
return array(array(deregisterTaint(array('file',false)) => addTaint($file),deregisterTaint(array('id',false)) => addTaint($id)),false);
 }
;
?>
<?php 