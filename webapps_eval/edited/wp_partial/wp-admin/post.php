<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$parent_file = 'edit.php';
$submenu_file = 'edit.php';
wp_reset_vars(array('action','safe_mode','withcomments','posts','content','edited_post_title','comment_error','profile','trackback_url','excerpt','showcomments','commentstart','commentend','commentorder'));
function redirect_post ( $post_ID = '' ) {
{global $action;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $action,"\$action",$AspisChangesCache);
}$referredby = '';
if ( !(empty($_POST[0]['referredby']) || Aspis_empty($_POST[0]['referredby'])))
 {$referredby = preg_replace('|https?://[^/]+|i','',deAspisWarningRC($_POST[0]['referredby']));
$referredby = remove_query_arg('_wp_original_http_referer',$referredby);
}$referer = preg_replace('|https?://[^/]+|i','',wp_get_referer());
if ( !(empty($_POST[0]['mode']) || Aspis_empty($_POST[0]['mode'])) && 'sidebar' == deAspisWarningRC($_POST[0]['mode']))
 {if ( (isset($_POST[0]['saveasdraft']) && Aspis_isset($_POST[0]['saveasdraft'])))
 $location = 'sidebar.php?a=c';
elseif ( (isset($_POST[0]['publish']) && Aspis_isset($_POST[0]['publish'])))
 $location = 'sidebar.php?a=b';
}elseif ( (isset($_POST[0]['save']) && Aspis_isset($_POST[0]['save'])) || (isset($_POST[0]['publish']) && Aspis_isset($_POST[0]['publish'])))
 {$status = get_post_status($post_ID);
if ( (isset($_POST[0]['publish']) && Aspis_isset($_POST[0]['publish'])))
 {switch ( $status ) {
case 'pending':$message = 8;
break ;
case 'future':$message = 9;
break ;
default :$message = 6;
 }
}else 
{{$message = 'draft' == $status ? 10 : 1;
}}$location = add_query_arg('message',$message,get_edit_post_link($post_ID,'url'));
}elseif ( (isset($_POST[0]['addmeta']) && Aspis_isset($_POST[0]['addmeta'])) && deAspisWarningRC($_POST[0]['addmeta']))
 {$location = add_query_arg('message',2,wp_get_referer());
$location = explode('#',$location);
$location = $location[0] . '#postcustom';
}elseif ( (isset($_POST[0]['deletemeta']) && Aspis_isset($_POST[0]['deletemeta'])) && deAspisWarningRC($_POST[0]['deletemeta']))
 {$location = add_query_arg('message',3,wp_get_referer());
$location = explode('#',$location);
$location = $location[0] . '#postcustom';
}elseif ( 'post-quickpress-save-cont' == deAspisWarningRC($_POST[0]['action']))
 {$location = "post.php?action=edit&post=$post_ID&message=7";
}else 
{{$location = add_query_arg('message',4,get_edit_post_link($post_ID,'url'));
}}wp_redirect(apply_filters('redirect_post_location',$location,$post_ID));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$action",$AspisChangesCache);
 }
if ( (isset($_POST[0]['deletepost']) && Aspis_isset($_POST[0]['deletepost'])))
 $action = 'delete';
elseif ( (isset($_POST[0]['wp-preview']) && Aspis_isset($_POST[0]['wp-preview'])) && 'dopreview' == deAspisWarningRC($_POST[0]['wp-preview']))
 $action = 'preview';
$sendback = wp_get_referer();
if ( strpos($sendback,'post.php') !== false || strpos($sendback,'post-new.php') !== false)
 $sendback = admin_url('edit.php');
else 
{$sendback = remove_query_arg(array('trashed','untrashed','deleted','ids'),$sendback);
}switch ( $action ) {
case 'postajaxpost':case 'post':case 'post-quickpress-publish':case 'post-quickpress-save':check_admin_referer('add-post');
if ( 'post-quickpress-publish' == $action)
 $_POST[0]['publish'] = attAspisRCO('publish');
if ( 'post-quickpress-publish' == $action || 'post-quickpress-save' == $action)
 {$_POST[0]['comment_status'] = attAspisRCO(get_option('default_comment_status'));
$_POST[0]['ping_status'] = attAspisRCO(get_option('default_ping_status'));
}if ( !(empty($_POST[0]['quickpress_post_ID']) || Aspis_empty($_POST[0]['quickpress_post_ID'])))
 {$_POST[0]['post_ID'] = attAspisRCO((int)deAspisWarningRC($_POST[0]['quickpress_post_ID']));
$post_ID = edit_post();
}else 
{{$post_ID = 'postajaxpost' == $action ? edit_post() : write_post();
}}if ( 0 === strpos($action,'post-quickpress'))
 {$_POST[0]['post_ID'] = attAspisRCO($post_ID);
require_once (ABSPATH . 'wp-admin/includes/dashboard.php');
wp_dashboard_quick_press();
exit();
}redirect_post($post_ID);
exit();
break ;
case 'edit':$editing = true;
if ( (empty($_GET[0]['post']) || Aspis_empty($_GET[0]['post'])))
 {wp_redirect("post.php");
exit();
}$post_ID = $p = (int)deAspisWarningRC($_GET[0]['post']);
$post = get_post($post_ID);
if ( empty($post->ID))
 wp_die(__('You attempted to edit a post that doesn&#8217;t exist. Perhaps it was deleted?'));
if ( !current_user_can('edit_post',$post_ID))
 wp_die(__('You are not allowed to edit this post.'));
if ( 'trash' == $post->post_status)
 wp_die(__('You can&#8217;t edit this post because it is in the Trash. Please restore it and try again.'));
if ( 'post' != $post->post_type)
 {wp_redirect(get_edit_post_link($post->ID,'url'));
exit();
}wp_enqueue_script('post');
if ( user_can_richedit())
 wp_enqueue_script('editor');
add_thickbox();
wp_enqueue_script('media-upload');
wp_enqueue_script('word-count');
wp_enqueue_script('admin-comments');
enqueue_comment_hotkeys_js();
if ( $last = wp_check_post_lock($post->ID))
 {add_action('admin_notices','_admin_notice_post_locked');
}else 
{{wp_set_post_lock($post->ID);
wp_enqueue_script('autosave');
}}$title = __('Edit Post');
$post = get_post_to_edit($post_ID);
include ('edit-form-advanced.php');
break ;
case 'editattachment':$post_id = (int)deAspisWarningRC($_POST[0]['post_ID']);
check_admin_referer('update-attachment_' . $post_id);
unset($_POST[0]['guid']);
$_POST[0]['post_type'] = attAspisRCO('attachment');
$newmeta = wp_get_attachment_metadata($post_id,true);
$newmeta['thumb'] = deAspisWarningRC($_POST[0]['thumb']);
wp_update_attachment_metadata($post_id,$newmeta);
case 'editpost':$post_ID = (int)deAspisWarningRC($_POST[0]['post_ID']);
check_admin_referer('update-post_' . $post_ID);
$post_ID = edit_post();
redirect_post($post_ID);
exit();
break ;
case 'trash':$post_id = (isset($_GET[0]['post']) && Aspis_isset($_GET[0]['post'])) ? intval(deAspisWarningRC($_GET[0]['post'])) : intval(deAspisWarningRC($_POST[0]['post_ID']));
check_admin_referer('trash-post_' . $post_id);
$post = &get_post($post_id);
if ( !current_user_can('delete_post',$post_id))
 wp_die(__('You are not allowed to move this post to the trash.'));
if ( !wp_trash_post($post_id))
 wp_die(__('Error in moving to trash...'));
wp_redirect(add_query_arg(array('trashed' => 1,'ids' => $post_id),$sendback));
exit();
break ;
case 'untrash':$post_id = (isset($_GET[0]['post']) && Aspis_isset($_GET[0]['post'])) ? intval(deAspisWarningRC($_GET[0]['post'])) : intval(deAspisWarningRC($_POST[0]['post_ID']));
check_admin_referer('untrash-post_' . $post_id);
$post = &get_post($post_id);
if ( !current_user_can('delete_post',$post_id))
 wp_die(__('You are not allowed to move this post out of the trash.'));
if ( !wp_untrash_post($post_id))
 wp_die(__('Error in restoring from trash...'));
wp_redirect(add_query_arg('untrashed',1,$sendback));
exit();
break ;
case 'delete':$post_id = ((isset($_GET[0]['post']) && Aspis_isset($_GET[0]['post']))) ? intval(deAspisWarningRC($_GET[0]['post'])) : intval(deAspisWarningRC($_POST[0]['post_ID']));
check_admin_referer('delete-post_' . $post_id);
$post = &get_post($post_id);
if ( !current_user_can('delete_post',$post_id))
 wp_die(__('You are not allowed to delete this post.'));
$force = !EMPTY_TRASH_DAYS;
if ( $post->post_type == 'attachment')
 {$force = ($force || !MEDIA_TRASH);
if ( !wp_delete_attachment($post_id,$force))
 wp_die(__('Error in deleting...'));
}else 
{{if ( !wp_delete_post($post_id,$force))
 wp_die(__('Error in deleting...'));
}}wp_redirect(add_query_arg('deleted',1,$sendback));
exit();
break ;
case 'preview':check_admin_referer('autosave','autosavenonce');
$url = post_preview();
wp_redirect($url);
exit();
break ;
default :wp_redirect('edit.php');
exit();
break ;
 }
include ('admin-footer.php');
;
?>
<?php 