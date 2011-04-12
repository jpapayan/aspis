<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$parent_file = array('edit.php',false);
$submenu_file = array('edit.php',false);
wp_reset_vars(array(array(array('action',false),array('safe_mode',false),array('withcomments',false),array('posts',false),array('content',false),array('edited_post_title',false),array('comment_error',false),array('profile',false),array('trackback_url',false),array('excerpt',false),array('showcomments',false),array('commentstart',false),array('commentend',false),array('commentorder',false)),false));
function redirect_post ( $post_ID = array('',false) ) {
global $action;
$referredby = array('',false);
if ( (!((empty($_POST[0][('referredby')]) || Aspis_empty( $_POST [0][('referredby')])))))
 {$referredby = Aspis_preg_replace(array('|https?://[^/]+|i',false),array('',false),$_POST[0]['referredby']);
$referredby = remove_query_arg(array('_wp_original_http_referer',false),$referredby);
}$referer = Aspis_preg_replace(array('|https?://[^/]+|i',false),array('',false),wp_get_referer());
if ( ((!((empty($_POST[0][('mode')]) || Aspis_empty( $_POST [0][('mode')])))) && (('sidebar') == deAspis($_POST[0]['mode']))))
 {if ( ((isset($_POST[0][('saveasdraft')]) && Aspis_isset( $_POST [0][('saveasdraft')]))))
 $location = array('sidebar.php?a=c',false);
elseif ( ((isset($_POST[0][('publish')]) && Aspis_isset( $_POST [0][('publish')]))))
 $location = array('sidebar.php?a=b',false);
}elseif ( (((isset($_POST[0][('save')]) && Aspis_isset( $_POST [0][('save')]))) || ((isset($_POST[0][('publish')]) && Aspis_isset( $_POST [0][('publish')])))))
 {$status = get_post_status($post_ID);
if ( ((isset($_POST[0][('publish')]) && Aspis_isset( $_POST [0][('publish')]))))
 {switch ( $status[0] ) {
case ('pending'):$message = array(8,false);
break ;
case ('future'):$message = array(9,false);
break ;
default :$message = array(6,false);
 }
}else 
{{$message = (('draft') == $status[0]) ? array(10,false) : array(1,false);
}}$location = add_query_arg(array('message',false),$message,get_edit_post_link($post_ID,array('url',false)));
}elseif ( (((isset($_POST[0][('addmeta')]) && Aspis_isset( $_POST [0][('addmeta')]))) && deAspis($_POST[0]['addmeta'])))
 {$location = add_query_arg(array('message',false),array(2,false),wp_get_referer());
$location = Aspis_explode(array('#',false),$location);
$location = concat2(attachAspis($location,(0)),'#postcustom');
}elseif ( (((isset($_POST[0][('deletemeta')]) && Aspis_isset( $_POST [0][('deletemeta')]))) && deAspis($_POST[0]['deletemeta'])))
 {$location = add_query_arg(array('message',false),array(3,false),wp_get_referer());
$location = Aspis_explode(array('#',false),$location);
$location = concat2(attachAspis($location,(0)),'#postcustom');
}elseif ( (('post-quickpress-save-cont') == deAspis($_POST[0]['action'])))
 {$location = concat2(concat1("post.php?action=edit&post=",$post_ID),"&message=7");
}else 
{{$location = add_query_arg(array('message',false),array(4,false),get_edit_post_link($post_ID,array('url',false)));
}}wp_redirect(apply_filters(array('redirect_post_location',false),$location,$post_ID));
 }
if ( ((isset($_POST[0][('deletepost')]) && Aspis_isset( $_POST [0][('deletepost')]))))
 $action = array('delete',false);
elseif ( (((isset($_POST[0][('wp-preview')]) && Aspis_isset( $_POST [0][('wp-preview')]))) && (('dopreview') == deAspis($_POST[0]['wp-preview']))))
 $action = array('preview',false);
$sendback = wp_get_referer();
if ( ((strpos($sendback[0],'post.php') !== false) || (strpos($sendback[0],'post-new.php') !== false)))
 $sendback = admin_url(array('edit.php',false));
else 
{$sendback = remove_query_arg(array(array(array('trashed',false),array('untrashed',false),array('deleted',false),array('ids',false)),false),$sendback);
}switch ( $action[0] ) {
case ('postajaxpost'):case ('post'):case ('post-quickpress-publish'):case ('post-quickpress-save'):check_admin_referer(array('add-post',false));
if ( (('post-quickpress-publish') == $action[0]))
 arrayAssign($_POST[0],deAspis(registerTaint(array('publish',false))),addTaint(array('publish',false)));
if ( ((('post-quickpress-publish') == $action[0]) || (('post-quickpress-save') == $action[0])))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('comment_status',false))),addTaint(get_option(array('default_comment_status',false))));
arrayAssign($_POST[0],deAspis(registerTaint(array('ping_status',false))),addTaint(get_option(array('default_ping_status',false))));
}if ( (!((empty($_POST[0][('quickpress_post_ID')]) || Aspis_empty( $_POST [0][('quickpress_post_ID')])))))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('post_ID',false))),addTaint(int_cast($_POST[0]['quickpress_post_ID'])));
$post_ID = edit_post();
}else 
{{$post_ID = (('postajaxpost') == $action[0]) ? edit_post() : write_post();
}}if ( ((0) === strpos($action[0],'post-quickpress')))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('post_ID',false))),addTaint($post_ID));
require_once (deconcat12(ABSPATH,'wp-admin/includes/dashboard.php'));
wp_dashboard_quick_press();
Aspis_exit();
}redirect_post($post_ID);
Aspis_exit();
break ;
case ('edit'):$editing = array(true,false);
if ( ((empty($_GET[0][('post')]) || Aspis_empty( $_GET [0][('post')]))))
 {wp_redirect(array("post.php",false));
Aspis_exit();
}$post_ID = $p = int_cast($_GET[0]['post']);
$post = get_post($post_ID);
if ( ((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID ))))
 wp_die(__(array('You attempted to edit a post that doesn&#8217;t exist. Perhaps it was deleted?',false)));
if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 wp_die(__(array('You are not allowed to edit this post.',false)));
if ( (('trash') == $post[0]->post_status[0]))
 wp_die(__(array('You can&#8217;t edit this post because it is in the Trash. Please restore it and try again.',false)));
if ( (('post') != $post[0]->post_type[0]))
 {wp_redirect(get_edit_post_link($post[0]->ID,array('url',false)));
Aspis_exit();
}wp_enqueue_script(array('post',false));
if ( deAspis(user_can_richedit()))
 wp_enqueue_script(array('editor',false));
add_thickbox();
wp_enqueue_script(array('media-upload',false));
wp_enqueue_script(array('word-count',false));
wp_enqueue_script(array('admin-comments',false));
enqueue_comment_hotkeys_js();
if ( deAspis($last = wp_check_post_lock($post[0]->ID)))
 {add_action(array('admin_notices',false),array('_admin_notice_post_locked',false));
}else 
{{wp_set_post_lock($post[0]->ID);
wp_enqueue_script(array('autosave',false));
}}$title = __(array('Edit Post',false));
$post = get_post_to_edit($post_ID);
include ('edit-form-advanced.php');
break ;
case ('editattachment'):$post_id = int_cast($_POST[0]['post_ID']);
check_admin_referer(concat1('update-attachment_',$post_id));
unset($_POST[0][('guid')]);
arrayAssign($_POST[0],deAspis(registerTaint(array('post_type',false))),addTaint(array('attachment',false)));
$newmeta = wp_get_attachment_metadata($post_id,array(true,false));
arrayAssign($newmeta[0],deAspis(registerTaint(array('thumb',false))),addTaint($_POST[0]['thumb']));
wp_update_attachment_metadata($post_id,$newmeta);
case ('editpost'):$post_ID = int_cast($_POST[0]['post_ID']);
check_admin_referer(concat1('update-post_',$post_ID));
$post_ID = edit_post();
redirect_post($post_ID);
Aspis_exit();
break ;
case ('trash'):$post_id = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? Aspis_intval($_GET[0]['post']) : Aspis_intval($_POST[0]['post_ID']);
check_admin_referer(concat1('trash-post_',$post_id));
$post = &get_post($post_id);
if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to move this post to the trash.',false)));
if ( (denot_boolean(wp_trash_post($post_id))))
 wp_die(__(array('Error in moving to trash...',false)));
wp_redirect(add_query_arg(array(array('trashed' => array(1,false,false),deregisterTaint(array('ids',false)) => addTaint($post_id)),false),$sendback));
Aspis_exit();
break ;
case ('untrash'):$post_id = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? Aspis_intval($_GET[0]['post']) : Aspis_intval($_POST[0]['post_ID']);
check_admin_referer(concat1('untrash-post_',$post_id));
$post = &get_post($post_id);
if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to move this post out of the trash.',false)));
if ( (denot_boolean(wp_untrash_post($post_id))))
 wp_die(__(array('Error in restoring from trash...',false)));
wp_redirect(add_query_arg(array('untrashed',false),array(1,false),$sendback));
Aspis_exit();
break ;
case ('delete'):$post_id = ((isset($_GET[0][('post')]) && Aspis_isset( $_GET [0][('post')]))) ? Aspis_intval($_GET[0]['post']) : Aspis_intval($_POST[0]['post_ID']);
check_admin_referer(concat1('delete-post_',$post_id));
$post = &get_post($post_id);
if ( (denot_boolean(current_user_can(array('delete_post',false),$post_id))))
 wp_die(__(array('You are not allowed to delete this post.',false)));
$force = not_boolean(array(EMPTY_TRASH_DAYS,false));
if ( ($post[0]->post_type[0] == ('attachment')))
 {$force = (array($force[0] || (!(MEDIA_TRASH)),false));
if ( (denot_boolean(wp_delete_attachment($post_id,$force))))
 wp_die(__(array('Error in deleting...',false)));
}else 
{{if ( (denot_boolean(wp_delete_post($post_id,$force))))
 wp_die(__(array('Error in deleting...',false)));
}}wp_redirect(add_query_arg(array('deleted',false),array(1,false),$sendback));
Aspis_exit();
break ;
case ('preview'):check_admin_referer(array('autosave',false),array('autosavenonce',false));
$url = post_preview();
wp_redirect($url);
Aspis_exit();
break ;
default :wp_redirect(array('edit.php',false));
Aspis_exit();
break ;
 }
include ('admin-footer.php');
;
?>
<?php 