<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
$post_ID = ((isset($post_ID) && Aspis_isset( $post_ID))) ? int_cast($post_ID) : array(0,false);
$action = ((isset($action) && Aspis_isset( $action))) ? $action : array('',false);
$message = array(false,false);
if ( ((isset($_GET[0][('message')]) && Aspis_isset( $_GET [0][('message')]))))
 {arrayAssign($_GET[0],deAspis(registerTaint(array('message',false))),addTaint(absint($_GET[0]['message'])));
switch ( deAspis($_GET[0]['message']) ) {
case (1):$message = Aspis_sprintf(__(array('Post updated. <a href="%s">View post</a>',false)),get_permalink($post_ID));
break ;
case (2):$message = __(array('Custom field updated.',false));
break ;
case (3):$message = __(array('Custom field deleted.',false));
break ;
case (4):$message = __(array('Post updated.',false));
break ;
case (5):if ( ((isset($_GET[0][('revision')]) && Aspis_isset( $_GET [0][('revision')]))))
 $message = Aspis_sprintf(__(array('Post restored to revision from %s',false)),wp_post_revision_title(int_cast($_GET[0]['revision']),array(false,false)));
break ;
case (6):$message = Aspis_sprintf(__(array('Post published. <a href="%s">View post</a>',false)),get_permalink($post_ID));
break ;
case (7):$message = __(array('Post saved.',false));
break ;
case (8):$message = Aspis_sprintf(__(array('Post submitted. <a target="_blank" href="%s">Preview post</a>',false)),add_query_arg(array('preview',false),array('true',false),get_permalink($post_ID)));
break ;
case (9):$message = Aspis_sprintf(__(array('Post scheduled for: <b>%1$s</b>. <a target="_blank" href="%2$s">Preview post</a>',false)),date_i18n(__(array('M j, Y @ G:i',false)),attAspis(strtotime($post[0]->post_date[0]))),get_permalink($post_ID));
break ;
case (10):$message = Aspis_sprintf(__(array('Post draft updated. <a target="_blank" href="%s">Preview post</a>',false)),add_query_arg(array('preview',false),array('true',false),get_permalink($post_ID)));
break ;
 }
}$notice = array(false,false);
if ( ((0) == $post_ID[0]))
 {$form_action = array('post',false);
$temp_ID = array(deAspis(negate(array(1,false))) * time(),false);
$form_extra = concat2(concat1("<input type='hidden' id='post_ID' name='temp_ID' value='",esc_attr($temp_ID)),"' />");
$autosave = array(false,false);
}else 
{{$form_action = array('editpost',false);
$form_extra = concat2(concat1("<input type='hidden' id='post_ID' name='post_ID' value='",esc_attr($post_ID)),"' />");
$autosave = wp_get_post_autosave($post_ID);
if ( ($autosave[0] && (deAspis(mysql2date(array('U',false),$autosave[0]->post_modified_gmt,array(false,false))) > deAspis(mysql2date(array('U',false),$post[0]->post_modified_gmt,array(false,false))))))
 {foreach ( deAspis(_wp_post_revision_fields()) as $autosave_field =>$_autosave_field )
{restoreTaint($autosave_field,$_autosave_field);
{if ( (deAspis(normalize_whitespace($autosave[0]->$autosave_field[0])) != deAspis(normalize_whitespace($post[0]->$autosave_field[0]))))
 {$notice = Aspis_sprintf(__(array('There is an autosave of this post that is more recent than the version below.  <a href="%s">View the autosave</a>.',false)),get_edit_post_link($autosave[0]->ID));
break ;
}}}unset($autosave_field,$_autosave_field);
}}}require_once ('includes/meta-boxes.php');
add_meta_box(array('submitdiv',false),__(array('Publish',false)),array('post_submit_meta_box',false),array('post',false),array('side',false),array('core',false));
foreach ( deAspis(get_object_taxonomies(array('post',false))) as $tax_name  )
{if ( (denot_boolean(is_taxonomy_hierarchical($tax_name))))
 {$taxonomy = get_taxonomy($tax_name);
$label = ((isset($taxonomy[0]->label) && Aspis_isset( $taxonomy[0] ->label ))) ? esc_attr($taxonomy[0]->label) : $tax_name;
add_meta_box(concat1('tagsdiv-',$tax_name),$label,array('post_tags_meta_box',false),array('post',false),array('side',false),array('core',false));
}}add_meta_box(array('categorydiv',false),__(array('Categories',false)),array('post_categories_meta_box',false),array('post',false),array('side',false),array('core',false));
if ( deAspis(current_theme_supports(array('post-thumbnails',false),array('post',false))))
 add_meta_box(array('postimagediv',false),__(array('Post Thumbnail',false)),array('post_thumbnail_meta_box',false),array('post',false),array('side',false),array('low',false));
add_meta_box(array('postexcerpt',false),__(array('Excerpt',false)),array('post_excerpt_meta_box',false),array('post',false),array('normal',false),array('core',false));
add_meta_box(array('trackbacksdiv',false),__(array('Send Trackbacks',false)),array('post_trackback_meta_box',false),array('post',false),array('normal',false),array('core',false));
add_meta_box(array('postcustom',false),__(array('Custom Fields',false)),array('post_custom_meta_box',false),array('post',false),array('normal',false),array('core',false));
do_action(array('dbx_post_advanced',false));
add_meta_box(array('commentstatusdiv',false),__(array('Discussion',false)),array('post_comment_status_meta_box',false),array('post',false),array('normal',false),array('core',false));
if ( ((('publish') == $post[0]->post_status[0]) || (('private') == $post[0]->post_status[0])))
 add_meta_box(array('commentsdiv',false),__(array('Comments',false)),array('post_comment_meta_box',false),array('post',false),array('normal',false),array('core',false));
if ( (!((('pending') == $post[0]->post_status[0]) && (denot_boolean(current_user_can(array('publish_posts',false)))))))
 add_meta_box(array('slugdiv',false),__(array('Post Slug',false)),array('post_slug_meta_box',false),array('post',false),array('normal',false),array('core',false));
$authors = get_editable_user_ids($current_user[0]->id);
if ( ($post[0]->post_author[0] && (denot_boolean(Aspis_in_array($post[0]->post_author,$authors)))))
 arrayAssignAdd($authors[0][],addTaint($post[0]->post_author));
if ( ($authors[0] && (count($authors[0]) > (1))))
 add_meta_box(array('authordiv',false),__(array('Post Author',false)),array('post_author_meta_box',false),array('post',false),array('normal',false),array('core',false));
if ( (((0) < $post_ID[0]) && deAspis(wp_get_post_revisions($post_ID))))
 add_meta_box(array('revisionsdiv',false),__(array('Post Revisions',false)),array('post_revisions_meta_box',false),array('post',false),array('normal',false),array('core',false));
do_action(array('do_meta_boxes',false),array('post',false),array('normal',false),$post);
do_action(array('do_meta_boxes',false),array('post',false),array('advanced',false),$post);
do_action(array('do_meta_boxes',false),array('post',false),array('side',false),$post);
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
<form name="post" action="post.php" method="post" id="post">
<?php if ( ((0) == $post_ID[0]))
 wp_nonce_field(array('add-post',false));
else 
{wp_nonce_field(concat1('update-post_',$post_ID));
};
?>

<input type="hidden" id="user-id" name="user_ID" value="<?php echo AspisCheckPrint(int_cast($user_ID));
?>" />
<input type="hidden" id="hiddenaction" name="action" value="<?php echo AspisCheckPrint(esc_attr($form_action));
?>" />
<input type="hidden" id="originalaction" name="originalaction" value="<?php echo AspisCheckPrint(esc_attr($form_action));
?>" />
<input type="hidden" id="post_author" name="post_author" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_author));
;
?>" />
<input type="hidden" id="post_type" name="post_type" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_type));
?>" />
<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_status));
?>" />
<input name="referredby" type="hidden" id="referredby" value="<?php echo AspisCheckPrint(esc_url(Aspis_stripslashes(wp_get_referer())));
;
?>" />
<?php if ( (('draft') != $post[0]->post_status[0]))
 wp_original_referer_field(array(true,false),array('previous',false));
echo AspisCheckPrint($form_extra);
?>

<div id="poststuff" class="metabox-holder<?php echo AspisCheckPrint(((2) == $screen_layout_columns[0]) ? array(' has-right-sidebar',false) : array('',false));
;
?>">
<div id="side-info-column" class="inner-sidebar">

<?php do_action(array('submitpost_box',false));
;
?>

<?php $side_meta_boxes = do_meta_boxes(array('post',false),array('side',false),$post);
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
if ( (!((('pending') == $post[0]->post_status[0]) && (denot_boolean(current_user_can(array('publish_posts',false)))))))
 {;
?>
	<div id="edit-slug-box">
<?php if ( ((!((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID )))) && (!((empty($sample_permalink_html) || Aspis_empty( $sample_permalink_html))))))
 {echo AspisCheckPrint($sample_permalink_html);
};
?>
	</div>
<?php };
?>
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
 {echo AspisCheckPrint(array('<span id="last-edit">',false));
if ( deAspis($last_id = get_post_meta($post_ID,array('_edit_last',false),array(true,false))))
 {$last_user = get_userdata($last_id);
printf(deAspis(__(array('Last edited by %1$s on %2$s at %3$s',false))),deAspisRC(esc_html($last_user[0]->display_name)),deAspisRC(mysql2date(get_option(array('date_format',false)),$post[0]->post_modified)),deAspisRC(mysql2date(get_option(array('time_format',false)),$post[0]->post_modified)));
}else 
{{printf(deAspis(__(array('Last edited on %1$s at %2$s',false))),deAspisRC(mysql2date(get_option(array('date_format',false)),$post[0]->post_modified)),deAspisRC(mysql2date(get_option(array('time_format',false)),$post[0]->post_modified)));
}}echo AspisCheckPrint(array('</span>',false));
};
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

<?php do_meta_boxes(array('post',false),array('normal',false),$post);
do_action(array('edit_form_advanced',false));
do_meta_boxes(array('post',false),array('advanced',false),$post);
do_action(array('dbx_post_sidebar',false));
;
?>

</div>
</div>
<br class="clear" />
</div><!-- /poststuff -->
</form>
</div>

<?php wp_comment_reply();
;
?>

<?php if ( ((((isset($post[0]->post_title) && Aspis_isset( $post[0] ->post_title ))) && (('') == $post[0]->post_title[0])) || (((isset($_GET[0][('message')]) && Aspis_isset( $_GET [0][('message')]))) && ((2) > deAspis($_GET[0]['message'])))))
 {;
?>
<script type="text/javascript">
try{document.post.title.focus();}catch(e){}
</script>
<?php };
?>
<?php 