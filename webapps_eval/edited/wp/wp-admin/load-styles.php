<?php require_once('AspisMain.php'); ?><?php
error_reporting(0);
define(('ABSPATH'),(deconcat2(Aspis_dirname(Aspis_dirname(array(__FILE__,false))),'/')));
define(('WPINC'),'wp-includes');
function __ (  ) {
 }
function _c (  ) {
 }
function _x (  ) {
 }
function add_filter (  ) {
 }
function esc_attr (  ) {
 }
function apply_filters (  ) {
 }
function get_option (  ) {
 }
function is_lighttpd_before_150 (  ) {
 }
function add_action (  ) {
 }
function do_action_ref_array (  ) {
 }
function get_bloginfo (  ) {
 }
function is_admin (  ) {
return array(true,false);
 }
function site_url (  ) {
 }
function admin_url (  ) {
 }
function wp_guess_url (  ) {
 }
function get_file ( $path ) {
if ( function_exists(('realpath')))
 $path = Aspis_realpath($path);
if ( ((denot_boolean($path)) || (denot_boolean(@attAspis(is_file($path[0]))))))
 return array('',false);
return @attAspis(file_get_contents($path[0]));
 }
require (deconcat12(ABSPATH,'/wp-includes/script-loader.php'));
require (deconcat12(ABSPATH,'/wp-includes/version.php'));
$load = Aspis_preg_replace(array('/[^a-z0-9,_-]+/i',false),array('',false),$_GET[0]['load']);
$load = Aspis_explode(array(',',false),$load);
if ( ((empty($load) || Aspis_empty( $load))))
 Aspis_exit();
$compress = (array(((isset($_GET[0][('c')]) && Aspis_isset( $_GET [0][('c')]))) && deAspis($_GET[0]['c']),false));
$force_gzip = (array($compress[0] && (('gzip') == deAspis($_GET[0]['c'])),false));
$rtl = (array(((isset($_GET[0][('dir')]) && Aspis_isset( $_GET [0][('dir')]))) && (('rtl') == deAspis($_GET[0]['dir'])),false));
$expires_offset = array(31536000,false);
$out = array('',false);
$wp_styles = array(new WP_Styles(),false);
wp_default_styles($wp_styles);
foreach ( $load[0] as $handle  )
{if ( (!(array_key_exists(deAspisRC($handle),deAspisRC($wp_styles[0]->registered)))))
 continue ;
$style = $wp_styles[0]->registered[0][$handle[0]];
$path = concat1(ABSPATH,$style[0]->src);
$content = concat2(get_file($path),"\n");
if ( (($rtl[0] && ((isset($style[0]->extra[0][('rtl')]) && Aspis_isset( $style[0] ->extra [0][('rtl')] )))) && $style[0]->extra[0][('rtl')][0]))
 {$rtl_path = is_bool(deAspisRC($style[0]->extra[0][('rtl')])) ? Aspis_str_replace(array('.css',false),array('-rtl.css',false),$path) : concat1(ABSPATH,$style[0]->extra[0][('rtl')]);
$content = concat($content,concat2(get_file($rtl_path),"\n"));
}$out = concat($out,Aspis_str_replace(array('../images/',false),array('images/',false),$content));
}header(('Content-Type: text/css'));
header((deconcat2(concat1('Expires: ',attAspis(gmdate(("D, d M Y H:i:s"),(time() + $expires_offset[0])))),' GMT')));
header((deconcat1("Cache-Control: public, max-age=",$expires_offset)));
if ( ((($compress[0] && (!(ini_get('zlib.output_compression')))) && (('ob_gzhandler') != (ini_get('output_handler')))) && ((isset($_SERVER[0][('HTTP_ACCEPT_ENCODING')]) && Aspis_isset( $_SERVER [0][('HTTP_ACCEPT_ENCODING')])))))
 {header(('Vary: Accept-Encoding'));
if ( (((false !== strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'deflate')) && function_exists(('gzdeflate'))) && (denot_boolean($force_gzip))))
 {header(('Content-Encoding: deflate'));
$out = array(gzdeflate(deAspisRC($out),3),false);
}elseif ( ((false !== strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'gzip')) && function_exists(('gzencode'))))
 {header(('Content-Encoding: gzip'));
$out = array(gzencode(deAspisRC($out),3),false);
}}echo AspisCheckPrint($out);
Aspis_exit();
