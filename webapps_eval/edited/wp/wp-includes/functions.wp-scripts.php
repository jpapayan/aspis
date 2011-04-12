<?php require_once('AspisMain.php'); ?><?php
function wp_print_scripts ( $handles = array(false,false) ) {
do_action(array('wp_print_scripts',false));
if ( (('') === $handles[0]))
 $handles = array(false,false);
global $wp_scripts;
if ( (!(is_a(deAspisRC($wp_scripts),('WP_Scripts')))))
 {if ( (denot_boolean($handles)))
 return array(array(),false);
else 
{$wp_scripts = array(new WP_Scripts(),false);
}}return $wp_scripts[0]->do_items($handles);
 }
function wp_register_script ( $handle,$src,$deps = array(array(),false),$ver = array(false,false),$in_footer = array(false,false) ) {
global $wp_scripts;
if ( (!(is_a(deAspisRC($wp_scripts),('WP_Scripts')))))
 $wp_scripts = array(new WP_Scripts(),false);
$wp_scripts[0]->add($handle,$src,$deps,$ver);
if ( $in_footer[0])
 $wp_scripts[0]->add_data($handle,array('group',false),array(1,false));
 }
function wp_localize_script ( $handle,$object_name,$l10n ) {
global $wp_scripts;
if ( (!(is_a(deAspisRC($wp_scripts),('WP_Scripts')))))
 return array(false,false);
return $wp_scripts[0]->localize($handle,$object_name,$l10n);
 }
function wp_deregister_script ( $handle ) {
global $wp_scripts;
if ( (!(is_a(deAspisRC($wp_scripts),('WP_Scripts')))))
 $wp_scripts = array(new WP_Scripts(),false);
$wp_scripts[0]->remove($handle);
 }
function wp_enqueue_script ( $handle,$src = array(false,false),$deps = array(array(),false),$ver = array(false,false),$in_footer = array(false,false) ) {
global $wp_scripts;
if ( (!(is_a(deAspisRC($wp_scripts),('WP_Scripts')))))
 $wp_scripts = array(new WP_Scripts(),false);
if ( $src[0])
 {$_handle = Aspis_explode(array('?',false),$handle);
$wp_scripts[0]->add(attachAspis($_handle,(0)),$src,$deps,$ver);
if ( $in_footer[0])
 $wp_scripts[0]->add_data(attachAspis($_handle,(0)),array('group',false),array(1,false));
}$wp_scripts[0]->enqueue($handle);
 }
function wp_script_is ( $handle,$list = array('queue',false) ) {
global $wp_scripts;
if ( (!(is_a(deAspisRC($wp_scripts),('WP_Scripts')))))
 $wp_scripts = array(new WP_Scripts(),false);
$query = $wp_scripts[0]->query($handle,$list);
if ( is_object($query[0]))
 return array(true,false);
return $query;
 }
