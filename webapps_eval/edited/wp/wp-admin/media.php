<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$parent_file = array('upload.php',false);
$submenu_file = array('upload.php',false);
wp_reset_vars(array(array(array('action',false)),false));
switch ( $action[0] ) {
case ('editattachment'):$attachment_id = int_cast($_POST[0]['attachment_id']);
check_admin_referer(array('media-form',false));
if ( (denot_boolean(current_user_can(array('edit_post',false),$attachment_id))))
 wp_die(__(array('You are not allowed to edit this attachment.',false)));
$errors = media_upload_form_handler();
if ( ((empty($errors) || Aspis_empty( $errors))))
 {$location = array('media.php',false);
if ( deAspis($referer = wp_get_original_referer()))
 {if ( ((false !== strpos($referer[0],'upload.php')) || (deAspis(url_to_postid($referer)) == $attachment_id[0])))
 $location = $referer;
}if ( (false !== strpos($location[0],'upload.php')))
 {$location = remove_query_arg(array('message',false),$location);
$location = add_query_arg(array('posted',false),$attachment_id,$location);
}elseif ( (false !== strpos($location[0],'media.php')))
 {$location = add_query_arg(array('message',false),array('updated',false),$location);
}wp_redirect($location);
Aspis_exit();
};
case ('edit'):$title = __(array('Edit Media',false));
if ( ((empty($errors) || Aspis_empty( $errors))))
 $errors = array(null,false);
if ( ((empty($_GET[0][('attachment_id')]) || Aspis_empty( $_GET [0][('attachment_id')]))))
 {wp_redirect(array('upload.php',false));
Aspis_exit();
}$att_id = int_cast($_GET[0]['attachment_id']);
if ( (denot_boolean(current_user_can(array('edit_post',false),$att_id))))
 wp_die(__(array('You are not allowed to edit this attachment.',false)));
$att = get_post($att_id);
if ( ((empty($att[0]->ID) || Aspis_empty( $att[0] ->ID ))))
 wp_die(__(array('You attempted to edit an attachment that doesn&#8217;t exist. Perhaps it was deleted?',false)));
if ( ($att[0]->post_status[0] == ('trash')))
 wp_die(__(array('You can&#8217;t edit this attachment because it is in the Trash. Please move it out of the Trash and try again.',false)));
add_filter(array('attachment_fields_to_edit',false),array('media_single_attachment_fields_to_edit',false),array(10,false),array(2,false));
wp_enqueue_script(array('wp-ajax-response',false));
wp_enqueue_script(array('image-edit',false));
wp_enqueue_style(array('imgareaselect',false));
require ('admin-header.php');
$parent_file = array('upload.php',false);
$message = array('',false);
$class = array('',false);
if ( ((isset($_GET[0][('message')]) && Aspis_isset( $_GET [0][('message')]))))
 {switch ( deAspis($_GET[0]['message']) ) {
case ('updated'):$message = __(array('Media attachment updated.',false));
$class = array('updated fade',false);
break ;
;
 }
}if ( $message[0])
 echo AspisCheckPrint(concat2(concat(concat2(concat1("<div id='message' class='",$class),"'><p>"),$message),"</p></div>\n"));
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Edit Media',false));
;
?></h2>

<form method="post" action="<?php echo AspisCheckPrint(esc_url(remove_query_arg(array('message',false))));
;
?>" class="media-upload-form" id="media-single-form">
<div class="media-single">
<div id='media-item-<?php echo AspisCheckPrint($att_id);
;
?>' class='media-item'>
<?php echo AspisCheckPrint(get_media_item($att_id,array(array('toggle' => array(false,false,false),'send' => array(false,false,false),'delete' => array(false,false,false),'show_title' => array(false,false,false),deregisterTaint(array('errors',false)) => addTaint($errors)),false)));
;
?>
</div>
</div>

<p class="submit">
<input type="submit" class="button-primary" name="save" value="<?php esc_attr_e(array('Update Media',false));
;
?>" />
<input type="hidden" name="post_id" id="post_id" value="<?php echo AspisCheckPrint(((isset($post_id) && Aspis_isset( $post_id))) ? esc_attr($post_id) : array('',false));
;
?>" />
<input type="hidden" name="attachment_id" id="attachment_id" value="<?php echo AspisCheckPrint(esc_attr($att_id));
;
?>" />
<input type="hidden" name="action" value="editattachment" />
<?php wp_original_referer_field(array(true,false),array('previous',false));
;
?>
<?php wp_nonce_field(array('media-form',false));
;
?>
</p>
</form>

</div>

<?php require ('admin-footer.php');
Aspis_exit();
default :wp_redirect(array('upload.php',false));
Aspis_exit();
 }
;
?>
<?php 