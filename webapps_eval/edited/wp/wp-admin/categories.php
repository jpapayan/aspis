<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$title = __(array('Categories',false));
wp_reset_vars(array(array(array('action',false),array('cat',false)),false));
if ( ((((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))) && ((isset($_GET[0][('delete')]) && Aspis_isset( $_GET [0][('delete')])))) && ((('delete') == deAspis($_GET[0]['action'])) || (('delete') == deAspis($_GET[0]['action2'])))))
 $action = array('bulk-delete',false);
switch ( $action[0] ) {
case ('addcat'):check_admin_referer(array('add-category',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
if ( deAspis(wp_insert_category($_POST)))
 wp_safe_redirect(concat2(add_query_arg(array('message',false),array(1,false),wp_get_referer()),'#addcat'));
else 
{wp_safe_redirect(concat2(add_query_arg(array('message',false),array(4,false),wp_get_referer()),'#addcat'));
}Aspis_exit();
break ;
case ('delete'):if ( (!((isset($_GET[0][('cat_ID')]) && Aspis_isset( $_GET [0][('cat_ID')])))))
 {wp_redirect(array('categories.php',false));
Aspis_exit();
}$cat_ID = int_cast($_GET[0]['cat_ID']);
check_admin_referer(concat1('delete-category_',$cat_ID));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
if ( ($cat_ID[0] == deAspis(get_option(array('default_category',false)))))
 wp_die(Aspis_sprintf(__(array("Can&#8217;t delete the <strong>%s</strong> category: this is the default one",false)),get_cat_name($cat_ID)));
wp_delete_category($cat_ID);
wp_safe_redirect(add_query_arg(array('message',false),array(2,false),wp_get_referer()));
Aspis_exit();
break ;
case ('bulk-delete'):check_admin_referer(array('bulk-categories',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('You are not allowed to delete categories.',false)));
$cats = array_cast($_GET[0]['delete']);
$default_cat = get_option(array('default_category',false));
foreach ( $cats[0] as $cat_ID  )
{$cat_ID = int_cast($cat_ID);
if ( ($cat_ID[0] == $default_cat[0]))
 wp_die(Aspis_sprintf(__(array("Can&#8217;t delete the <strong>%s</strong> category: this is the default one",false)),get_cat_name($cat_ID)));
wp_delete_category($cat_ID);
}wp_safe_redirect(wp_get_referer());
Aspis_exit();
break ;
case ('edit'):$title = __(array('Edit Category',false));
require_once ('admin-header.php');
$cat_ID = int_cast($_GET[0]['cat_ID']);
$category = get_category_to_edit($cat_ID);
include ('edit-category-form.php');
break ;
case ('editedcat'):$cat_ID = int_cast($_POST[0]['cat_ID']);
check_admin_referer(concat1('update-category_',$cat_ID));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$location = array('categories.php',false);
if ( deAspis($referer = wp_get_original_referer()))
 {if ( (false !== strpos($referer[0],'categories.php')))
 $location = $referer;
}if ( deAspis(wp_update_category($_POST)))
 $location = add_query_arg(array('message',false),array(3,false),$location);
else 
{$location = add_query_arg(array('message',false),array(5,false),$location);
}wp_redirect($location);
Aspis_exit();
break ;
default :if ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}wp_enqueue_script(array('admin-categories',false));
if ( deAspis(current_user_can(array('manage_categories',false))))
 wp_enqueue_script(array('inline-edit-tax',false));
require_once ('admin-header.php');
arrayAssign($messages[0],deAspis(registerTaint(array(1,false))),addTaint(__(array('Category added.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(2,false))),addTaint(__(array('Category deleted.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(3,false))),addTaint(__(array('Category updated.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(4,false))),addTaint(__(array('Category not added.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(5,false))),addTaint(__(array('Category not updated.',false))));
;
?>

<div class="wrap nosubsub">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
if ( (((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) && deAspis($_GET[0]['s'])))
 printf((deconcat2(concat1('<span class="subtitle">',__(array('Search results for &#8220;%s&#8221;',false))),'</span>')),deAspisRC(esc_html(Aspis_stripslashes($_GET[0]['s']))));
;
?>
</h2>

<?php if ( (((isset($_GET[0][('message')]) && Aspis_isset( $_GET [0][('message')]))) && deAspis(($msg = int_cast($_GET[0]['message'])))))
 {;
?>
<div id="message" class="updated fade"><p><?php echo AspisCheckPrint(attachAspis($messages,$msg[0]));
;
?></p></div>
<?php arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('message',false)),false),$_SERVER[0]['REQUEST_URI'])));
};
?>

<form class="search-form topmargin" action="" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="category-search-input"><?php _e(array('Search Categories',false));
;
?>:</label>
	<input type="text" id="category-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Categories',false));
;
?>" class="button" />
</p>
</form>
<br class="clear" />

<div id="col-container">

<div id="col-right">
<div class="col-wrap">
<form id="posts-filter" action="" method="get">
<div class="tablenav">

<?php $pagenum = ((isset($_GET[0][('pagenum')]) && Aspis_isset( $_GET [0][('pagenum')]))) ? absint($_GET[0]['pagenum']) : array(0,false);
if ( ((empty($pagenum) || Aspis_empty( $pagenum))))
 $pagenum = array(1,false);
$cats_per_page = int_cast(get_user_option(array('categories_per_page',false),array(0,false),array(false,false)));
if ( (((empty($cats_per_page) || Aspis_empty( $cats_per_page))) || ($cats_per_page[0] < (1))))
 $cats_per_page = array(20,false);
$cats_per_page = apply_filters(array('edit_categories_per_page',false),$cats_per_page);
if ( (!((empty($_GET[0][('s')]) || Aspis_empty( $_GET [0][('s')])))))
 $num_cats = attAspis(count(deAspis(get_categories(array(array('hide_empty' => array(0,false,false),deregisterTaint(array('search',false)) => addTaint($_GET[0]['s'])),false)))));
else 
{$num_cats = wp_count_terms(array('category',false));
}$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('pagenum',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil(($num_cats[0] / $cats_per_page[0])))),deregisterTaint(array('current',false)) => addTaint($pagenum)),false));
if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("<div class='tablenav-pages'>",$page_links),"</div>"));
;
?>

<div class="alignleft actions">
<select name="action">
<option value="" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
<option value="delete"><?php _e(array('Delete',false));
;
?></option>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction" id="doaction" class="button-secondary action" />
<?php wp_nonce_field(array('bulk-categories',false));
;
?>
</div>

<br class="clear" />
</div>

<div class="clear"></div>

<table class="widefat fixed" cellspacing="0">
	<thead>
	<tr>
<?php print_column_headers(array('categories',false));
;
?>
	</tr>
	</thead>

	<tfoot>
	<tr>
<?php print_column_headers(array('categories',false),array(false,false));
;
?>
	</tr>
	</tfoot>

	<tbody id="the-list" class="list:cat">
<?php cat_rows(array(0,false),array(0,false),array(0,false),$pagenum,$cats_per_page);
;
?>
	</tbody>
</table>

<div class="tablenav">
<?php if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("<div class='tablenav-pages'>",$page_links),"</div>"));
;
?>

<div class="alignleft actions">
<select name="action2">
<option value="" selected="selected"><?php _e(array('Bulk Actions',false));
;
?></option>
<option value="delete"><?php _e(array('Delete',false));
;
?></option>
</select>
<input type="submit" value="<?php esc_attr_e(array('Apply',false));
;
?>" name="doaction2" id="doaction2" class="button-secondary action" />
<?php wp_nonce_field(array('bulk-categories',false));
;
?>
</div>

<br class="clear" />
</div>

</form>

<div class="form-wrap">
<p><?php printf(deAspis(__(array('<strong>Note:</strong><br />Deleting a category does not delete the posts in that category. Instead, posts that were only assigned to the deleted category are set to the category <strong>%s</strong>.',false))),deAspisRC(apply_filters(array('the_category',false),get_cat_name(get_option(array('default_category',false))))));
?></p>
<p><?php printf(deAspis(__(array('Categories can be selectively converted to tags using the <a href="%s">category to tag converter</a>.',false))),'admin.php?import=wp-cat2tag');
?></p>
</div>

</div>
</div><!-- /col-right -->

<div id="col-left">
<div class="col-wrap">

<?php if ( deAspis(current_user_can(array('manage_categories',false))))
 {;
?>
<?php $category = object_cast(array(array(),false));
$category[0]->parent = array(0,false);
do_action(array('add_category_form_pre',false),$category);
;
?>

<div class="form-wrap">
<h3><?php _e(array('Add Category',false));
;
?></h3>
<div id="ajax-response"></div>
<form name="addcat" id="addcat" method="post" action="categories.php" class="add:the-list: validate">
<input type="hidden" name="action" value="addcat" />
<?php wp_original_referer_field(array(true,false),array('previous',false));
wp_nonce_field(array('add-category',false));
;
?>

<div class="form-field form-required">
	<label for="cat_name"><?php _e(array('Category Name',false));
?></label>
	<input name="cat_name" id="cat_name" type="text" value="" size="40" aria-required="true" />
    <p><?php _e(array('The name is used to identify the category almost everywhere, for example under the post or in the category widget.',false));
;
?></p>
</div>

<div class="form-field">
	<label for="category_nicename"><?php _e(array('Category Slug',false));
?></label>
	<input name="category_nicename" id="category_nicename" type="text" value="" size="40" />
    <p><?php _e(array('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',false));
;
?></p>
</div>

<div class="form-field">
	<label for="category_parent"><?php _e(array('Category Parent',false));
?></label>
	<?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('category_parent',false,false),'orderby' => array('name',false,false),deregisterTaint(array('selected',false)) => addTaint($category[0]->parent),'hierarchical' => array(true,false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('None',false)))),false));
;
?>
    <p><?php _e(array('Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.',false));
;
?></p>
</div>

<div class="form-field">
	<label for="category_description"><?php _e(array('Description',false));
?></label>
	<textarea name="category_description" id="category_description" rows="5" cols="40"></textarea>
    <p><?php _e(array('The description is not prominent by default; however, some themes may show it.',false));
;
?></p>
</div>

<p class="submit"><input type="submit" class="button" name="submit" value="<?php esc_attr_e(array('Add Category',false));
;
?>" /></p>
<?php do_action(array('edit_category_form',false),$category);
;
?>
</form></div>

<?php };
?>

</div>
</div><!-- /col-left -->

</div><!-- /col-container -->
</div><!-- /wrap -->

<?php inline_edit_term_row(array('categories',false));
break ;
 }
include ('admin-footer.php');
;
?>
<?php 