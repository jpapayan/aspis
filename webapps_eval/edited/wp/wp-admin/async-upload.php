<?php require_once('AspisMain.php'); ?><?php
define(('WP_ADMIN'),true);
if ( defined(('ABSPATH')))
 require_once (deconcat12(ABSPATH,'wp-load.php'));
else 
{require_once ('../wp-load.php');
}if ( ((deAspis(is_ssl()) && ((empty($_COOKIE[0][SECURE_AUTH_COOKIE]) || Aspis_empty( $_COOKIE [0][SECURE_AUTH_COOKIE])))) && (!((empty($_REQUEST[0][('auth_cookie')]) || Aspis_empty( $_REQUEST [0][('auth_cookie')]))))))
 arrayAssign($_COOKIE[0],deAspis(registerTaint(array(SECURE_AUTH_COOKIE,false))),addTaint($_REQUEST[0]['auth_cookie']));
elseif ( (((empty($_COOKIE[0][AUTH_COOKIE]) || Aspis_empty( $_COOKIE [0][AUTH_COOKIE]))) && (!((empty($_REQUEST[0][('auth_cookie')]) || Aspis_empty( $_REQUEST [0][('auth_cookie')]))))))
 arrayAssign($_COOKIE[0],deAspis(registerTaint(array(AUTH_COOKIE,false))),addTaint($_REQUEST[0]['auth_cookie']));
if ( (((empty($_COOKIE[0][LOGGED_IN_COOKIE]) || Aspis_empty( $_COOKIE [0][LOGGED_IN_COOKIE]))) && (!((empty($_REQUEST[0][('logged_in_cookie')]) || Aspis_empty( $_REQUEST [0][('logged_in_cookie')]))))))
 arrayAssign($_COOKIE[0],deAspis(registerTaint(array(LOGGED_IN_COOKIE,false))),addTaint($_REQUEST[0]['logged_in_cookie']));
unset($current_user);
require_once ('admin.php');
header((deconcat1('Content-Type: text/plain; charset=',get_option(array('blog_charset',false)))));
if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 wp_die(__(array('You do not have permission to upload files.',false)));
if ( ((((isset($_REQUEST[0][('attachment_id')]) && Aspis_isset( $_REQUEST [0][('attachment_id')]))) && deAspis(($id = Aspis_intval($_REQUEST[0]['attachment_id'])))) && deAspis($_REQUEST[0]['fetch'])))
 {if ( ((2) == deAspis($_REQUEST[0]['fetch'])))
 {add_filter(array('attachment_fields_to_edit',false),array('media_single_attachment_fields_to_edit',false),array(10,false),array(2,false));
echo AspisCheckPrint(get_media_item($id,array(array('send' => array(false,false,false),'delete' => array(true,false,false)),false)));
}else 
{{add_filter(array('attachment_fields_to_edit',false),array('media_post_single_attachment_fields_to_edit',false),array(10,false),array(2,false));
echo AspisCheckPrint(get_media_item($id));
}}Aspis_exit();
}check_admin_referer(array('media-form',false));
$id = media_handle_upload(array('async-upload',false),$_REQUEST[0]['post_id']);
if ( deAspis(is_wp_error($id)))
 {echo AspisCheckPrint(concat2(concat1('<div id="media-upload-error">',esc_html($id[0]->get_error_message())),'</div>'));
Aspis_exit();
}if ( deAspis($_REQUEST[0]['short']))
 {echo AspisCheckPrint($id);
}else 
{{$type = $_REQUEST[0]['type'];
echo AspisCheckPrint(apply_filters(concat1("async_upload_",$type),$id));
}};
?>
<?php 