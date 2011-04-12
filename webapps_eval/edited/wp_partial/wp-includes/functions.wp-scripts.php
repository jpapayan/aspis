<?php require_once('AspisMain.php'); ?><?php
function wp_print_scripts ( $handles = false ) {
do_action('wp_print_scripts');
if ( '' === $handles)
 $handles = false;
{global $wp_scripts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_scripts,"\$wp_scripts",$AspisChangesCache);
}if ( !is_a($wp_scripts,'WP_Scripts'))
 {if ( !$handles)
 {$AspisRetTemp = array();
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
return $AspisRetTemp;
}else 
{$wp_scripts = new WP_Scripts();
}}{$AspisRetTemp = $wp_scripts->do_items($handles);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
 }
function wp_register_script ( $handle,$src,$deps = array(),$ver = false,$in_footer = false ) {
{global $wp_scripts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_scripts,"\$wp_scripts",$AspisChangesCache);
}if ( !is_a($wp_scripts,'WP_Scripts'))
 $wp_scripts = new WP_Scripts();
$wp_scripts->add($handle,$src,$deps,$ver);
if ( $in_footer)
 $wp_scripts->add_data($handle,'group',1);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
 }
function wp_localize_script ( $handle,$object_name,$l10n ) {
{global $wp_scripts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_scripts,"\$wp_scripts",$AspisChangesCache);
}if ( !is_a($wp_scripts,'WP_Scripts'))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $wp_scripts->localize($handle,$object_name,$l10n);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
 }
function wp_deregister_script ( $handle ) {
{global $wp_scripts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_scripts,"\$wp_scripts",$AspisChangesCache);
}if ( !is_a($wp_scripts,'WP_Scripts'))
 $wp_scripts = new WP_Scripts();
$wp_scripts->remove($handle);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
 }
function wp_enqueue_script ( $handle,$src = false,$deps = array(),$ver = false,$in_footer = false ) {
{global $wp_scripts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_scripts,"\$wp_scripts",$AspisChangesCache);
}if ( !is_a($wp_scripts,'WP_Scripts'))
 $wp_scripts = new WP_Scripts();
if ( $src)
 {$_handle = explode('?',$handle);
$wp_scripts->add($_handle[0],$src,$deps,$ver);
if ( $in_footer)
 $wp_scripts->add_data($_handle[0],'group',1);
}$wp_scripts->enqueue($handle);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
 }
function wp_script_is ( $handle,$list = 'queue' ) {
{global $wp_scripts;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_scripts,"\$wp_scripts",$AspisChangesCache);
}if ( !is_a($wp_scripts,'WP_Scripts'))
 $wp_scripts = new WP_Scripts();
$query = $wp_scripts->query($handle,$list);
if ( is_object($query))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $query;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_scripts",$AspisChangesCache);
 }
