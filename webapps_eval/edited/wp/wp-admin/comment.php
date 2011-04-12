<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$parent_file = array('edit-comments.php',false);
$submenu_file = array('edit-comments.php',false);
wp_reset_vars(array(array(array('action',false)),false));
if ( ((isset($_POST[0][('deletecomment')]) && Aspis_isset( $_POST [0][('deletecomment')]))))
 $action = array('deletecomment',false);
if ( (('cdc') == $action[0]))
 $action = array('delete',false);
elseif ( (('mac') == $action[0]))
 $action = array('approve',false);
if ( ((isset($_GET[0][('dt')]) && Aspis_isset( $_GET [0][('dt')]))))
 {if ( (('spam') == deAspis($_GET[0]['dt'])))
 $action = array('spam',false);
elseif ( (('trash') == deAspis($_GET[0]['dt'])))
 $action = array('trash',false);
}function comment_footer_die ( $msg ) {
echo AspisCheckPrint(concat2(concat1("<div class='wrap'><p>",$msg),"</p></div>"));
include ('admin-footer.php');
Aspis_exit();
 }
switch ( $action[0] ) {
case ('editcomment'):$title = __(array('Edit Comment',false));
wp_enqueue_script(array('comment',false));
require_once ('admin-header.php');
$comment_id = absint($_GET[0]['c']);
if ( (denot_boolean($comment = get_comment($comment_id))))
 comment_footer_die(concat(__(array('Oops, no comment with this ID.',false)),Aspis_sprintf(concat2(concat1(' <a href="%s">',__(array('Go back',false))),'</a>!'),array('javascript:history.go(-1)',false))));
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment[0]->comment_post_ID))))
 comment_footer_die(__(array('You are not allowed to edit comments on this post.',false)));
if ( (('trash') == $comment[0]->comment_approved[0]))
 comment_footer_die(__(array('This comment is in the Trash. Please move it out of the Trash if you want to edit it.',false)));
$comment = get_comment_to_edit($comment_id);
include ('edit-form-comment.php');
break ;
case ('delete'):case ('approve'):case ('trash'):case ('spam'):require_once ('admin-header.php');
$comment_id = absint($_GET[0]['c']);
$formaction = concat2($action,'comment');
$nonce_action = (('approve') == $action[0]) ? array('approve-comment_',false) : array('delete-comment_',false);
$nonce_action = concat($nonce_action,$comment_id);
if ( (denot_boolean($comment = get_comment_to_edit($comment_id))))
 comment_footer_die(concat(__(array('Oops, no comment with this ID.',false)),Aspis_sprintf(concat2(concat1(' <a href="%s">',__(array('Go back',false))),'</a>!'),array('edit.php',false))));
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment[0]->comment_post_ID))))
 comment_footer_die((('approve') != $action[0]) ? __(array('You are not allowed to delete comments on this post.',false)) : __(array('You are not allowed to edit comments on this post, so you cannot approve this comment.',false)));
;
?>
<div class='wrap'>

<div class="narrow">
<?php switch ( $action[0] ) {
case ('spam'):$caution_msg = __(array('You are about to mark the following comment as spam:',false));
$button = __(array('Spam Comment',false));
break ;
case ('trash'):$caution_msg = __(array('You are about to move the following comment to the Trash:',false));
$button = __(array('Trash Comment',false));
break ;
case ('delete'):$caution_msg = __(array('You are about to delete the following comment:',false));
$button = __(array('Permanently Delete Comment',false));
break ;
default :$caution_msg = __(array('You are about to approve the following comment:',false));
$button = __(array('Approve Comment',false));
break ;
 }
;
?>

<p><strong><?php _e(array('Caution:',false));
;
?></strong> <?php echo AspisCheckPrint($caution_msg);
;
?></p>

<table class="form-table comment-ays">
<tr class="alt">
<th scope="row"><?php _e(array('Author',false));
;
?></th>
<td><?php echo AspisCheckPrint($comment[0]->comment_author);
;
?></td>
</tr>
<?php if ( $comment[0]->comment_author_email[0])
 {;
?>
<tr>
<th scope="row"><?php _e(array('E-mail',false));
;
?></th>
<td><?php echo AspisCheckPrint($comment[0]->comment_author_email);
;
?></td>
</tr>
<?php };
?>
<?php if ( $comment[0]->comment_author_url[0])
 {;
?>
<tr>
<th scope="row"><?php _e(array('URL',false));
;
?></th>
<td><a href="<?php echo AspisCheckPrint($comment[0]->comment_author_url);
;
?>"><?php echo AspisCheckPrint($comment[0]->comment_author_url);
;
?></a></td>
</tr>
<?php };
?>
<tr>
<th scope="row" valign="top"><?php echo AspisCheckPrint(_x(array('Comment',false),array('noun',false)));
;
?></th>
<td><?php echo AspisCheckPrint($comment[0]->comment_content);
;
?></td>
</tr>
</table>

<p><?php _e(array('Are you sure you want to do that?',false));
;
?></p>

<form action='comment.php' method='get'>

<table width="100%">
<tr>
<td><a class="button" href="<?php echo AspisCheckPrint(admin_url(array('edit-comments.php',false)));
;
?>"><?php esc_attr_e(array('No',false));
;
?></a></td>
<td class="textright"><input type='submit' class="button" value='<?php echo AspisCheckPrint(esc_attr($button));
;
?>' /></td>
</tr>
</table>

<?php wp_nonce_field($nonce_action);
;
?>
<input type='hidden' name='action' value='<?php echo AspisCheckPrint(esc_attr($formaction));
;
?>' />
<input type='hidden' name='p' value='<?php echo AspisCheckPrint(esc_attr($comment[0]->comment_post_ID));
;
?>' />
<input type='hidden' name='c' value='<?php echo AspisCheckPrint(esc_attr($comment[0]->comment_ID));
;
?>' />
<input type='hidden' name='noredir' value='1' />
</form>

</div>
</div>
<?php break ;
case ('deletecomment'):case ('trashcomment'):case ('untrashcomment'):case ('spamcomment'):case ('unspamcomment'):$comment_id = absint($_REQUEST[0]['c']);
check_admin_referer(concat1('delete-comment_',$comment_id));
$noredir = array((isset($_REQUEST[0][('noredir')]) && Aspis_isset( $_REQUEST [0][('noredir')])),false);
if ( (denot_boolean($comment = get_comment($comment_id))))
 comment_footer_die(concat(__(array('Oops, no comment with this ID.',false)),Aspis_sprintf(concat2(concat1(' <a href="%s">',__(array('Go back',false))),'</a>!'),array('edit-comments.php',false))));
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment[0]->comment_post_ID))))
 comment_footer_die(__(array('You are not allowed to edit comments on this post.',false)));
if ( (((('') != deAspis(wp_get_referer())) && (false == $noredir[0])) && (false === strpos(deAspis(wp_get_referer()),'comment.php'))))
 $redir = wp_get_referer();
elseif ( ((('') != deAspis(wp_get_original_referer())) && (false == $noredir[0])))
 $redir = wp_get_original_referer();
else 
{$redir = admin_url(array('edit-comments.php',false));
}$redir = remove_query_arg(array(array(array('spammed',false),array('unspammed',false),array('trashed',false),array('untrashed',false),array('deleted',false),array('ids',false)),false),$redir);
switch ( $action[0] ) {
case ('deletecomment'):wp_delete_comment($comment_id);
$redir = add_query_arg(array(array('deleted' => array('1',false,false)),false),$redir);
break ;
case ('trashcomment'):wp_trash_comment($comment_id);
$redir = add_query_arg(array(array('trashed' => array('1',false,false),deregisterTaint(array('ids',false)) => addTaint($comment_id)),false),$redir);
break ;
case ('untrashcomment'):wp_untrash_comment($comment_id);
$redir = add_query_arg(array(array('untrashed' => array('1',false,false)),false),$redir);
break ;
case ('spamcomment'):wp_spam_comment($comment_id);
$redir = add_query_arg(array(array('spammed' => array('1',false,false),deregisterTaint(array('ids',false)) => addTaint($comment_id)),false),$redir);
break ;
case ('unspamcomment'):wp_unspam_comment($comment_id);
$redir = add_query_arg(array(array('unspammed' => array('1',false,false)),false),$redir);
break ;
 }
wp_redirect($redir);
Aspis_exit();
break ;
case ('approvecomment'):case ('unapprovecomment'):$comment_id = absint($_GET[0]['c']);
check_admin_referer(concat1('approve-comment_',$comment_id));
$noredir = array((isset($_GET[0][('noredir')]) && Aspis_isset( $_GET [0][('noredir')])),false);
if ( (denot_boolean($comment = get_comment($comment_id))))
 comment_footer_die(concat(__(array('Oops, no comment with this ID.',false)),Aspis_sprintf(concat2(concat1(' <a href="%s">',__(array('Go back',false))),'</a>!'),array('edit.php',false))));
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment[0]->comment_post_ID))))
 {if ( (('approvecomment') == $action[0]))
 comment_footer_die(__(array('You are not allowed to edit comments on this post, so you cannot approve this comment.',false)));
else 
{comment_footer_die(__(array('You are not allowed to edit comments on this post, so you cannot disapprove this comment.',false)));
}}if ( ((('') != deAspis(wp_get_referer())) && (false == $noredir[0])))
 $redir = remove_query_arg(array(array(array('approved',false),array('unapproved',false)),false),wp_get_referer());
else 
{$redir = admin_url(concat1('edit-comments.php?p=',absint($comment[0]->comment_post_ID)));
}if ( (('approvecomment') == $action[0]))
 {wp_set_comment_status($comment_id,array('approve',false));
$redir = add_query_arg(array(array('approved' => array(1,false,false)),false),$redir);
}else 
{{wp_set_comment_status($comment_id,array('hold',false));
$redir = add_query_arg(array(array('unapproved' => array(1,false,false)),false),$redir);
}}wp_redirect($redir);
Aspis_exit();
break ;
case ('editedcomment'):$comment_id = absint($_POST[0]['comment_ID']);
$comment_post_id = absint($_POST[0]['comment_post_ID']);
check_admin_referer(concat1('update-comment_',$comment_id));
edit_comment();
$location = concat(concat2((((empty($_POST[0][('referredby')]) || Aspis_empty( $_POST [0][('referredby')]))) ? concat1("edit-comments.php?p=",$comment_post_id) : $_POST[0]['referredby']),'#comment-'),$comment_id);
$location = apply_filters(array('comment_edit_redirect',false),$location,$comment_id);
wp_redirect($location);
Aspis_exit();
break ;
default :wp_die(__(array('Unknown action.',false)));
break ;
 }
include ('admin-footer.php');
;
?>
<?php 