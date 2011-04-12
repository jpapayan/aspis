<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))) && ((isset($_GET[0][('delete')]) && Aspis_isset( $_GET [0][('delete')])))))
 {check_admin_referer(array('bulk-link-categories',false));
$doaction = deAspis($_GET[0]['action']) ? $_GET[0]['action'] : $_GET[0]['action2'];
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
if ( (('delete') == $doaction[0]))
 {$cats = array_cast($_GET[0]['delete']);
$default_cat_id = get_option(array('default_link_category',false));
foreach ( $cats[0] as $cat_ID  )
{$cat_ID = int_cast($cat_ID);
if ( ($cat_ID[0] == $default_cat_id[0]))
 wp_die(Aspis_sprintf(__(array("Can&#8217;t delete the <strong>%s</strong> category: this is the default one",false)),get_term_field(array('name',false),$cat_ID,array('link_category',false))));
wp_delete_term($cat_ID,array('link_category',false),array(array(deregisterTaint(array('default',false)) => addTaint($default_cat_id)),false));
}$location = array('edit-link-categories.php',false);
if ( deAspis($referer = wp_get_referer()))
 {if ( (false !== strpos($referer[0],'edit-link-categories.php')))
 $location = $referer;
}$location = add_query_arg(array('message',false),array(6,false),$location);
wp_redirect($location);
Aspis_exit();
}}elseif ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}$title = __(array('Link Categories',false));
wp_enqueue_script(array('admin-categories',false));
if ( deAspis(current_user_can(array('manage_categories',false))))
 wp_enqueue_script(array('inline-edit-tax',false));
require_once ('admin-header.php');
arrayAssign($messages[0],deAspis(registerTaint(array(1,false))),addTaint(__(array('Category added.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(2,false))),addTaint(__(array('Category deleted.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(3,false))),addTaint(__(array('Category updated.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(4,false))),addTaint(__(array('Category not added.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(5,false))),addTaint(__(array('Category not updated.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(6,false))),addTaint(__(array('Categories deleted.',false))));
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

<form class="search-form" action="" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="link-category-search-input"><?php _e(array('Search Categories',false));
;
?>:</label>
	<input type="text" id="link-category-search-input" name="s" value="<?php _admin_search_query();
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
if ( ((!((isset($catsperpage) && Aspis_isset( $catsperpage)))) || ($catsperpage[0] < (0))))
 $catsperpage = array(20,false);
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('pagenum',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil((deAspis(wp_count_terms(array('link_category',false))) / $catsperpage[0])))),deregisterTaint(array('current',false)) => addTaint($pagenum)),false));
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
<?php wp_nonce_field(array('bulk-link-categories',false));
;
?>
</div>

<br class="clear" />
</div>

<div class="clear"></div>

<table class="widefat fixed" cellspacing="0">
	<thead>
	<tr>
<?php print_column_headers(array('edit-link-categories',false));
;
?>
	</tr>
	</thead>

	<tfoot>
	<tr>
<?php print_column_headers(array('edit-link-categories',false),array(false,false));
;
?>
	</tr>
	</tfoot>

	<tbody id="the-list" class="list:link-cat">
<?php $start = array(($pagenum[0] - (1)) * $catsperpage[0],false);
$args = array(array(deregisterTaint(array('offset',false)) => addTaint($start),deregisterTaint(array('number',false)) => addTaint($catsperpage),'hide_empty' => array(0,false,false)),false);
if ( (!((empty($_GET[0][('s')]) || Aspis_empty( $_GET [0][('s')])))))
 arrayAssign($args[0],deAspis(registerTaint(array('search',false))),addTaint($_GET[0]['s']));
$categories = get_terms(array('link_category',false),$args);
if ( $categories[0])
 {$output = array('',false);
foreach ( $categories[0] as $category  )
{$output = concat($output,link_cat_row($category));
}echo AspisCheckPrint($output);
unset($category);
};
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
</div>

<br class="clear" />
</div>
<br class="clear" />
</form>

<div class="form-wrap">
<p><?php printf(deAspis(__(array('<strong>Note:</strong><br />Deleting a category does not delete the links in that category. Instead, links that were only assigned to the deleted category are set to the category <strong>%s</strong>.',false))),deAspisRC(get_term_field(array('name',false),get_option(array('default_link_category',false)),array('link_category',false))));
?></p>
</div>


</div>
</div><!-- /col-right -->

<div id="col-left">
<div class="col-wrap">

<?php if ( deAspis(current_user_can(array('manage_categories',false))))
 {$category = object_cast(array(array(),false));
$category[0]->parent = array(0,false);
do_action(array('add_link_category_form_pre',false),$category);
;
?>

<div class="form-wrap">
<h3><?php _e(array('Add Link Category',false));
;
?></h3>
<div id="ajax-response"></div>
<form name="addcat" id="addcat" class="add:the-list: validate" method="post" action="link-category.php">
<input type="hidden" name="action" value="addcat" />
<?php wp_original_referer_field(array(true,false),array('previous',false));
wp_nonce_field(array('add-link-category',false));
;
?>

<div class="form-field form-required">
	<label for="name"><?php _e(array('Link Category name',false));
?></label>
	<input name="name" id="name" type="text" value="" size="40" aria-required="true" />
</div>

<div class="form-field">
	<label for="slug"><?php _e(array('Link Category slug',false));
?></label>
	<input name="slug" id="slug" type="text" value="" size="40" />
	<p><?php _e(array('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',false));
;
?></p>
</div>

<div class="form-field">
	<label for="description"><?php _e(array('Description (optional)',false));
?></label>
	<textarea name="description" id="description" rows="5" cols="40"></textarea>
	<p><?php _e(array('The description is not prominent by default; however, some themes may show it.',false));
;
?></p>
</div>

<p class="submit"><input type="submit" class="button" name="submit" value="<?php esc_attr_e(array('Add Category',false));
;
?>" /></p>
<?php do_action(array('edit_link_category_form',false),$category);
;
?>
</form>
</div>

<?php };
?>

</div>
</div><!-- /col-left -->

</div><!-- /col-container -->
</div><!-- /wrap -->

<?php inline_edit_term_row(array('edit-link-categories',false));
;
?>
<?php include ('admin-footer.php');
;
?>
<?php 