<?php require_once('AspisMain.php'); ?><?php
error_reporting(0);
define('ABSPATH',dirname(dirname(__FILE__)) . '/');
define('WPINC','wp-includes');
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
{$AspisRetTemp = true;
return $AspisRetTemp;
} }
function site_url (  ) {
 }
function admin_url (  ) {
 }
function wp_guess_url (  ) {
 }
function get_file ( $path ) {
if ( function_exists('realpath'))
 $path = realpath($path);
if ( !$path || !@is_file($path))
 {$AspisRetTemp = '';
return $AspisRetTemp;
}{$AspisRetTemp = @file_get_contents($path);
return $AspisRetTemp;
} }
require (ABSPATH . '/wp-includes/script-loader.php');
require (ABSPATH . '/wp-includes/version.php');
$load = preg_replace('/[^a-z0-9,_-]+/i','',deAspisWarningRC($_GET[0]['load']));
$load = explode(',',$load);
if ( empty($load))
 exit();
$compress = ((isset($_GET[0]['c']) && Aspis_isset($_GET[0]['c'])) && deAspisWarningRC($_GET[0]['c']));
$force_gzip = ($compress && 'gzip' == deAspisWarningRC($_GET[0]['c']));
$rtl = ((isset($_GET[0]['dir']) && Aspis_isset($_GET[0]['dir'])) && 'rtl' == deAspisWarningRC($_GET[0]['dir']));
$expires_offset = 31536000;
$out = '';
$wp_styles = new WP_Styles();
wp_default_styles($wp_styles);
foreach ( $load as $handle  )
{if ( !array_key_exists($handle,$wp_styles->registered))
 continue ;
$style = $wp_styles->registered[$handle];
$path = ABSPATH . $style->src;
$content = get_file($path) . "\n";
if ( $rtl && isset($style->extra['rtl']) && $style->extra['rtl'])
 {$rtl_path = is_bool($style->extra['rtl']) ? str_replace('.css','-rtl.css',$path) : ABSPATH . $style->extra['rtl'];
$content .= get_file($rtl_path) . "\n";
}$out .= str_replace('../images/','images/',$content);
}header('Content-Type: text/css');
header('Expires: ' . gmdate("D, d M Y H:i:s",time() + $expires_offset) . ' GMT');
header("Cache-Control: public, max-age=$expires_offset");
if ( $compress && !ini_get('zlib.output_compression') && 'ob_gzhandler' != ini_get('output_handler') && (isset($_SERVER[0]['HTTP_ACCEPT_ENCODING']) && Aspis_isset($_SERVER[0]['HTTP_ACCEPT_ENCODING'])))
 {header('Vary: Accept-Encoding');
if ( false !== strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'deflate') && function_exists('gzdeflate') && !$force_gzip)
 {header('Content-Encoding: deflate');
$out = gzdeflate($out,3);
}elseif ( false !== strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'gzip') && function_exists('gzencode'))
 {header('Content-Encoding: gzip');
$out = gzencode($out,3);
}}echo $out;
exit();
