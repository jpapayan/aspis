<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('You do not have sufficient permissions to edit tags for this blog.',false)));
if ( ((empty($tag_ID) || Aspis_empty( $tag_ID))))
 {;
?>
	<div id="message" class="updated fade"><p><strong><?php _e(array('A tag was not selected for editing.',false));
;
?></strong></p></div>
<?php return ;
}do_action(array('edit_tag_form_pre',false),$tag);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Edit Tag',false));
;
?></h2>
<div id="ajax-response"></div>
<form name="edittag" id="edittag" method="post" action="edit-tags.php" class="validate">
<input type="hidden" name="action" value="editedtag" />
<input type="hidden" name="tag_ID" value="<?php echo AspisCheckPrint(esc_attr($tag[0]->term_id));
?>" />
<input type="hidden" name="taxonomy" value="<?php echo AspisCheckPrint(esc_attr($taxonomy));
?>" />
<?php wp_original_referer_field(array(true,false),array('previous',false));
wp_nonce_field(concat1('update-tag_',$tag_ID));
;
?>
	<table class="form-table">
		<tr class="form-field form-required">
			<th scope="row" valign="top"><label for="name"><?php _e(array('Tag name',false));
?></label></th>
			<td><input name="name" id="name" type="text" value="<?php if ( ((isset($tag[0]->name) && Aspis_isset( $tag[0] ->name ))))
 echo AspisCheckPrint(esc_attr($tag[0]->name));
;
?>" size="40" aria-required="true" /></td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="slug"><?php _e(array('Tag slug',false));
?></label></th>
			<td><input name="slug" id="slug" type="text" value="<?php if ( ((isset($tag[0]->slug) && Aspis_isset( $tag[0] ->slug ))))
 echo AspisCheckPrint(esc_attr(apply_filters(array('editable_slug',false),$tag[0]->slug)));
;
?>" size="40" />
            <p class="description"><?php _e(array('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',false));
;
?></p></td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="description"><?php _e(array('Description',false));
?></label></th>
			<td><textarea name="description" id="description" rows="5" cols="50" style="width: 97%;"><?php echo AspisCheckPrint(esc_html($tag[0]->description));
;
?></textarea><br />
            <span class="description"><?php _e(array('The description is not prominent by default, however some themes may show it.',false));
;
?></span></td>
		</tr>
		<?php do_action(array('edit_tag_form_fields',false),$tag);
;
?>
	</table>
<p class="submit"><input type="submit" class="button-primary" name="submit" value="<?php esc_attr_e(array('Update Tag',false));
;
?>" /></p>
<?php do_action(array('edit_tag_form',false),$tag);
;
?>
</form>
</div>
<?php 