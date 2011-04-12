<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))) && ((isset($_GET[0][('linkcheck')]) && Aspis_isset( $_GET [0][('linkcheck')])))))
 {check_admin_referer(array('bulk-bookmarks',false));
$doaction = deAspis($_GET[0]['action']) ? $_GET[0]['action'] : $_GET[0]['action2'];
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 wp_die(__(array('You do not have sufficient permissions to edit the links for this blog.',false)));
if ( (('delete') == $doaction[0]))
 {$bulklinks = array_cast($_GET[0]['linkcheck']);
foreach ( $bulklinks[0] as $link_id  )
{$link_id = int_cast($link_id);
wp_delete_link($link_id);
}wp_safe_redirect(wp_get_referer());
Aspis_exit();
}}elseif ( (((isset($_GET[0][('_wp_http_referer')]) && Aspis_isset( $_GET [0][('_wp_http_referer')]))) && (!((empty($_GET[0][('_wp_http_referer')]) || Aspis_empty( $_GET [0][('_wp_http_referer')]))))))
 {wp_redirect(remove_query_arg(array(array(array('_wp_http_referer',false),array('_wpnonce',false)),false),Aspis_stripslashes($_SERVER[0]['REQUEST_URI'])));
Aspis_exit();
}wp_reset_vars(array(array(array('action',false),array('cat_id',false),array('linkurl',false),array('name',false),array('image',false),array('description',false),array('visible',false),array('target',false),array('category',false),array('link_id',false),array('submit',false),array('order_by',false),array('links_show_cat_id',false),array('rating',false),array('rel',false),array('notes',false),array('linkcheck[]',false)),false));
if ( ((empty($cat_id) || Aspis_empty( $cat_id))))
 $cat_id = array('all',false);
if ( ((empty($order_by) || Aspis_empty( $order_by))))
 $order_by = array('order_name',false);
$title = __(array('Edit Links',false));
$this_file = $parent_file = array('link-manager.php',false);
include_once ("./admin-header.php");
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 wp_die(__(array("You do not have sufficient permissions to edit the links for this blog.",false)));
switch ( $order_by[0] ) {
case ('order_id'):$sqlorderby = array('id',false);
break ;
case ('order_url'):$sqlorderby = array('url',false);
break ;
case ('order_desc'):$sqlorderby = array('description',false);
break ;
case ('order_owner'):$sqlorderby = array('owner',false);
break ;
case ('order_rating'):$sqlorderby = array('rating',false);
break ;
case ('order_name'):default :$sqlorderby = array('name',false);
break ;
 }
;
?>

<div class="wrap nosubsub">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?> <a href="link-add.php" class="button add-new-h2"><?php esc_html_e(array('Add New',false));
;
?></a> <?php if ( (((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) && deAspis($_GET[0]['s'])))
 printf((deconcat2(concat1('<span class="subtitle">',__(array('Search results for &#8220;%s&#8221;',false))),'</span>')),deAspisRC(esc_html(Aspis_stripslashes($_GET[0]['s']))));
;
?>
</h2>

<?php if ( ((isset($_GET[0][('deleted')]) && Aspis_isset( $_GET [0][('deleted')]))))
 {echo AspisCheckPrint(array('<div id="message" class="updated fade"><p>',false));
$deleted = int_cast($_GET[0]['deleted']);
printf(deAspis(_n(array('%s link deleted.',false),array('%s links deleted',false),$deleted)),deAspisRC($deleted));
echo AspisCheckPrint(array('</p></div>',false));
arrayAssign($_SERVER[0],deAspis(registerTaint(array('REQUEST_URI',false))),addTaint(remove_query_arg(array(array(array('deleted',false)),false),$_SERVER[0]['REQUEST_URI'])));
};
?>

<form class="search-form" action="" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="link-search-input"><?php _e(array('Search Links',false));
;
?>:</label>
	<input type="text" id="link-search-input" name="s" value="<?php _admin_search_query();
;
?>" />
	<input type="submit" value="<?php esc_attr_e(array('Search Links',false));
;
?>" class="button" />
</p>
</form>
<br class="clear" />

<form id="posts-filter" action="" method="get">
<div class="tablenav">

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

<?php $categories = get_terms(array('link_category',false),array("hide_empty=1",false));
$select_cat = array("<select name=\"cat_id\">\n",false);
$select_cat = concat($select_cat,concat2(concat(concat2(concat1('<option value="all"',(($cat_id[0] == ('all')) ? array(" selected='selected'",false) : array('',false))),'>'),__(array('View all Categories',false))),"</option>\n"));
foreach ( deAspis(array_cast($categories)) as $cat  )
$select_cat = concat($select_cat,concat2(concat(concat2(concat(concat2(concat1('<option value="',esc_attr($cat[0]->term_id)),'"'),(($cat[0]->term_id[0] == $cat_id[0]) ? array(" selected='selected'",false) : array('',false))),'>'),sanitize_term_field(array('name',false),$cat[0]->name,$cat[0]->term_id,array('link_category',false),array('display',false))),"</option>\n"));
$select_cat = concat2($select_cat,"</select>\n");
$select_order = array("<select name=\"order_by\">\n",false);
$select_order = concat($select_order,concat2(concat(concat2(concat1('<option value="order_id"',(($order_by[0] == ('order_id')) ? array(" selected='selected'",false) : array('',false))),'>'),__(array('Order by Link ID',false))),"</option>\n"));
$select_order = concat($select_order,concat2(concat(concat2(concat1('<option value="order_name"',(($order_by[0] == ('order_name')) ? array(" selected='selected'",false) : array('',false))),'>'),__(array('Order by Name',false))),"</option>\n"));
$select_order = concat($select_order,concat2(concat(concat2(concat1('<option value="order_url"',(($order_by[0] == ('order_url')) ? array(" selected='selected'",false) : array('',false))),'>'),__(array('Order by Address',false))),"</option>\n"));
$select_order = concat($select_order,concat2(concat(concat2(concat1('<option value="order_rating"',(($order_by[0] == ('order_rating')) ? array(" selected='selected'",false) : array('',false))),'>'),__(array('Order by Rating',false))),"</option>\n"));
$select_order = concat2($select_order,"</select>\n");
echo AspisCheckPrint($select_cat);
echo AspisCheckPrint($select_order);
;
?>
<input type="submit" id="post-query-submit" value="<?php esc_attr_e(array('Filter',false));
;
?>" class="button-secondary" />

</div>

<br class="clear" />
</div>

<div class="clear"></div>

<?php if ( (('all') == $cat_id[0]))
 $cat_id = array('',false);
$args = array(array(deregisterTaint(array('category',false)) => addTaint($cat_id),'hide_invisible' => array(0,false,false),deregisterTaint(array('orderby',false)) => addTaint($sqlorderby),'hide_empty' => array(0,false,false)),false);
if ( (!((empty($_GET[0][('s')]) || Aspis_empty( $_GET [0][('s')])))))
 arrayAssign($args[0],deAspis(registerTaint(array('search',false))),addTaint($_GET[0]['s']));
$links = get_bookmarks($args);
if ( $links[0])
 {$link_columns = get_column_headers(array('link-manager',false));
$hidden = get_hidden_columns(array('link-manager',false));
;
?>

<?php wp_nonce_field(array('bulk-bookmarks',false));
?>
<table class="widefat fixed" cellspacing="0">
	<thead>
	<tr>
<?php print_column_headers(array('link-manager',false));
;
?>
	</tr>
	</thead>

	<tfoot>
	<tr>
<?php print_column_headers(array('link-manager',false),array(false,false));
;
?>
	</tr>
	</tfoot>

	<tbody>
<?php $alt = array(0,false);
foreach ( $links[0] as $link  )
{$link = sanitize_bookmark($link);
$link[0]->link_name = esc_attr($link[0]->link_name);
$link[0]->link_category = wp_get_link_cats($link[0]->link_id);
$short_url = Aspis_str_replace(array('http://',false),array('',false),$link[0]->link_url);
$short_url = Aspis_preg_replace(array('/^www\./i',false),array('',false),$short_url);
if ( (('/') == deAspis(Aspis_substr($short_url,negate(array(1,false))))))
 $short_url = Aspis_substr($short_url,array(0,false),negate(array(1,false)));
if ( (strlen($short_url[0]) > (35)))
 $short_url = concat2(Aspis_substr($short_url,array(0,false),array(32,false)),'...');
$visible = ($link[0]->link_visible[0] == ('Y')) ? __(array('Yes',false)) : __(array('No',false));
$rating = $link[0]->link_rating;
$style = ($alt[0] % (2)) ? array('',false) : array(' class="alternate"',false);
preincr($alt);
$edit_link = get_edit_bookmark_link();
;
?><tr id="link-<?php echo AspisCheckPrint($link[0]->link_id);
;
?>" valign="middle" <?php echo AspisCheckPrint($style);
;
?>><?php foreach ( $link_columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat1("class=\"column-",$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):echo AspisCheckPrint(concat2(concat1('<th scope="row" class="check-column"><input type="checkbox" name="linkcheck[]" value="',esc_attr($link[0]->link_id)),'" /></th>'));
break ;
case ('name'):echo AspisCheckPrint(concat(concat(concat2(concat(concat2(concat1("<td ",$attributes),"><strong><a class='row-title' href='"),$edit_link),"' title='"),esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$link[0]->link_name))),concat2(concat1("'>",$link[0]->link_name),"</a></strong><br />")));
$actions = array(array(),false);
arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat1('<a href="',$edit_link),'">'),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='submitdelete' href='",wp_nonce_url(concat1("link.php?action=delete&amp;link_id=",$link[0]->link_id),concat1('delete-bookmark_',$link[0]->link_id))),"' onclick=\"if ( confirm('"),esc_js(Aspis_sprintf(__(array("You are about to delete this link '%s'\n  'Cancel' to stop, 'OK' to delete.",false)),$link[0]->link_name))),"') ) { return true;}return false;\">"),__(array('Delete',false))),"</a>")));
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
echo AspisCheckPrint(array('<div class="row-actions">',false));
foreach ( $actions[0] as $action =>$linkaction )
{restoreTaint($action,$linkaction);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
echo AspisCheckPrint(concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$linkaction),$sep),"</span>"));
}}echo AspisCheckPrint(array('</div>',false));
echo AspisCheckPrint(array('</td>',false));
break ;
case ('url'):echo AspisCheckPrint(concat(concat(concat2(concat(concat2(concat1("<td ",$attributes),"><a href='"),$link[0]->link_url),"' title='"),Aspis_sprintf(__(array('Visit %s',false)),$link[0]->link_name)),concat2(concat1("'>",$short_url),"</a></td>")));
break ;
case ('categories'):;
?><td <?php echo AspisCheckPrint($attributes);
?>><?php $cat_names = array(array(),false);
foreach ( $link[0]->link_category[0] as $category  )
{$cat = get_term($category,array('link_category',false),array(OBJECT,false),array('display',false));
if ( deAspis(is_wp_error($cat)))
 echo AspisCheckPrint($cat[0]->get_error_message());
$cat_name = $cat[0]->name;
if ( ($cat_id[0] != $category[0]))
 $cat_name = concat2(concat(concat2(concat1("<a href='link-manager.php?cat_id=",$category),"'>"),$cat_name),"</a>");
arrayAssignAdd($cat_names[0][],addTaint($cat_name));
}echo AspisCheckPrint(Aspis_implode(array(', ',false),$cat_names));
;
?></td><?php break ;
case ('rel'):;
?><td <?php echo AspisCheckPrint($attributes);
?>><?php echo AspisCheckPrint(((empty($link[0]->link_rel) || Aspis_empty( $link[0] ->link_rel ))) ? array('<br />',false) : $link[0]->link_rel);
;
?></td><?php break ;
case ('visible'):;
?><td <?php echo AspisCheckPrint($attributes);
?>><?php echo AspisCheckPrint($visible);
;
?></td><?php break ;
case ('rating'):;
?><td <?php echo AspisCheckPrint($attributes);
?>><?php echo AspisCheckPrint($rating);
;
?></td><?php break ;
default :;
?>
					<td><?php do_action(array('manage_link_custom_column',false),$column_name,$link[0]->link_id);
;
?></td>
					<?php break ;
 }
}}echo AspisCheckPrint(array("\n    </tr>\n",false));
};
?>
	</tbody>
</table>

<?php }else 
{{;
?>
<p><?php _e(array('No links found.',false));
?></p>
<?php }};
?>

<div class="tablenav">

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

</form>

<div id="ajax-response"></div>

</div>

<?php include ('admin-footer.php');
