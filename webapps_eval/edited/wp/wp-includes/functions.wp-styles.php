<?php require_once('AspisMain.php'); ?><?php
function wp_print_styles ( $handles = array(false,false) ) {
do_action(array('wp_print_styles',false));
if ( (('') === $handles[0]))
 $handles = array(false,false);
global $wp_styles;
if ( (!(is_a(deAspisRC($wp_styles),('WP_Styles')))))
 {if ( (denot_boolean($handles)))
 return array(array(),false);
else 
{$wp_styles = array(new WP_Styles(),false);
}}return $wp_styles[0]->do_items($handles);
 }
function wp_register_style ( $handle,$src,$deps = array(array(),false),$ver = array(false,false),$media = array('all',false) ) {
global $wp_styles;
if ( (!(is_a(deAspisRC($wp_styles),('WP_Styles')))))
 $wp_styles = array(new WP_Styles(),false);
$wp_styles[0]->add($handle,$src,$deps,$ver,$media);
 }
function wp_deregister_style ( $handle ) {
global $wp_styles;
if ( (!(is_a(deAspisRC($wp_styles),('WP_Styles')))))
 $wp_styles = array(new WP_Styles(),false);
$wp_styles[0]->remove($handle);
 }
function wp_enqueue_style ( $handle,$src = array(false,false),$deps = array(array(),false),$ver = array(false,false),$media = array(false,false) ) {
global $wp_styles;
if ( (!(is_a(deAspisRC($wp_styles),('WP_Styles')))))
 $wp_styles = array(new WP_Styles(),false);
if ( $src[0])
 {$_handle = Aspis_explode(array('?',false),$handle);
$wp_styles[0]->add(attachAspis($_handle,(0)),$src,$deps,$ver,$media);
}$wp_styles[0]->enqueue($handle);
 }
function wp_style_is ( $handle,$list = array('queue',false) ) {
global $wp_styles;
if ( (!(is_a(deAspisRC($wp_styles),('WP_Styles')))))
 $wp_styles = array(new WP_Styles(),false);
$query = $wp_styles[0]->query($handle,$list);
if ( is_object($query[0]))
 return array(true,false);
return $query;
 }
