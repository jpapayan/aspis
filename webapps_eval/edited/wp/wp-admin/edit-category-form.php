<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('You do not have sufficient permissions to edit categories for this blog.',false)));
if ( (!((isset($category) && Aspis_isset( $category)))))
 $category = object_cast(array(array(),false));
function _fill_empty_category ( &$category ) {
if ( (!((isset($category[0]->name) && Aspis_isset( $category[0] ->name )))))
 $category[0]->name = array('',false);
if ( (!((isset($category[0]->slug) && Aspis_isset( $category[0] ->slug )))))
 $category[0]->slug = array('',false);
if ( (!((isset($category[0]->parent) && Aspis_isset( $category[0] ->parent )))))
 $category[0]->parent = array('',false);
if ( (!((isset($category[0]->description) && Aspis_isset( $category[0] ->description )))))
 $category[0]->description = array('',false);
 }
do_action(array('edit_category_form_pre',false),$category);
_fill_empty_category($category);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Edit Category',false));
;
?></h2>
<div id="ajax-response"></div>
<form name="editcat" id="editcat" method="post" action="categories.php" class="validate">
<input type="hidden" name="action" value="editedcat" />
<input type="hidden" name="cat_ID" value="<?php echo AspisCheckPrint(esc_attr($category[0]->term_id));
?>" />
<?php wp_original_referer_field(array(true,false),array('previous',false));
wp_nonce_field(concat1('update-category_',$cat_ID));
;
?>
	<table class="form-table">
		<tr class="form-field form-required">
			<th scope="row" valign="top"><label for="cat_name"><?php _e(array('Category Name',false));
?></label></th>
			<td><input name="cat_name" id="cat_name" type="text" value="<?php echo AspisCheckPrint(esc_attr($category[0]->name));
;
?>" size="40" aria-required="true" /></td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="category_nicename"><?php _e(array('Category Slug',false));
?></label></th>
			<td><input name="category_nicename" id="category_nicename" type="text" value="<?php echo AspisCheckPrint(esc_attr(apply_filters(array('editable_slug',false),$category[0]->slug)));
;
?>" size="40" /><br />
            <span class="description"><?php _e(array('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',false));
;
?></span></td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="category_parent"><?php _e(array('Category Parent',false));
?></label></th>
			<td>
	  			<?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('category_parent',false,false),'orderby' => array('name',false,false),deregisterTaint(array('selected',false)) => addTaint($category[0]->parent),deregisterTaint(array('exclude',false)) => addTaint($category[0]->term_id),'hierarchical' => array(true,false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('None',false)))),false));
;
?><br />
                <span class="description"><?php _e(array('Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.',false));
;
?></span>
	  		</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="category_description"><?php _e(array('Description',false));
?></label></th>
			<td><textarea name="category_description" id="category_description" rows="5" cols="50" style="width: 97%;"><?php echo AspisCheckPrint(esc_html($category[0]->description));
;
?></textarea><br />
            <span class="description"><?php _e(array('The description is not prominent by default; however, some themes may show it.',false));
;
?></span></td>
		</tr>
		<?php do_action(array('edit_category_form_fields',false),$category);
;
?>
	</table>
<p class="submit"><input type="submit" class="button-primary" name="submit" value="<?php esc_attr_e(array('Update Category',false));
;
?>" /></p>
<?php do_action(array('edit_category_form',false),$category);
;
?>
</form>
</div>
<?php 