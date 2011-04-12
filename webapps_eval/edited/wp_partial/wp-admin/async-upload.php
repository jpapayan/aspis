<?php require_once('AspisMain.php'); ?><?php
define('WP_ADMIN',true);
if ( defined('ABSPATH'))
 require_once (ABSPATH . 'wp-load.php');
else 
{require_once ('../wp-load.php');
}if ( is_ssl() && (empty($_COOKIE[0][SECURE_AUTH_COOKIE]) || Aspis_empty($_COOKIE[0][SECURE_AUTH_COOKIE])) && !(empty($_REQUEST[0]['auth_cookie']) || Aspis_empty($_REQUEST[0]['auth_cookie'])))
 $_COOKIE[0][SECURE_AUTH_COOKIE] = attAspisRCO(deAspisWarningRC($_REQUEST[0]['auth_cookie']));
elseif ( (empty($_COOKIE[0][AUTH_COOKIE]) || Aspis_empty($_COOKIE[0][AUTH_COOKIE])) && !(empty($_REQUEST[0]['auth_cookie']) || Aspis_empty($_REQUEST[0]['auth_cookie'])))
 $_COOKIE[0][AUTH_COOKIE] = attAspisRCO(deAspisWarningRC($_REQUEST[0]['auth_cookie']));
if ( (empty($_COOKIE[0][LOGGED_IN_COOKIE]) || Aspis_empty($_COOKIE[0][LOGGED_IN_COOKIE])) && !(empty($_REQUEST[0]['logged_in_cookie']) || Aspis_empty($_REQUEST[0]['logged_in_cookie'])))
 $_COOKIE[0][LOGGED_IN_COOKIE] = attAspisRCO(deAspisWarningRC($_REQUEST[0]['logged_in_cookie']));
unset($current_user);
require_once ('admin.php');
header('Content-Type: text/plain; charset=' . get_option('blog_charset'));
if ( !current_user_can('upload_files'))
 wp_die(__('You do not have permission to upload files.'));
if ( (isset($_REQUEST[0]['attachment_id']) && Aspis_isset($_REQUEST[0]['attachment_id'])) && ($id = intval(deAspisWarningRC($_REQUEST[0]['attachment_id']))) && deAspisWarningRC($_REQUEST[0]['fetch']))
 {if ( 2 == deAspisWarningRC($_REQUEST[0]['fetch']))
 {add_filter('attachment_fields_to_edit','media_single_attachment_fields_to_edit',10,2);
echo get_media_item($id,array('send' => false,'delete' => true));
}else 
{{add_filter('attachment_fields_to_edit','media_post_single_attachment_fields_to_edit',10,2);
echo get_media_item($id);
}}exit();
}check_admin_referer('media-form');
$id = media_handle_upload('async-upload',deAspisWarningRC($_REQUEST[0]['post_id']));
if ( is_wp_error($id))
 {echo '<div id="media-upload-error">' . esc_html($id->get_error_message()) . '</div>';
exit();
}if ( deAspisWarningRC($_REQUEST[0]['short']))
 {echo $id;
}else 
{{$type = deAspisWarningRC($_REQUEST[0]['type']);
echo apply_filters("async_upload_{$type}",$id);
}};
?>
<?php 