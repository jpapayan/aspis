<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('You do not have sufficient permissions to edit link categories for this blog.',false)));
if ( (!((isset($category) && Aspis_isset( $category)))))
 $category = object_cast(array(array(),false));
if ( (!((empty($cat_ID) || Aspis_empty( $cat_ID)))))
 {$heading = concat2(concat1('<h2>',__(array('Edit Link Category',false))),'</h2>');
$submit_text = __(array('Update Category',false));
$form = array('<form name="editcat" id="editcat" method="post" action="link-category.php" class="validate">',false);
$action = array('editedcat',false);
$nonce_action = concat1('update-link-category_',$cat_ID);
do_action(array('edit_link_category_form_pre',false),$category);
}else 
{{$heading = concat2(concat1('<h2>',__(array('Add Link Category',false))),'</h2>');
$submit_text = __(array('Add Category',false));
$form = array('<form name="addcat" id="addcat" class="add:the-list: validate" method="post" action="link-category.php">',false);
$action = array('addcat',false);
$nonce_action = array('add-link-category',false);
do_action(array('add_link_category_form_pre',false),$category);
}}function _fill_empty_link_category ( &$category ) {
if ( (!((isset($category[0]->name) && Aspis_isset( $category[0] ->name )))))
 $category[0]->name = array('',false);
if ( (!((isset($category[0]->slug) && Aspis_isset( $category[0] ->slug )))))
 $category[0]->slug = array('',false);
if ( (!((isset($category[0]->description) && Aspis_isset( $category[0] ->description )))))
 $category[0]->description = array('',false);
 }
_fill_empty_link_category($category);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<?php echo AspisCheckPrint($heading);
?>
<div id="ajax-response"></div>
<?php echo AspisCheckPrint($form);
?>
<input type="hidden" name="action" value="<?php echo AspisCheckPrint(esc_attr($action));
?>" />
<input type="hidden" name="cat_ID" value="<?php echo AspisCheckPrint(esc_attr($category[0]->term_id));
?>" />
<?php wp_original_referer_field(array(true,false),array('previous',false));
wp_nonce_field($nonce_action);
;
?>
	<table class="form-table">
		<tr class="form-field form-required">
			<th scope="row" valign="top"><label for="name"><?php _e(array('Link Category name',false));
?></label></th>
			<td><input name="name" id="name" type="text" value="<?php echo AspisCheckPrint(esc_attr($category[0]->name));
;
?>" size="40" aria-required="true" /></td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="slug"><?php _e(array('Link Category slug',false));
?></label></th>
			<td><input name="slug" id="slug" type="text" value="<?php echo AspisCheckPrint(esc_attr(apply_filters(array('editable_slug',false),$category[0]->slug)));
;
?>" size="40" /><br />
            <?php _e(array('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',false));
;
?></td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="description"><?php _e(array('Description (optional)',false));
?></label></th>
			<td><textarea name="description" id="description" rows="5" cols="50" style="width: 97%;"><?php echo AspisCheckPrint($category[0]->description);
;
?></textarea><br />
			<span class="description"><?php _e(array('The description is not prominent by default; however, some themes may show it.',false));
;
?></span></td>
		</tr>
		<?php do_action(array('edit_link_category_form_fields',false),$category);
;
?>
	</table>
<p class="submit"><input type="submit" class="button-primary" name="submit" value="<?php echo AspisCheckPrint(esc_attr($submit_text));
?>" /></p>
<?php do_action(array('edit_link_category_form',false),$category);
;
?>
</form>
</div>
<?php 