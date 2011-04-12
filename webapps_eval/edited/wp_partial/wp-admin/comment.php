<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$parent_file = 'edit-comments.php';
$submenu_file = 'edit-comments.php';
wp_reset_vars(array('action'));
if ( (isset($_POST[0]['deletecomment']) && Aspis_isset($_POST[0]['deletecomment'])))
 $action = 'deletecomment';
if ( 'cdc' == $action)
 $action = 'delete';
elseif ( 'mac' == $action)
 $action = 'approve';
if ( (isset($_GET[0]['dt']) && Aspis_isset($_GET[0]['dt'])))
 {if ( 'spam' == deAspisWarningRC($_GET[0]['dt']))
 $action = 'spam';
elseif ( 'trash' == deAspisWarningRC($_GET[0]['dt']))
 $action = 'trash';
}function comment_footer_die ( $msg ) {
echo "<div class='wrap'><p>$msg</p></div>";
include ('admin-footer.php');
exit();
 }
switch ( $action ) {
case 'editcomment':$title = __('Edit Comment');
wp_enqueue_script('comment');
require_once ('admin-header.php');
$comment_id = absint(deAspisWarningRC($_GET[0]['c']));
if ( !$comment = get_comment($comment_id))
 comment_footer_die(__('Oops, no comment with this ID.') . sprintf(' <a href="%s">' . __('Go back') . '</a>!','javascript:history.go(-1)'));
if ( !current_user_can('edit_post',$comment->comment_post_ID))
 comment_footer_die(__('You are not allowed to edit comments on this post.'));
if ( 'trash' == $comment->comment_approved)
 comment_footer_die(__('This comment is in the Trash. Please move it out of the Trash if you want to edit it.'));
$comment = get_comment_to_edit($comment_id);
include ('edit-form-comment.php');
break ;
case 'delete':case 'approve':case 'trash':case 'spam':require_once ('admin-header.php');
$comment_id = absint(deAspisWarningRC($_GET[0]['c']));
$formaction = $action . 'comment';
$nonce_action = 'approve' == $action ? 'approve-comment_' : 'delete-comment_';
$nonce_action .= $comment_id;
if ( !$comment = get_comment_to_edit($comment_id))
 comment_footer_die(__('Oops, no comment with this ID.') . sprintf(' <a href="%s">' . __('Go back') . '</a>!','edit.php'));
if ( !current_user_can('edit_post',$comment->comment_post_ID))
 comment_footer_die('approve' != $action ? __('You are not allowed to delete comments on this post.') : __('You are not allowed to edit comments on this post, so you cannot approve this comment.'));
;
?>
<div class='wrap'>

<div class="narrow">
<?php switch ( $action ) {
case 'spam':$caution_msg = __('You are about to mark the following comment as spam:');
$button = __('Spam Comment');
break ;
case 'trash':$caution_msg = __('You are about to move the following comment to the Trash:');
$button = __('Trash Comment');
break ;
case 'delete':$caution_msg = __('You are about to delete the following comment:');
$button = __('Permanently Delete Comment');
break ;
default :$caution_msg = __('You are about to approve the following comment:');
$button = __('Approve Comment');
break ;
 }
;
?>

<p><strong><?php _e('Caution:');
;
?></strong> <?php echo $caution_msg;
;
?></p>

<table class="form-table comment-ays">
<tr class="alt">
<th scope="row"><?php _e('Author');
;
?></th>
<td><?php echo $comment->comment_author;
;
?></td>
</tr>
<?php if ( $comment->comment_author_email)
 {;
?>
<tr>
<th scope="row"><?php _e('E-mail');
;
?></th>
<td><?php echo $comment->comment_author_email;
;
?></td>
</tr>
<?php };
?>
<?php if ( $comment->comment_author_url)
 {;
?>
<tr>
<th scope="row"><?php _e('URL');
;
?></th>
<td><a href="<?php echo $comment->comment_author_url;
;
?>"><?php echo $comment->comment_author_url;
;
?></a></td>
</tr>
<?php };
?>
<tr>
<th scope="row" valign="top"><?php echo _x('Comment','noun');
;
?></th>
<td><?php echo $comment->comment_content;
;
?></td>
</tr>
</table>

<p><?php _e('Are you sure you want to do that?');
;
?></p>

<form action='comment.php' method='get'>

<table width="100%">
<tr>
<td><a class="button" href="<?php echo admin_url('edit-comments.php');
;
?>"><?php esc_attr_e('No');
;
?></a></td>
<td class="textright"><input type='submit' class="button" value='<?php echo esc_attr($button);
;
?>' /></td>
</tr>
</table>

<?php wp_nonce_field($nonce_action);
;
?>
<input type='hidden' name='action' value='<?php echo esc_attr($formaction);
;
?>' />
<input type='hidden' name='p' value='<?php echo esc_attr($comment->comment_post_ID);
;
?>' />
<input type='hidden' name='c' value='<?php echo esc_attr($comment->comment_ID);
;
?>' />
<input type='hidden' name='noredir' value='1' />
</form>

</div>
</div>
<?php break ;
case 'deletecomment':case 'trashcomment':case 'untrashcomment':case 'spamcomment':case 'unspamcomment':$comment_id = absint(deAspisWarningRC($_REQUEST[0]['c']));
check_admin_referer('delete-comment_' . $comment_id);
$noredir = (isset($_REQUEST[0]['noredir']) && Aspis_isset($_REQUEST[0]['noredir']));
if ( !$comment = get_comment($comment_id))
 comment_footer_die(__('Oops, no comment with this ID.') . sprintf(' <a href="%s">' . __('Go back') . '</a>!','edit-comments.php'));
if ( !current_user_can('edit_post',$comment->comment_post_ID))
 comment_footer_die(__('You are not allowed to edit comments on this post.'));
if ( '' != wp_get_referer() && false == $noredir && false === strpos(wp_get_referer(),'comment.php'))
 $redir = wp_get_referer();
elseif ( '' != wp_get_original_referer() && false == $noredir)
 $redir = wp_get_original_referer();
else 
{$redir = admin_url('edit-comments.php');
}$redir = remove_query_arg(array('spammed','unspammed','trashed','untrashed','deleted','ids'),$redir);
switch ( $action ) {
case 'deletecomment':wp_delete_comment($comment_id);
$redir = add_query_arg(array('deleted' => '1'),$redir);
break ;
case 'trashcomment':wp_trash_comment($comment_id);
$redir = add_query_arg(array('trashed' => '1','ids' => $comment_id),$redir);
break ;
case 'untrashcomment':wp_untrash_comment($comment_id);
$redir = add_query_arg(array('untrashed' => '1'),$redir);
break ;
case 'spamcomment':wp_spam_comment($comment_id);
$redir = add_query_arg(array('spammed' => '1','ids' => $comment_id),$redir);
break ;
case 'unspamcomment':wp_unspam_comment($comment_id);
$redir = add_query_arg(array('unspammed' => '1'),$redir);
break ;
 }
wp_redirect($redir);
exit();
break ;
case 'approvecomment':case 'unapprovecomment':$comment_id = absint(deAspisWarningRC($_GET[0]['c']));
check_admin_referer('approve-comment_' . $comment_id);
$noredir = (isset($_GET[0]['noredir']) && Aspis_isset($_GET[0]['noredir']));
if ( !$comment = get_comment($comment_id))
 comment_footer_die(__('Oops, no comment with this ID.') . sprintf(' <a href="%s">' . __('Go back') . '</a>!','edit.php'));
if ( !current_user_can('edit_post',$comment->comment_post_ID))
 {if ( 'approvecomment' == $action)
 comment_footer_die(__('You are not allowed to edit comments on this post, so you cannot approve this comment.'));
else 
{comment_footer_die(__('You are not allowed to edit comments on this post, so you cannot disapprove this comment.'));
}}if ( '' != wp_get_referer() && false == $noredir)
 $redir = remove_query_arg(array('approved','unapproved'),wp_get_referer());
else 
{$redir = admin_url('edit-comments.php?p=' . absint($comment->comment_post_ID));
}if ( 'approvecomment' == $action)
 {wp_set_comment_status($comment_id,'approve');
$redir = add_query_arg(array('approved' => 1),$redir);
}else 
{{wp_set_comment_status($comment_id,'hold');
$redir = add_query_arg(array('unapproved' => 1),$redir);
}}wp_redirect($redir);
exit();
break ;
case 'editedcomment':$comment_id = absint(deAspisWarningRC($_POST[0]['comment_ID']));
$comment_post_id = absint(deAspisWarningRC($_POST[0]['comment_post_ID']));
check_admin_referer('update-comment_' . $comment_id);
edit_comment();
$location = ((empty($_POST[0]['referredby']) || Aspis_empty($_POST[0]['referredby'])) ? "edit-comments.php?p=$comment_post_id" : deAspisWarningRC($_POST[0]['referredby'])) . '#comment-' . $comment_id;
$location = apply_filters('comment_edit_redirect',$location,$comment_id);
wp_redirect($location);
exit();
break ;
default :wp_die(__('Unknown action.'));
break ;
 }
include ('admin-footer.php');
;
?>
<?php 