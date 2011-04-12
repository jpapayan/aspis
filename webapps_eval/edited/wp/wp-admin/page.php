<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$parent_file = array('edit-pages.php',false);
$submenu_file = array('edit-pages.php',false);
wp_reset_vars(array(array(array('action',false)),false));
function redirect_page ( $page_ID ) {
global $action;
$referredby = array('',false);
if ( (!((empty($_POST[0][('referredby')]) || Aspis_empty( $_POST [0][('referredby')])))))
 {$referredby = Aspis_preg_replace(array('|https?://[^/]+|i',false),array('',false),$_POST[0]['referredby']);
$referredby = remove_query_arg(array('_wp_original_http_referer',false),$referredby);
}$referer = Aspis_preg_replace(array('|https?://[^/]+|i',false),array('',false),wp_get_referer());
if ( (((('post') == deAspis($_POST[0]['originalaction'])) && (!((empty($_POST[0][('mode')]) || Aspis_empty( $_POST [0][('mode')]))))) && (('sidebar') == deAspis($_POST[0]['mode']))))
 {$location = array('sidebar.php?a=b',false);
}elseif ( (((isset($_POST[0][('save')]) && Aspis_isset( $_POST [0][('save')]))) || ((isset($_POST[0][('publish')]) && Aspis_isset( $_POST [0][('publish')])))))
 {$status = get_post_status($page_ID);
if ( ((isset($_POST[0][('publish')]) && Aspis_isset( $_POST [0][('publish')]))))
 {switch ( $status[0] ) {
case ('pending'):$message = array(6,false);
break ;
case ('future'):$message = array(7,false);
break ;
default :$message = array(4,false);
 }
}else 
{{$message = (('draft') == $status[0]) ? array(8,false) : array(1,false);
}}$location = add_query_arg(array('message',false),$message,get_edit_post_link($page_ID,array('url',false)));
}elseif ( ((isset($_POST[0][('addmeta')]) && Aspis_isset( $_POST [0][('addmeta')]))))
 {$location = add_query_arg(array('message',false),array(2,false),wp_get_referer());
$location = Aspis_explode(array('#',false),$location);
$location = concat2(attachAspis($location,(0)),'#postcustom');
}elseif ( ((isset($_POST[0][('deletemeta')]) && Aspis_isset( $_POST [0][('deletemeta')]))))
 {$location = add_query_arg(array('message',false),array(3,false),wp_get_referer());
$location = Aspis_explode(array('#',false),$location);
$location = concat2(attachAspis($location,(0)),'#postcustom');
}else 
{{$location = add_query_arg(array('message',false),array(1,false),get_edit_post_link($page_ID,array('url',false)));
}}wp_redirect(apply_filters(array('redirect_page_location',false),$location,$page_ID));
 }
if ( ((isset($_POST[0][('deletepost')]) && Aspis_isset( $_POST [0][('deletepost')]))))
 $action = array("delete",false);
elseif ( (((isset($_POST[0][('wp-preview')]) && Aspis_isset( $_POST [0][('wp-preview')]))) && (('dopreview') == deAspis($_POST[0]['wp-preview']))))
 $action = array('preview',false);
$sendback = wp_get_referer();
if ( ((strpos($sendback[0],'page.php') !== false) || (strpos($sendback[0],'page-new.php') !== false)))
 $sendback = admin_url(array('edit-pages.php',false));
else 
{$sendback = remove_query_arg(array(array(array('trashed',false),array('untrashed',false),array('deleted',false),array('ids',false)),false),$sendback);
}switch ( $action[0] ) {
case ('post'):check_admin_referer(array('add-page',false));
$page_ID = write_post();
redirect_page($page_ID);
Aspis_exit();
break ;
case ('edit'):$title = __(array('Edit Page',false));
$editing = array(true,false);
$page_ID = $post_ID = $p = int_cast($_GET[0]['post']);
$post = get_post_to_edit($page_ID);
if ( ((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID ))))
 wp_die(__(array('You attempted to edit a page that doesn&#8217;t exist. Perhaps it was deleted?',false)));
if ( (denot_boolean(current_user_can(array('edit_page',false),$page_ID))))
 wp_die(__(array('You are not allowed to edit this page.',false)));
if ( (('trash') == $post[0]->post_status[0]))
 wp_die(__(array('You can&#8217;t edit this page because it is in the Trash. Please move it out of the Trash and try again.',false)));
if ( (('page') != $post[0]->post_type[0]))
 {wp_redirect(get_edit_post_link($post_ID,array('url',false)));
Aspis_exit();
}wp_enqueue_script(array('post',false));
if ( deAspis(user_can_richedit()))
 wp_enqueue_script(array('editor',false));
add_thickbox();
wp_enqueue_script(array('media-upload',false));
wp_enqueue_script(array('word-count',false));
if ( deAspis($last = wp_check_post_lock($post[0]->ID)))
 {add_action(array('admin_notices',false),array('_admin_notice_post_locked',false));
}else 
{{wp_set_post_lock($post[0]->ID);
wp_enqueue_script(array('autosave',false));
}}include ('edit-page-form.php');
break ;
case ('editattachment'):$page_id = $post_ID = int_cast($_POST[0]['post_ID']);
check_admin_referer(concat1('update-attachment_',$page_id));
unset($_POST[0][('guid')]);
arrayAssign($_POST[0],deAspis(registerTaint(array('post_type',false))),addTaint(array('attachment',false)));
$newmeta = wp_get_attachment_metadata($page_id,array(true,false));
arrayAssign($newmeta[0],deAspis(registerTaint(array('thumb',false))),addTaint($_POST[0]['thumb']));
wp_update_attachment_metadata($newmeta);
case ('editpost'):$page_ID = int_cast($_POST[0]['post_ID']);
check_admin_referer(concat1('update-page_',$page_ID));
$page_ID = edit_post();
redirect_page($page_ID);
Aspis_exit();
break ;
case ('trash'):$post_id = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? Aspis_intval($_GET[0]['post']) : Aspis_intval($_POST[0]['post_ID']);
check_admin_referer(concat1('trash-page_',$post_id));
$post = &get_post($post_id);
if ( (denot_boolean(current_user_can(array('delete_page',false),$post_id))))
 wp_die(__(array('You are not allowed to move this page to the trash.',false)));
if ( (denot_boolean(wp_trash_post($post_id))))
 wp_die(__(array('Error in moving to trash...',false)));
wp_redirect(add_query_arg(array(array('trashed' => array(1,false,false),deregisterTaint(array('ids',false)) => addTaint($post_id)),false),$sendback));
Aspis_exit();
break ;
case ('untrash'):$post_id = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? Aspis_intval($_GET[0]['post']) : Aspis_intval($_POST[0]['post_ID']);
check_admin_referer(concat1('untrash-page_',$post_id));
$post = &get_post($post_id);
if ( (denot_boolean(current_user_can(array('delete_page',false),$post_id))))
 wp_die(__(array('You are not allowed to move this page out of the trash.',false)));
if ( (denot_boolean(wp_untrash_post($post_id))))
 wp_die(__(array('Error in restoring from trash...',false)));
wp_redirect(add_query_arg(array('untrashed',false),array(1,false),$sendback));
Aspis_exit();
break ;
case ('delete'):$page_id = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? Aspis_intval($_GET[0]['post']) : Aspis_intval($_POST[0]['post_ID']);
check_admin_referer(concat1('delete-page_',$page_id));
$page = &get_post($page_id);
if ( (denot_boolean(current_user_can(array('delete_page',false),$page_id))))
 wp_die(__(array('You are not allowed to delete this page.',false)));
if ( ($page[0]->post_type[0] == ('attachment')))
 {if ( (denot_boolean(wp_delete_attachment($page_id))))
 wp_die(__(array('Error in deleting...',false)));
}else 
{{if ( (denot_boolean(wp_delete_post($page_id))))
 wp_die(__(array('Error in deleting...',false)));
}}wp_redirect(add_query_arg(array('deleted',false),array(1,false),$sendback));
Aspis_exit();
break ;
case ('preview'):check_admin_referer(array('autosave',false),array('autosavenonce',false));
$url = post_preview();
wp_redirect($url);
Aspis_exit();
break ;
default :wp_redirect(array('edit-pages.php',false));
Aspis_exit();
break ;
 }
include ('admin-footer.php');
;
?>
<?php 