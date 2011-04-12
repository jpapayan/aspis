<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
if ( (!((isset($post_ID) && Aspis_isset( $post_ID)))))
 $post_ID = array(0,false);
if ( (!((isset($temp_ID) && Aspis_isset( $temp_ID)))))
 $temp_ID = array(0,false);
$message = array(false,false);
if ( ((isset($_GET[0][('message')]) && Aspis_isset( $_GET [0][('message')]))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('message',false))),addTaint(absint($_GET[0]['message'])));
switch ( deAspis($_GET[0]['message']) ) {
case (1):$message = Aspis_sprintf(__(array('Page updated. <a href="%s">View page</a>',false)),get_permalink($post_ID));
break ;
case (2):$message = __(array('Custom field updated.',false));
break ;
case (3):$message = __(array('Custom field deleted.',false));
break ;
case (4):$message = Aspis_sprintf(__(array('Page published. <a href="%s">View page</a>',false)),get_permalink($post_ID));
break ;
case (5):if ( ((isset($_GET[0][('revision')]) && Aspis_isset( $_GET [0][('revision')]))))
 $message = Aspis_sprintf(__(array('Page restored to revision from %s',false)),wp_post_revision_title(int_cast($_GET[0]['revision']),array(false,false)));
break ;
case (6):$message = Aspis_sprintf(__(array('Page submitted. <a target="_blank" href="%s">Preview page</a>',false)),add_query_arg(array('preview',false),array('true',false),get_permalink($post_ID)));
break ;
case (7):$message = Aspis_sprintf(__(array('Page scheduled for: <b>%1$s</b>. <a target="_blank" href="%2$s">Preview page</a>',false)),date_i18n(__(array('M j, Y @ G:i',false)),attAspis(strtotime($post[0]->post_date[0]))),get_permalink($post_ID));
break ;
case (8):$message = Aspis_sprintf(__(array('Page draft updated. <a target="_blank" href="%s">Preview page</a>',false)),add_query_arg(array('preview',false),array('true',false),get_permalink($post_ID)));
break ;
 }
}$notice = array(false,false);
if ( ((0) == $post_ID[0]))
 {$form_action = array('post',false);
$nonce_action = array('add-page',false);
$temp_ID = array(deAspis(negate(array(1,false))) * time(),false);
$form_extra = concat2(concat1("<input type='hidden' id='post_ID' name='temp_ID' value='",$temp_ID),"' />");
}else 
{{$post_ID = int_cast($post_ID);
$form_action = array('editpost',false);
$nonce_action = concat1('update-page_',$post_ID);
$form_extra = concat2(concat1("<input type='hidden' id='post_ID' name='post_ID' value='",$post_ID),"' />");
$autosave = wp_get_post_autosave($post_ID);
if ( ($autosave[0] && (deAspis(mysql2date(array('U',false),$autosave[0]->post_modified_gmt,array(false,false))) > deAspis(mysql2date(array('U',false),$post[0]->post_modified_gmt,array(false,false))))))
 $notice = Aspis_sprintf(__(array('There is an autosave of this page that is more recent than the version below.  <a href="%s">View the autosave</a>.',false)),get_edit_post_link($autosave[0]->ID));
}}$temp_ID = int_cast($temp_ID);
$user_ID = int_cast($user_ID);
require_once ('includes/meta-boxes.php');
add_meta_box(array('submitdiv',false),__(array('Publish',false)),array('post_submit_meta_box',false),array('page',false),array('side',false),array('core',false));
add_meta_box(array('pageparentdiv',false),__(array('Attributes',false)),array('page_attributes_meta_box',false),array('page',false),array('side',false),array('core',false));
add_meta_box(array('postcustom',false),__(array('Custom Fields',false)),array('post_custom_meta_box',false),array('page',false),array('normal',false),array('core',false));
add_meta_box(array('commentstatusdiv',false),__(array('Discussion',false)),array('post_comment_status_meta_box',false),array('page',false),array('normal',false),array('core',false));
add_meta_box(array('slugdiv',false),__(array('Page Slug',false)),array('post_slug_meta_box',false),array('page',false),array('normal',false),array('core',false));
if ( deAspis(current_theme_supports(array('post-thumbnails',false),array('page',false))))
 add_meta_box(array('postimagediv',false),__(array('Page Image',false)),array('post_thumbnail_meta_box',false),array('page',false),array('side',false),array('low',false));
$authors = get_editable_user_ids($current_user[0]->id,array(true,false),array('page',false));
if ( ($post[0]->post_author[0] && (denot_boolean(Aspis_in_array($post[0]->post_author,$authors)))))
 arrayAssignAdd($authors[0][],addTaint($post[0]->post_author));
if ( ($authors[0] && (count($authors[0]) > (1))))
 add_meta_box(array('pageauthordiv',false),__(array('Page Author',false)),array('post_author_meta_box',false),array('page',false),array('normal',false),array('core',false));
if ( (((0) < $post_ID[0]) && deAspis(wp_get_post_revisions($post_ID))))
 add_meta_box(array('revisionsdiv',false),__(array('Page Revisions',false)),array('post_revisions_meta_box',false),array('page',false),array('normal',false),array('core',false));
do_action(array('do_meta_boxes',false),array('page',false),array('normal',false),$post);
do_action(array('do_meta_boxes',false),array('page',false),array('advanced',false),$post);
do_action(array('do_meta_boxes',false),array('page',false),array('side',false),$post);
require_once ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form name="post" action="page.php" method="post" id="post">
<?php if ( $notice[0])
 {;
?>
<div id="notice" class="error"><p><?php echo AspisCheckPrint($notice);
?></p></div>
<?php };
?>
<?php if ( $message[0])
 {;
?>
<div id="message" class="updated fade"><p><?php echo AspisCheckPrint($message);
;
?></p></div>
<?php };
?>

<?php wp_nonce_field($nonce_action);
;
?>

<input type="hidden" id="user-id" name="user_ID" value="<?php echo AspisCheckPrint($user_ID);
?>" />
<input type="hidden" id="hiddenaction" name="action" value='<?php echo AspisCheckPrint(esc_attr($form_action));
?>' />
<input type="hidden" id="originalaction" name="originalaction" value="<?php echo AspisCheckPrint(esc_attr($form_action));
?>" />
<input type="hidden" id="post_author" name="post_author" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_author));
;
?>" />
<?php echo AspisCheckPrint($form_extra);
?>
<input type="hidden" id="post_type" name="post_type" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_type));
?>" />
<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_status));
?>" />
<input name="referredby" type="hidden" id="referredby" value="<?php echo AspisCheckPrint(esc_url(Aspis_stripslashes(wp_get_referer())));
;
?>" />
<?php if ( (('draft') != $post[0]->post_status[0]))
 wp_original_referer_field(array(true,false),array('previous',false));
;
?>

<div id="poststuff" class="metabox-holder<?php echo AspisCheckPrint(((2) == $screen_layout_columns[0]) ? array(' has-right-sidebar',false) : array('',false));
;
?>">

<div id="side-info-column" class="inner-sidebar">
<?php do_action(array('submitpage_box',false));
$side_meta_boxes = do_meta_boxes(array('page',false),array('side',false),$post);
;
?>
</div>

<div id="post-body">
<div id="post-body-content">
<div id="titlediv">
<div id="titlewrap">
	<label class="screen-reader-text" for="title"><?php _e(array('Title',false));
?></label>
	<input type="text" name="post_title" size="30" tabindex="1" value="<?php echo AspisCheckPrint(esc_attr(Aspis_htmlspecialchars($post[0]->post_title)));
;
?>" id="title" autocomplete="off" />
</div>
<div class="inside">
<?php $sample_permalink_html = get_sample_permalink_html($post[0]->ID);
;
?>
	<div id="edit-slug-box">
<?php if ( ((!((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID )))) && (!((empty($sample_permalink_html) || Aspis_empty( $sample_permalink_html))))))
 {echo AspisCheckPrint($sample_permalink_html);
};
?>
	</div>
</div>
</div>

<div id="<?php echo AspisCheckPrint(deAspis(user_can_richedit()) ? array('postdivrich',false) : array('postdiv',false));
;
?>" class="postarea">

<?php the_editor($post[0]->post_content);
;
?>
<table id="post-status-info" cellspacing="0"><tbody><tr>
	<td id="wp-word-count"></td>
	<td class="autosave-info">
	<span id="autosave">&nbsp;</span>

<?php if ( $post_ID[0])
 {if ( deAspis($last_id = get_post_meta($post_ID,array('_edit_last',false),array(true,false))))
 {$last_user = get_userdata($last_id);
printf(deAspis(__(array('Last edited by %1$s on %2$s at %3$s',false))),deAspisRC(esc_html($last_user[0]->display_name)),deAspisRC(mysql2date(get_option(array('date_format',false)),$post[0]->post_modified)),deAspisRC(mysql2date(get_option(array('time_format',false)),$post[0]->post_modified)));
}else 
{{printf(deAspis(__(array('Last edited on %1$s at %2$s',false))),deAspisRC(mysql2date(get_option(array('date_format',false)),$post[0]->post_modified)),deAspisRC(mysql2date(get_option(array('time_format',false)),$post[0]->post_modified)));
}}};
?>
	</td>
</tr></tbody></table>

<?php wp_nonce_field(array('autosave',false),array('autosavenonce',false),array(false,false));
wp_nonce_field(array('closedpostboxes',false),array('closedpostboxesnonce',false),array(false,false));
wp_nonce_field(array('getpermalink',false),array('getpermalinknonce',false),array(false,false));
wp_nonce_field(array('samplepermalink',false),array('samplepermalinknonce',false),array(false,false));
wp_nonce_field(array('meta-box-order',false),array('meta-box-order-nonce',false),array(false,false));
;
?>
</div>

<?php do_meta_boxes(array('page',false),array('normal',false),$post);
do_action(array('edit_page_form',false));
do_meta_boxes(array('page',false),array('advanced',false),$post);
;
?>

</div>
</div>
</div>

</form>
</div>

<script type="text/javascript">
try{document.post.title.focus();}catch(e){}
</script>
<?php 