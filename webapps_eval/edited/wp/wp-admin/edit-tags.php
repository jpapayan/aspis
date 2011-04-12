<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$title = __(array('Tags',false));
wp_reset_vars(array(array(array('action',false),array('tag',false),array('taxonomy',false)),false));
if ( ((empty($taxonomy) || Aspis_empty( $taxonomy))))
 $taxonomy = array('post_tag',false);
if ( (denot_boolean(is_taxonomy($taxonomy))))
 wp_die(__(array('Invalid taxonomy',false)));
$parent_file = array('edit.php',false);
$submenu_file = concat1("edit-tags.php?taxonomy=",$taxonomy);
if ( ((((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))) && ((isset($_GET[0][('delete_tags')]) && Aspis_isset( $_GET [0][('delete_tags')])))) && ((('delete') == deAspis($_GET[0]['action'])) || (('delete') == deAspis($_GET[0]['action2'])))))
 $action = array('bulk-delete',false);
switch ( $action[0] ) {
case ('add-tag'):check_admin_referer(array('add-tag',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$ret = wp_insert_term($_POST[0]['tag-name'],$taxonomy,$_POST);
if ( ($ret[0] && (denot_boolean(is_wp_error($ret)))))
 {wp_redirect(array('edit-tags.php?message=1#addtag',false));
}else 
{{wp_redirect(array('edit-tags.php?message=4#addtag',false));
}}Aspis_exit();
break ;
case ('delete'):if ( (!((isset($_GET[0][('tag_ID')]) && Aspis_isset( $_GET [0][('tag_ID')])))))
 {wp_redirect(concat1("edit-tags.php?taxonomy=",$taxonomy));
Aspis_exit();
}$tag_ID = int_cast($_GET[0]['tag_ID']);
check_admin_referer(concat1('delete-tag_',$tag_ID));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
wp_delete_term($tag_ID,$taxonomy);
$location = array('edit-tags.php',false);
if ( deAspis($referer = wp_get_referer()))
 {if ( (false !== strpos($referer[0],'edit-tags.php')))
 $location = $referer;
}$location = add_query_arg(array('message',false),array(2,false),$location);
wp_redirect($location);
Aspis_exit();
break ;
case ('bulk-delete'):check_admin_referer(array('bulk-tags',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$tags = array_cast($_GET[0]['delete_tags']);
foreach ( $tags[0] as $tag_ID  )
{wp_delete_term($tag_ID,$taxonomy);
}$location = array('edit-tags.php',false);
if ( deAspis($referer = wp_get_referer()))
 {if ( (false !== strpos($referer[0],'edit-tags.php')))
 $location = $referer;
}$location = add_query_arg(array('message',false),array(6,false),$location);
wp_redirect($location);
Aspis_exit();
break ;
case ('edit'):$title = __(array('Edit Tag',false));
require_once ('admin-header.php');
$tag_ID = int_cast($_GET[0]['tag_ID']);
$tag = get_term($tag_ID,$taxonomy,array(OBJECT,false),array('edit',false));
include ('edit-tag-form.php');
break ;
case ('editedtag'):$tag_ID = int_cast($_POST[0]['tag_ID']);
check_admin_referer(concat1('update-tag_',$tag_ID));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$ret = wp_update_term($tag_ID,$taxonomy,$_POST);
$location = array('edit-tags.php',false);
if ( deAspis($referer = wp_get_original_referer()))
 {if ( (false !== strpos($referer[0],'edit-tags.php')))
 $location = $referer;
}if ( ($ret[0] && (denot_boolean(is_wp_error($ret)))))
 $location = add_query_arg(array('message',false),array(3,false),$location);
else 
{$location = add_query_arg(array('message',false),array(5,false),$location);
}wp_redirect($location);
Aspis_exit();
break ;
default :if ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}$can_manage = current_user_can(array('manage_categories',false));
wp_enqueue_script(array('admin-tags',false));
if ( $can_manage[0])
 wp_enqueue_script(array('inline-edit-tax',false));
require_once ('admin-header.php');
arrayAssign($messages[0],deAspis(registerTaint(array(1,false))),addTaint(__(array('Tag added.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(2,false))),addTaint(__(array('Tag deleted.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(3,false))),addTaint(__(array('Tag updated.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(4,false))),addTaint(__(array('Tag not added.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(5,false))),addTaint(__(array('Tag not updated.',false))));
arrayAssign($messages[0],deAspis(registerTaint(array(6,false))),addTaint(__(array('Tags deleted.',false))));
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
<div id="ajax-response"></div>

<form class="search-form" action="" method="get">
<input type="hidden" name="taxonomy" value="<?php echo AspisCheckPrint(esc_attr($taxonomy));
;
?>" />
<p class="search-box">
	<label class="screen-reader-text" for="tag-search-input"><?php _e(array('Search Tags',false));
;
?>:</label>
	<input type="text" id="tag-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Tags',false));
;
?>" class="button" />
</p>
</form>
<br class="clear" />

<div id="col-container">

<div id="col-right">
<div class="col-wrap">
<form id="posts-filter" action="" method="get">
<input type="hidden" name="taxonomy" value="<?php echo AspisCheckPrint(esc_attr($taxonomy));
;
?>" />
<div class="tablenav">
<?php $pagenum = ((isset($_GET[0][('pagenum')]) && Aspis_isset( $_GET [0][('pagenum')]))) ? absint($_GET[0]['pagenum']) : array(0,false);
if ( ((empty($pagenum) || Aspis_empty( $pagenum))))
 $pagenum = array(1,false);
$tags_per_page = int_cast(get_user_option(array('edit_tags_per_page',false),array(0,false),array(false,false)));
if ( (((empty($tags_per_page) || Aspis_empty( $tags_per_page))) || ($tags_per_page[0] < (1))))
 $tags_per_page = array(20,false);
$tags_per_page = apply_filters(array('edit_tags_per_page',false),$tags_per_page);
$tags_per_page = apply_filters(array('tagsperpage',false),$tags_per_page);
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('pagenum',false),array('%#%',false))),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil((deAspis(wp_count_terms($taxonomy)) / $tags_per_page[0])))),deregisterTaint(array('current',false)) => addTaint($pagenum)),false));
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
<?php wp_nonce_field(array('bulk-tags',false));
;
?>
</div>

<br class="clear" />
</div>

<div class="clear"></div>

<table class="widefat tag fixed" cellspacing="0">
	<thead>
	<tr>
<?php print_column_headers(array('edit-tags',false));
;
?>
	</tr>
	</thead>

	<tfoot>
	<tr>
<?php print_column_headers(array('edit-tags',false),array(false,false));
;
?>
	</tr>
	</tfoot>

	<tbody id="the-list" class="list:tag">
<?php $searchterms = ((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) ? Aspis_trim($_GET[0]['s']) : array('',false);
$count = tag_rows($pagenum,$tags_per_page,$searchterms,$taxonomy);
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
</div>

<br class="clear" />
</div>

<br class="clear" />
</form>
</div>
</div><!-- /col-right -->

<div id="col-left">
<div class="col-wrap">

<div class="tagcloud">
<h3><?php _e(array('Popular Tags',false));
;
?></h3>
<?php if ( $can_manage[0])
 wp_tag_cloud(array(array(deregisterTaint(array('taxonomy',false)) => addTaint($taxonomy),'link' => array('edit',false,false)),false));
else 
{wp_tag_cloud(array(array(deregisterTaint(array('taxonomy',false)) => addTaint($taxonomy)),false));
};
?>
</div>

<?php if ( $can_manage[0])
 {do_action(array('add_tag_form_pre',false));
;
?>

<div class="form-wrap">
<h3><?php _e(array('Add a New Tag',false));
;
?></h3>
<form id="addtag" method="post" action="edit-tags.php" class="validate">
<input type="hidden" name="action" value="add-tag" />
<input type="hidden" name="taxonomy" value="<?php echo AspisCheckPrint(esc_attr($taxonomy));
;
?>" />
<?php wp_nonce_field(array('add-tag',false));
;
?>

<div class="form-field form-required">
	<label for="tag-name"><?php _e(array('Tag name',false));
?></label>
	<input name="tag-name" id="tag-name" type="text" value="" size="40" aria-required="true" />
	<p><?php _e(array('The name is how the tag appears on your site.',false));
;
?></p>
</div>

<div class="form-field">
	<label for="slug"><?php _e(array('Tag slug',false));
?></label>
	<input name="slug" id="slug" type="text" value="" size="40" />
	<p><?php _e(array('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',false));
;
?></p>
</div>

<div class="form-field">
	<label for="description"><?php _e(array('Description',false));
?></label>
	<textarea name="description" id="description" rows="5" cols="40"></textarea>
    <p><?php _e(array('The description is not prominent by default; however, some themes may show it.',false));
;
?></p>
</div>

<p class="submit"><input type="submit" class="button" name="submit" id="submit" value="<?php esc_attr_e(array('Add Tag',false));
;
?>" /></p>
<?php do_action(array('add_tag_form',false));
;
?>
</form></div>
<?php };
?>

</div>
</div><!-- /col-left -->

</div><!-- /col-container -->
</div><!-- /wrap -->

<?php inline_edit_term_row(array('edit-tags',false));
;
?>

<?php break ;
 }
include ('admin-footer.php');
;
?>
<?php 