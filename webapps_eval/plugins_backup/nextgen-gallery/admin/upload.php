<?php
/**
 * Accepts file uploads from swfupload.
 *
 * @package NextGEN-Gallery
 * @subpackage Administration
 */

define('WP_ADMIN', true);

// look up for the path
require_once( dirname( dirname(__FILE__) ) . '/ngg-config.php');

// Flash often fails to send cookies with the POST or upload, so we need to pass it in GET or POST instead
if (function_exists('is_ssl')) {
	if ( is_ssl() && empty($_COOKIE[SECURE_AUTH_COOKIE]) && !empty($_REQUEST['auth_cookie']) )
		$_COOKIE[SECURE_AUTH_COOKIE] = $_REQUEST['auth_cookie'];
	elseif ( empty($_COOKIE[AUTH_COOKIE]) && !empty($_REQUEST['auth_cookie']) )
		$_COOKIE[AUTH_COOKIE] = $_REQUEST['auth_cookie'];
} else {
	if ( empty($_COOKIE[AUTH_COOKIE]) && !empty($_REQUEST['auth_cookie']) )
		$_COOKIE[AUTH_COOKIE] = $_REQUEST['auth_cookie'];
}

// don't ask me why, sometimes needed, taken from wp core
unset($current_user);

// admin.php require a proper login cookie
require_once(ABSPATH . '/wp-admin/admin.php');

header('Content-Type: text/plain; charset=' . get_option('blog_charset'));

//check for correct capability
if ( !is_user_logged_in() )
	die('Login failure. -1');

//check for correct capability
if ( !current_user_can('NextGEN Upload images') ) 
	die('You do not have permission to upload files. -2');

//check for correct nonce 
check_admin_referer('ngg_swfupload');

//check for nggallery
if ( !defined('NGGALLERY_ABSPATH') )
	die('NextGEN Gallery not available. -3');
	
include_once (NGGALLERY_ABSPATH. 'admin/functions.php');

// get the gallery
$galleryID = (int) $_POST['galleryselect'];

echo nggAdmin::swfupload_image($galleryID);

?>