<?php require_once('AspisMain.php'); ?><?php
function cat_rows ( $parent = array(0,false),$level = array(0,false),$categories = array(0,false),$page = array(1,false),$per_page = array(20,false) ) {
$count = array(0,false);
if ( ((empty($categories) || Aspis_empty( $categories))))
 {$args = array(array('hide_empty' => array(0,false,false)),false);
if ( (!((empty($_GET[0][('s')]) || Aspis_empty( $_GET [0][('s')])))))
 arrayAssign($args[0],deAspis(registerTaint(array('search',false))),addTaint($_GET[0]['s']));
$categories = get_categories($args);
if ( ((empty($categories) || Aspis_empty( $categories))))
 return array(false,false);
}$children = _get_term_hierarchy(array('category',false));
_cat_rows($parent,$level,$categories,$children,$page,$per_page,$count);
 }
function _cat_rows ( $parent = array(0,false),$level = array(0,false),$categories,&$children,$page = array(1,false),$per_page = array(20,false),&$count ) {
$start = array(($page[0] - (1)) * $per_page[0],false);
$end = array($start[0] + $per_page[0],false);
ob_start();
foreach ( $categories[0] as $key =>$category )
{restoreTaint($key,$category);
{if ( ($count[0] >= $end[0]))
 break ;
if ( (($category[0]->parent[0] != $parent[0]) && ((empty($_GET[0][('s')]) || Aspis_empty( $_GET [0][('s')])))))
 continue ;
if ( (($count[0] == $start[0]) && ($category[0]->parent[0] > (0))))
 {$my_parents = array(array(),false);
$p = $category[0]->parent;
while ( $p[0] )
{$my_parent = get_category($p);
arrayAssignAdd($my_parents[0][],addTaint($my_parent));
if ( ($my_parent[0]->parent[0] == (0)))
 break ;
$p = $my_parent[0]->parent;
}$num_parents = attAspis(count($my_parents[0]));
while ( deAspis($my_parent = Aspis_array_pop($my_parents)) )
{echo AspisCheckPrint(concat1("\t",_cat_row($my_parent,array($level[0] - $num_parents[0],false))));
postdecr($num_parents);
}}if ( ($count[0] >= $start[0]))
 echo AspisCheckPrint(concat1("\t",_cat_row($category,$level)));
unset($categories[0][$key[0]]);
postincr($count);
if ( ((isset($children[0][$category[0]->term_id[0]]) && Aspis_isset( $children [0][$category[0] ->term_id [0]]))))
 _cat_rows($category[0]->term_id,array($level[0] + (1),false),$categories,$children,$page,$per_page,$count);
}}$output = attAspis(ob_get_contents());
ob_end_clean();
echo AspisCheckPrint($output);
 }
function _cat_row ( $category,$level,$name_override = array(false,false) ) {
static $row_class = array('',false);
$category = get_category($category,array(OBJECT,false),array('display',false));
$default_cat_id = int_cast(get_option(array('default_category',false)));
$pad = Aspis_str_repeat(array('&#8212; ',false),attAspisRC(max(0,deAspisRC($level))));
$name = ($name_override[0] ? $name_override : concat(concat2($pad,' '),$category[0]->name));
$edit_link = concat1("categories.php?action=edit&amp;cat_ID=",$category[0]->term_id);
if ( deAspis(current_user_can(array('manage_categories',false))))
 {$edit = concat2(concat(concat2(concat(concat2(concat1("<a class='row-title' href='",$edit_link),"' title='"),esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$category[0]->name))),"'>"),esc_attr($name)),'</a><br />');
$actions = array(array(),false);
arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat1('<a href="',$edit_link),'">'),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('inline hide-if-no-js',false))),addTaint(concat2(concat1('<a href="#" class="editinline">',__(array('Quick&nbsp;Edit',false))),'</a>')));
if ( ($default_cat_id[0] != $category[0]->term_id[0]))
 arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='delete:the-list:cat-",$category[0]->term_id)," submitdelete' href='"),wp_nonce_url(concat1("categories.php?action=delete&amp;cat_ID=",$category[0]->term_id),concat1('delete-category_',$category[0]->term_id))),"'>"),__(array('Delete',false))),"</a>")));
$actions = apply_filters(array('cat_row_actions',false),$actions,$category);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
$edit = concat2($edit,'<div class="row-actions">');
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
$edit = concat($edit,concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}$edit = concat2($edit,'</div>');
}else 
{{$edit = $name;
}}$row_class = (('alternate') == $row_class[0]) ? array('',false) : array('alternate',false);
$qe_data = get_category_to_edit($category[0]->term_id);
$category[0]->count = number_format_i18n($category[0]->count);
$posts_count = ($category[0]->count[0] > (0)) ? concat2(concat(concat2(concat1("<a href='edit.php?cat=",$category[0]->term_id),"'>"),$category[0]->count),"</a>") : $category[0]->count;
$output = concat2(concat(concat2(concat1("<tr id='cat-",$category[0]->term_id),"' class='iedit "),$row_class),"'>");
$columns = get_column_headers(array('categories',false));
$hidden = get_hidden_columns(array('categories',false));
foreach ( $columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):$output = concat2($output,"<th scope='row' class='check-column'>");
if ( ($default_cat_id[0] != $category[0]->term_id[0]))
 {$output = concat($output,concat2(concat1("<input type='checkbox' name='delete[]' value='",$category[0]->term_id),"' />"));
}else 
{{$output = concat2($output,"&nbsp;");
}}$output = concat2($output,'</th>');
break ;
case ('name'):$output = concat($output,concat(concat2(concat1("<td ",$attributes),">"),$edit));
$output = concat($output,concat2(concat1('<div class="hidden" id="inline_',$qe_data[0]->term_id),'">'));
$output = concat($output,concat2(concat1('<div class="name">',$qe_data[0]->name),'</div>'));
$output = concat($output,concat2(concat1('<div class="slug">',apply_filters(array('editable_slug',false),$qe_data[0]->slug)),'</div>'));
$output = concat($output,concat2(concat1('<div class="cat_parent">',$qe_data[0]->parent),'</div></div></td>'));
break ;
case ('description'):$output = concat($output,concat2(concat(concat2(concat1("<td ",$attributes),">"),$category[0]->description),"</td>"));
break ;
case ('slug'):$output = concat($output,concat2(concat(concat2(concat1("<td ",$attributes),">"),apply_filters(array('editable_slug',false),$category[0]->slug)),"</td>"));
break ;
case ('posts'):$attributes = concat1('class="posts column-posts num"',$style);
$output = concat($output,concat2(concat(concat2(concat1("<td ",$attributes),">"),$posts_count),"</td>\n"));
break ;
default :$output = concat($output,concat2(concat1("<td ",$attributes),">"));
$output = concat($output,apply_filters(array('manage_categories_custom_column',false),array('',false),$column_name,$category[0]->term_id));
$output = concat2($output,"</td>");
 }
}}$output = concat2($output,'</tr>');
return $output;
 }
function inline_edit_term_row ( $type ) {
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 return ;
$is_tag = array($type[0] == ('edit-tags'),false);
$columns = get_column_headers($type);
$hidden = Aspis_array_intersect(attAspisRC(array_keys(deAspisRC($columns))),attAspisRC(array_filter(deAspisRC(get_hidden_columns($type)))));
$col_count = array(count($columns[0]) - count($hidden[0]),false);
;
?>

<form method="get" action=""><table style="display: none"><tbody id="inlineedit">
	<tr id="inline-edit" class="inline-edit-row" style="display: none"><td colspan="<?php echo AspisCheckPrint($col_count);
;
?>">

		<fieldset><div class="inline-edit-col">
			<h4><?php _e(array('Quick Edit',false));
;
?></h4>

			<label>
				<span class="title"><?php _e(array('Name',false));
;
?></span>
				<span class="input-text-wrap"><input type="text" name="name" class="ptitle" value="" /></span>
			</label>

			<label>
				<span class="title"><?php _e(array('Slug',false));
;
?></span>
				<span class="input-text-wrap"><input type="text" name="slug" class="ptitle" value="" /></span>
			</label>

<?php if ( (('category') == $type[0]))
 {;
?>

			<label>
				<span class="title"><?php _e(array('Parent',false));
;
?></span>
				<?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('parent',false,false),'orderby' => array('name',false,false),'hierarchical' => array(1,false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('None',false)))),false));
;
?>
			</label>

<?php };
?>

		</div></fieldset>

<?php $core_columns = array(array('cb' => array(true,false,false),'description' => array(true,false,false),'name' => array(true,false,false),'slug' => array(true,false,false),'posts' => array(true,false,false)),false);
foreach ( $columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{if ( ((isset($core_columns[0][$column_name[0]]) && Aspis_isset( $core_columns [0][$column_name[0]]))))
 continue ;
do_action(array('quick_edit_custom_box',false),$column_name,$type);
}};
?>

	<p class="inline-edit-save submit">
		<a accesskey="c" href="#inline-edit" title="<?php _e(array('Cancel',false));
;
?>" class="cancel button-secondary alignleft"><?php _e(array('Cancel',false));
;
?></a>
		<?php $update_text = deAspis(($is_tag)) ? __(array('Update Tag',false)) : __(array('Update Category',false));
;
?>
		<a accesskey="s" href="#inline-edit" title="<?php echo AspisCheckPrint(esc_attr($update_text));
;
?>" class="save button-primary alignright"><?php echo AspisCheckPrint($update_text);
;
?></a>
		<img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" />
		<span class="error" style="display:none;"></span>
		<?php wp_nonce_field(array('taxinlineeditnonce',false),array('_inline_edit',false),array(false,false));
;
?>
		<br class="clear" />
	</p>
	</td></tr>
	</tbody></table></form>
<?php  }
function link_cat_row ( $category,$name_override = array(false,false) ) {
static $row_class = array('',false);
if ( (denot_boolean($category = get_term($category,array('link_category',false),array(OBJECT,false),array('display',false)))))
 return array(false,false);
if ( deAspis(is_wp_error($category)))
 return $category;
$default_cat_id = int_cast(get_option(array('default_link_category',false)));
$name = ($name_override[0] ? $name_override : $category[0]->name);
$edit_link = concat1("link-category.php?action=edit&amp;cat_ID=",$category[0]->term_id);
if ( deAspis(current_user_can(array('manage_categories',false))))
 {$edit = concat(concat(concat2(concat1("<a class='row-title' href='",$edit_link),"' title='"),esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$category[0]->name))),concat2(concat1("'>",$name),"</a><br />"));
$actions = array(array(),false);
arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat1('<a href="',$edit_link),'">'),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('inline hide-if-no-js',false))),addTaint(concat2(concat1('<a href="#" class="editinline">',__(array('Quick&nbsp;Edit',false))),'</a>')));
if ( ($default_cat_id[0] != $category[0]->term_id[0]))
 arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='delete:the-list:link-cat-",$category[0]->term_id)," submitdelete' href='"),wp_nonce_url(concat1("link-category.php?action=delete&amp;cat_ID=",$category[0]->term_id),concat1('delete-link-category_',$category[0]->term_id))),"'>"),__(array('Delete',false))),"</a>")));
$actions = apply_filters(array('link_cat_row_actions',false),$actions,$category);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
$edit = concat2($edit,'<div class="row-actions">');
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
$edit = concat($edit,concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}$edit = concat2($edit,'</div>');
}else 
{{$edit = $name;
}}$row_class = (('alternate') == $row_class[0]) ? array('',false) : array('alternate',false);
$qe_data = get_term_to_edit($category[0]->term_id,array('link_category',false));
$category[0]->count = number_format_i18n($category[0]->count);
$count = ($category[0]->count[0] > (0)) ? concat2(concat(concat2(concat1("<a href='link-manager.php?cat_id=",$category[0]->term_id),"'>"),$category[0]->count),"</a>") : $category[0]->count;
$output = concat2(concat(concat2(concat1("<tr id='link-cat-",$category[0]->term_id),"' class='iedit "),$row_class),"'>");
$columns = get_column_headers(array('edit-link-categories',false));
$hidden = get_hidden_columns(array('edit-link-categories',false));
foreach ( $columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):$output = concat2($output,"<th scope='row' class='check-column'>");
if ( (deAspis(absint(get_option(array('default_link_category',false)))) != $category[0]->term_id[0]))
 {$output = concat($output,concat2(concat1("<input type='checkbox' name='delete[]' value='",$category[0]->term_id),"' />"));
}else 
{{$output = concat2($output,"&nbsp;");
}}$output = concat2($output,"</th>");
break ;
case ('name'):$output = concat($output,concat(concat2(concat1("<td ",$attributes),">"),$edit));
$output = concat($output,concat2(concat1('<div class="hidden" id="inline_',$qe_data[0]->term_id),'">'));
$output = concat($output,concat2(concat1('<div class="name">',$qe_data[0]->name),'</div>'));
$output = concat($output,concat2(concat1('<div class="slug">',apply_filters(array('editable_slug',false),$qe_data[0]->slug)),'</div>'));
$output = concat($output,concat2(concat1('<div class="cat_parent">',$qe_data[0]->parent),'</div></div></td>'));
break ;
case ('description'):$output = concat($output,concat2(concat(concat2(concat1("<td ",$attributes),">"),$category[0]->description),"</td>"));
break ;
case ('slug'):$output = concat($output,concat2(concat(concat2(concat1("<td ",$attributes),">"),apply_filters(array('editable_slug',false),$category[0]->slug)),"</td>"));
break ;
case ('links'):$attributes = concat1('class="links column-links num"',$style);
$output = concat($output,concat2(concat(concat2(concat1("<td ",$attributes),">"),$count),"</td>"));
break ;
default :$output = concat($output,concat2(concat1("<td ",$attributes),">"));
$output = concat($output,apply_filters(array('manage_link_categories_custom_column',false),array('',false),$column_name,$category[0]->term_id));
$output = concat2($output,"</td>");
 }
}}$output = concat2($output,'</tr>');
return $output;
 }
function checked ( $checked,$current = array(true,false),$echo = array(true,false) ) {
return __checked_selected_helper($checked,$current,$echo,array('checked',false));
 }
function selected ( $selected,$current = array(true,false),$echo = array(true,false) ) {
return __checked_selected_helper($selected,$current,$echo,array('selected',false));
 }
function __checked_selected_helper ( $helper,$current,$echo,$type ) {
if ( (deAspis(string_cast($helper)) === deAspis(string_cast($current))))
 $result = concat2(concat(concat2(concat1(" ",$type),"='"),$type),"'");
else 
{$result = array('',false);
}if ( $echo[0])
 echo AspisCheckPrint($result);
return $result;
 }
function dropdown_categories ( $default = array(0,false),$parent = array(0,false),$popular_ids = array(array(),false) ) {
global $post_ID;
wp_category_checklist($post_ID);
 }
class Walker_Category_Checklist extends Walker{var $tree_type = array('category',false);
var $db_fields = array(array('parent' => array('parent',false),'id' => array('term_id',false)),false);
function start_lvl ( &$output,$depth,$args ) {
{$indent = Aspis_str_repeat(array("\t",false),$depth);
$output = concat($output,concat2($indent,"<ul class='children'>\n"));
} }
function end_lvl ( &$output,$depth,$args ) {
{$indent = Aspis_str_repeat(array("\t",false),$depth);
$output = concat($output,concat2($indent,"</ul>\n"));
} }
function start_el ( &$output,$category,$depth,$args ) {
{extract(($args[0]));
$class = deAspis(Aspis_in_array($category[0]->term_id,$popular_cats)) ? array(' class="popular-category"',false) : array('',false);
$output = concat($output,concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat2(concat(concat2(concat1("\n<li id='category-",$category[0]->term_id),"'"),$class),">"),'<label class="selectit"><input value="'),$category[0]->term_id),'" type="checkbox" name="post_category[]" id="in-category-'),$category[0]->term_id),'"'),(deAspis(Aspis_in_array($category[0]->term_id,$selected_cats)) ? array(' checked="checked"',false) : array("",false))),'/> '),esc_html(apply_filters(array('the_category',false),$category[0]->name))),'</label>'));
} }
function end_el ( &$output,$category,$depth,$args ) {
{$output = concat2($output,"</li>\n");
} }
}function wp_category_checklist ( $post_id = array(0,false),$descendants_and_self = array(0,false),$selected_cats = array(false,false),$popular_cats = array(false,false),$walker = array(null,false),$checked_ontop = array(true,false) ) {
if ( (((empty($walker) || Aspis_empty( $walker))) || (!(is_a(deAspisRC($walker),('Walker'))))))
 $walker = array(new Walker_Category_Checklist,false);
$descendants_and_self = int_cast($descendants_and_self);
$args = array(array(),false);
if ( is_array($selected_cats[0]))
 arrayAssign($args[0],deAspis(registerTaint(array('selected_cats',false))),addTaint($selected_cats));
elseif ( $post_id[0])
 arrayAssign($args[0],deAspis(registerTaint(array('selected_cats',false))),addTaint(wp_get_post_categories($post_id)));
else 
{arrayAssign($args[0],deAspis(registerTaint(array('selected_cats',false))),addTaint(array(array(),false)));
}if ( is_array($popular_cats[0]))
 arrayAssign($args[0],deAspis(registerTaint(array('popular_cats',false))),addTaint($popular_cats));
else 
{arrayAssign($args[0],deAspis(registerTaint(array('popular_cats',false))),addTaint(get_terms(array('category',false),array(array('fields' => array('ids',false,false),'orderby' => array('count',false,false),'order' => array('DESC',false,false),'number' => array(10,false,false),'hierarchical' => array(false,false,false)),false))));
}if ( $descendants_and_self[0])
 {$categories = get_categories(concat2(concat1("child_of=",$descendants_and_self),"&hierarchical=0&hide_empty=0"));
$self = get_category($descendants_and_self);
Aspis_array_unshift($categories,$self);
}else 
{{$categories = get_categories(array('get=all',false));
}}if ( $checked_ontop[0])
 {$checked_categories = array(array(),false);
$keys = attAspisRC(array_keys(deAspisRC($categories)));
foreach ( $keys[0] as $k  )
{if ( deAspis(Aspis_in_array($categories[0][$k[0]][0]->term_id,$args[0]['selected_cats'])))
 {arrayAssignAdd($checked_categories[0][],addTaint(attachAspis($categories,$k[0])));
unset($categories[0][$k[0]]);
}}echo AspisCheckPrint(Aspis_call_user_func_array(array(array(&$walker,array('walk',false)),false),array(array($checked_categories,array(0,false),$args),false)));
}echo AspisCheckPrint(Aspis_call_user_func_array(array(array(&$walker,array('walk',false)),false),array(array($categories,array(0,false),$args),false)));
 }
function wp_popular_terms_checklist ( $taxonomy,$default = array(0,false),$number = array(10,false),$echo = array(true,false) ) {
global $post_ID;
if ( $post_ID[0])
 $checked_categories = wp_get_post_categories($post_ID);
else 
{$checked_categories = array(array(),false);
}$categories = get_terms($taxonomy,array(array('orderby' => array('count',false,false),'order' => array('DESC',false,false),deregisterTaint(array('number',false)) => addTaint($number),'hierarchical' => array(false,false,false)),false));
$popular_ids = array(array(),false);
foreach ( deAspis(array_cast($categories)) as $category  )
{arrayAssignAdd($popular_ids[0][],addTaint($category[0]->term_id));
if ( (denot_boolean($echo)))
 continue ;
$id = concat1("popular-category-",$category[0]->term_id);
$checked = deAspis(Aspis_in_array($category[0]->term_id,$checked_categories)) ? array('checked="checked"',false) : array('',false);
;
?>

		<li id="<?php echo AspisCheckPrint($id);
;
?>" class="popular-category">
			<label class="selectit">
			<input id="in-<?php echo AspisCheckPrint($id);
;
?>" type="checkbox" <?php echo AspisCheckPrint($checked);
;
?> value="<?php echo AspisCheckPrint(int_cast($category[0]->term_id));
;
?>" />
				<?php echo AspisCheckPrint(esc_html(apply_filters(array('the_category',false),$category[0]->name)));
;
?>
			</label>
		</li>

		<?php }return $popular_ids;
 }
function dropdown_link_categories ( $default = array(0,false) ) {
global $link_id;
wp_link_category_checklist($link_id);
 }
function wp_link_category_checklist ( $link_id = array(0,false) ) {
$default = array(1,false);
if ( $link_id[0])
 {$checked_categories = wp_get_link_cats($link_id);
if ( (count($checked_categories[0]) == (0)))
 {arrayAssignAdd($checked_categories[0][],addTaint($default));
}}else 
{{arrayAssignAdd($checked_categories[0][],addTaint($default));
}}$categories = get_terms(array('link_category',false),array('orderby=count&hide_empty=0',false));
if ( ((empty($categories) || Aspis_empty( $categories))))
 return ;
foreach ( $categories[0] as $category  )
{$cat_id = $category[0]->term_id;
$name = esc_html(apply_filters(array('the_category',false),$category[0]->name));
$checked = Aspis_in_array($cat_id,$checked_categories);
echo AspisCheckPrint(array('<li id="link-category-',false)),AspisCheckPrint($cat_id),AspisCheckPrint(array('"><label for="in-link-category-',false)),AspisCheckPrint($cat_id),AspisCheckPrint(array('" class="selectit"><input value="',false)),AspisCheckPrint($cat_id),AspisCheckPrint(array('" type="checkbox" name="link_category[]" id="in-link-category-',false)),AspisCheckPrint($cat_id),AspisCheckPrint(array('"',false)),AspisCheckPrint(($checked[0] ? array(' checked="checked"',false) : array("",false))),AspisCheckPrint(array('/> ',false)),AspisCheckPrint($name),AspisCheckPrint(array("</label></li>",false));
} }
function _tag_row ( $tag,$class = array('',false),$taxonomy = array('post_tag',false) ) {
$count = number_format_i18n($tag[0]->count);
$tagsel = (($taxonomy[0] == ('post_tag')) ? array('tag',false) : $taxonomy);
$count = ($count[0] > (0)) ? concat2(concat(concat2(concat(concat2(concat1("<a href='edit.php?",$tagsel),"="),$tag[0]->slug),"'>"),$count),"</a>") : $count;
$name = apply_filters(array('term_name',false),$tag[0]->name);
$qe_data = get_term($tag[0]->term_id,$taxonomy,array(object,false),array('edit',false));
$edit_link = concat(concat2(concat1("edit-tags.php?action=edit&amp;taxonomy=",$taxonomy),"&amp;tag_ID="),$tag[0]->term_id);
$out = array('',false);
$out = concat($out,concat2(concat(concat2(concat1('<tr id="tag-',$tag[0]->term_id),'"'),$class),'>'));
$columns = get_column_headers(array('edit-tags',false));
$hidden = get_hidden_columns(array('edit-tags',false));
foreach ( $columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):$out = concat($out,concat2(concat1('<th scope="row" class="check-column"> <input type="checkbox" name="delete_tags[]" value="',$tag[0]->term_id),'" /></th>'));
break ;
case ('name'):$out = concat($out,concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<td ',$attributes),'><strong><a class="row-title" href="'),$edit_link),'" title="'),esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$name))),'">'),$name),'</a></strong><br />'));
$actions = array(array(),false);
arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat1('<a href="',$edit_link),'">'),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('inline hide-if-no-js',false))),addTaint(concat2(concat1('<a href="#" class="editinline">',__(array('Quick&nbsp;Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat1("<a class='delete-tag' href='",wp_nonce_url(concat(concat2(concat1("edit-tags.php?action=delete&amp;taxonomy=",$taxonomy),"&amp;tag_ID="),$tag[0]->term_id),concat1('delete-tag_',$tag[0]->term_id))),"'>"),__(array('Delete',false))),"</a>")));
$actions = apply_filters(array('tag_row_actions',false),$actions,$tag);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
$out = concat2($out,'<div class="row-actions">');
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
$out = concat($out,concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}$out = concat2($out,'</div>');
$out = concat($out,concat2(concat1('<div class="hidden" id="inline_',$qe_data[0]->term_id),'">'));
$out = concat($out,concat2(concat1('<div class="name">',$qe_data[0]->name),'</div>'));
$out = concat($out,concat2(concat1('<div class="slug">',apply_filters(array('editable_slug',false),$qe_data[0]->slug)),'</div></div></td>'));
break ;
case ('description'):$out = concat($out,concat2(concat(concat2(concat1("<td ",$attributes),">"),$tag[0]->description),"</td>"));
break ;
case ('slug'):$out = concat($out,concat2(concat(concat2(concat1("<td ",$attributes),">"),apply_filters(array('editable_slug',false),$tag[0]->slug)),"</td>"));
break ;
case ('posts'):$attributes = concat1('class="posts column-posts num"',$style);
$out = concat($out,concat2(concat(concat2(concat1("<td ",$attributes),">"),$count),"</td>"));
break ;
default :$out = concat($out,concat2(concat1("<td ",$attributes),">"));
$out = concat($out,apply_filters(concat2(concat1("manage_",$taxonomy),"_custom_column"),array('',false),$column_name,$tag[0]->term_id));
$out = concat2($out,"</td>");
 }
}}$out = concat2($out,'</tr>');
return $out;
 }
function tag_rows ( $page = array(1,false),$pagesize = array(20,false),$searchterms = array('',false),$taxonomy = array('post_tag',false) ) {
$start = array(($page[0] - (1)) * $pagesize[0],false);
$args = array(array(deregisterTaint(array('offset',false)) => addTaint($start),deregisterTaint(array('number',false)) => addTaint($pagesize),'hide_empty' => array(0,false,false)),false);
if ( (!((empty($searchterms) || Aspis_empty( $searchterms)))))
 {arrayAssign($args[0],deAspis(registerTaint(array('search',false))),addTaint($searchterms));
}$tags = get_terms($taxonomy,$args);
$out = array('',false);
$count = array(0,false);
foreach ( $tags[0] as $tag  )
$out = concat($out,_tag_row($tag,(deAspis(preincr($count)) % (2)) ? array(' class="alternate"',false) : array('',false),$taxonomy));
echo AspisCheckPrint($out);
return $count;
 }
function wp_manage_posts_columns (  ) {
$posts_columns = array(array(),false);
arrayAssign($posts_columns[0],deAspis(registerTaint(array('cb',false))),addTaint(array('<input type="checkbox" />',false)));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('title',false))),addTaint(_x(array('Post',false),array('column name',false))));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('author',false))),addTaint(__(array('Author',false))));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('categories',false))),addTaint(__(array('Categories',false))));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('tags',false))),addTaint(__(array('Tags',false))));
$post_status = (!((empty($_REQUEST[0][('post_status')]) || Aspis_empty( $_REQUEST [0][('post_status')])))) ? $_REQUEST[0]['post_status'] : array('all',false);
if ( (denot_boolean(Aspis_in_array($post_status,array(array(array('pending',false),array('draft',false),array('future',false)),false)))))
 arrayAssign($posts_columns[0],deAspis(registerTaint(array('comments',false))),addTaint(array('<div class="vers"><img alt="Comments" src="images/comment-grey-bubble.png" /></div>',false)));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('date',false))),addTaint(__(array('Date',false))));
$posts_columns = apply_filters(array('manage_posts_columns',false),$posts_columns);
return $posts_columns;
 }
function wp_manage_media_columns (  ) {
$posts_columns = array(array(),false);
arrayAssign($posts_columns[0],deAspis(registerTaint(array('cb',false))),addTaint(array('<input type="checkbox" />',false)));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('icon',false))),addTaint(array('',false)));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('media',false))),addTaint(_x(array('File',false),array('column name',false))));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('author',false))),addTaint(__(array('Author',false))));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('parent',false))),addTaint(_x(array('Attached to',false),array('column name',false))));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('comments',false))),addTaint(array('<div class="vers"><img alt="Comments" src="images/comment-grey-bubble.png" /></div>',false)));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('date',false))),addTaint(_x(array('Date',false),array('column name',false))));
$posts_columns = apply_filters(array('manage_media_columns',false),$posts_columns);
return $posts_columns;
 }
function wp_manage_pages_columns (  ) {
$posts_columns = array(array(),false);
arrayAssign($posts_columns[0],deAspis(registerTaint(array('cb',false))),addTaint(array('<input type="checkbox" />',false)));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('title',false))),addTaint(__(array('Title',false))));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('author',false))),addTaint(__(array('Author',false))));
$post_status = (!((empty($_REQUEST[0][('post_status')]) || Aspis_empty( $_REQUEST [0][('post_status')])))) ? $_REQUEST[0]['post_status'] : array('all',false);
if ( (denot_boolean(Aspis_in_array($post_status,array(array(array('pending',false),array('draft',false),array('future',false)),false)))))
 arrayAssign($posts_columns[0],deAspis(registerTaint(array('comments',false))),addTaint(array('<div class="vers"><img alt="" src="images/comment-grey-bubble.png" /></div>',false)));
arrayAssign($posts_columns[0],deAspis(registerTaint(array('date',false))),addTaint(__(array('Date',false))));
$posts_columns = apply_filters(array('manage_pages_columns',false),$posts_columns);
return $posts_columns;
 }
function get_column_headers ( $page ) {
global $_wp_column_headers;
if ( (!((isset($_wp_column_headers) && Aspis_isset( $_wp_column_headers)))))
 $_wp_column_headers = array(array(),false);
if ( ((isset($_wp_column_headers[0][$page[0]]) && Aspis_isset( $_wp_column_headers [0][$page[0]]))))
 return attachAspis($_wp_column_headers,$page[0]);
switch ( $page[0] ) {
case ('edit'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(wp_manage_posts_columns()));
break ;
case ('edit-pages'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(wp_manage_pages_columns()));
break ;
case ('edit-comments'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(array(array('cb' => array('<input type="checkbox" />',false,false),deregisterTaint(array('author',false)) => addTaint(__(array('Author',false))),deregisterTaint(array('comment',false)) => addTaint(_x(array('Comment',false),array('column name',false))),deregisterTaint(array('response',false)) => addTaint(__(array('In Response To',false)))),false)));
break ;
case ('link-manager'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(array(array('cb' => array('<input type="checkbox" />',false,false),deregisterTaint(array('name',false)) => addTaint(__(array('Name',false))),deregisterTaint(array('url',false)) => addTaint(__(array('URL',false))),deregisterTaint(array('categories',false)) => addTaint(__(array('Categories',false))),deregisterTaint(array('rel',false)) => addTaint(__(array('Relationship',false))),deregisterTaint(array('visible',false)) => addTaint(__(array('Visible',false))),deregisterTaint(array('rating',false)) => addTaint(__(array('Rating',false)))),false)));
break ;
case ('upload'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(wp_manage_media_columns()));
break ;
case ('categories'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(array(array('cb' => array('<input type="checkbox" />',false,false),deregisterTaint(array('name',false)) => addTaint(__(array('Name',false))),deregisterTaint(array('description',false)) => addTaint(__(array('Description',false))),deregisterTaint(array('slug',false)) => addTaint(__(array('Slug',false))),deregisterTaint(array('posts',false)) => addTaint(__(array('Posts',false)))),false)));
break ;
case ('edit-link-categories'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(array(array('cb' => array('<input type="checkbox" />',false,false),deregisterTaint(array('name',false)) => addTaint(__(array('Name',false))),deregisterTaint(array('description',false)) => addTaint(__(array('Description',false))),deregisterTaint(array('slug',false)) => addTaint(__(array('Slug',false))),deregisterTaint(array('links',false)) => addTaint(__(array('Links',false)))),false)));
break ;
case ('edit-tags'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(array(array('cb' => array('<input type="checkbox" />',false,false),deregisterTaint(array('name',false)) => addTaint(__(array('Name',false))),deregisterTaint(array('description',false)) => addTaint(__(array('Description',false))),deregisterTaint(array('slug',false)) => addTaint(__(array('Slug',false))),deregisterTaint(array('posts',false)) => addTaint(__(array('Posts',false)))),false)));
break ;
case ('users'):arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(array(array('cb' => array('<input type="checkbox" />',false,false),deregisterTaint(array('username',false)) => addTaint(__(array('Username',false))),deregisterTaint(array('name',false)) => addTaint(__(array('Name',false))),deregisterTaint(array('email',false)) => addTaint(__(array('E-mail',false))),deregisterTaint(array('role',false)) => addTaint(__(array('Role',false))),deregisterTaint(array('posts',false)) => addTaint(__(array('Posts',false)))),false)));
break ;
default :arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(array(array(),false)));
 }
arrayAssign($_wp_column_headers[0],deAspis(registerTaint($page)),addTaint(apply_filters(concat2(concat1('manage_',$page),'_columns'),attachAspis($_wp_column_headers,$page[0]))));
return attachAspis($_wp_column_headers,$page[0]);
 }
function print_column_headers ( $type,$id = array(true,false) ) {
$type = Aspis_str_replace(array('.php',false),array('',false),$type);
$columns = get_column_headers($type);
$hidden = get_hidden_columns($type);
$styles = array(array(),false);
foreach ( $columns[0] as $column_key =>$column_display_name )
{restoreTaint($column_key,$column_display_name);
{$class = array(' class="manage-column',false);
$class = concat($class,concat1(" column-",$column_key));
if ( (('cb') == $column_key[0]))
 $class = concat2($class,' check-column');
elseif ( deAspis(Aspis_in_array($column_key,array(array(array('posts',false),array('comments',false),array('links',false)),false))))
 $class = concat2($class,' num');
$class = concat2($class,'"');
$style = array('',false);
if ( deAspis(Aspis_in_array($column_key,$hidden)))
 $style = array('display:none;',false);
if ( (((isset($styles[0][$type[0]]) && Aspis_isset( $styles [0][$type[0]]))) && ((isset($styles[0][$type[0]][0][$column_key[0]]) && Aspis_isset( $styles [0][$type[0]] [0][$column_key[0]])))))
 $style = concat($style,concat1(' ',attachAspis($styles[0][$type[0]],$column_key[0])));
$style = concat2(concat1(' style="',$style),'"');
;
?>
	<th scope="col" <?php echo AspisCheckPrint($id[0] ? concat2(concat1("id=\"",$column_key),"\"") : array("",false));
echo AspisCheckPrint($class);
echo AspisCheckPrint($style);
;
?>><?php echo AspisCheckPrint($column_display_name);
;
?></th>
<?php }} }
function register_column_headers ( $screen,$columns ) {
global $_wp_column_headers;
if ( (!((isset($_wp_column_headers) && Aspis_isset( $_wp_column_headers)))))
 $_wp_column_headers = array(array(),false);
arrayAssign($_wp_column_headers[0],deAspis(registerTaint($screen)),addTaint($columns));
 }
function get_hidden_columns ( $page ) {
$page = Aspis_str_replace(array('.php',false),array('',false),$page);
return array_cast(get_user_option(concat2(concat1('manage-',$page),'-columns-hidden'),array(0,false),array(false,false)));
 }
function inline_edit_row ( $type ) {
global $current_user,$mode;
$is_page = array(('page') == $type[0],false);
if ( $is_page[0])
 {$screen = array('edit-pages',false);
$post = get_default_page_to_edit();
}else 
{{$screen = array('edit',false);
$post = get_default_post_to_edit();
}}$columns = $is_page[0] ? wp_manage_pages_columns() : wp_manage_posts_columns();
$hidden = Aspis_array_intersect(attAspisRC(array_keys(deAspisRC($columns))),attAspisRC(array_filter(deAspisRC(get_hidden_columns($screen)))));
$col_count = array(count($columns[0]) - count($hidden[0]),false);
$m = (((isset($mode) && Aspis_isset( $mode))) && (('excerpt') == $mode[0])) ? array('excerpt',false) : array('list',false);
$can_publish = current_user_can(concat2(concat1("publish_",$type),"s"));
$core_columns = array(array('cb' => array(true,false,false),'date' => array(true,false,false),'title' => array(true,false,false),'categories' => array(true,false,false),'tags' => array(true,false,false),'comments' => array(true,false,false),'author' => array(true,false,false)),false);
;
?>

<form method="get" action=""><table style="display: none"><tbody id="inlineedit">
	<?php $bulk = array(0,false);
while ( ($bulk[0] < (2)) )
{;
?>

	<tr id="<?php echo AspisCheckPrint($bulk[0] ? array('bulk-edit',false) : array('inline-edit',false));
;
?>" class="inline-edit-row inline-edit-row-<?php echo AspisCheckPrint(concat2($type," "));
echo AspisCheckPrint($bulk[0] ? concat1("bulk-edit-row bulk-edit-row-",$type) : concat1("quick-edit-row quick-edit-row-",$type));
;
?>" style="display: none"><td colspan="<?php echo AspisCheckPrint($col_count);
;
?>">

	<fieldset class="inline-edit-col-left"><div class="inline-edit-col">
		<h4><?php echo AspisCheckPrint($bulk[0] ? ($is_page[0] ? __(array('Bulk Edit Pages',false)) : __(array('Bulk Edit Posts',false))) : __(array('Quick Edit',false)));
;
?></h4>


<?php if ( $bulk[0])
 {;
?>
		<div id="bulk-title-div">
			<div id="bulk-titles"></div>
		</div>

<?php }else 
{;
?>

		<label>
			<span class="title"><?php _e(array('Title',false));
;
?></span>
			<span class="input-text-wrap"><input type="text" name="post_title" class="ptitle" value="" /></span>
		</label>

<?php };
?>


<?php if ( (denot_boolean($bulk)))
 {;
?>

		<label>
			<span class="title"><?php _e(array('Slug',false));
;
?></span>
			<span class="input-text-wrap"><input type="text" name="post_name" value="" /></span>
		</label>

		<label><span class="title"><?php _e(array('Date',false));
;
?></span></label>
		<div class="inline-edit-date">
			<?php touch_time(array(1,false),array(1,false),array(4,false),array(1,false));
;
?>
		</div>
		<br class="clear" />

<?php }$authors = get_editable_user_ids($current_user[0]->id,array(true,false),$type);
$authors_dropdown = array('',false);
if ( ($authors[0] && (count($authors[0]) > (1))))
 {$users_opt = array(array(deregisterTaint(array('include',false)) => addTaint($authors),'name' => array('post_author',false,false),'class' => array('authors',false,false),'multi' => array(1,false,false),'echo' => array(0,false,false)),false);
if ( $bulk[0])
 arrayAssign($users_opt[0],deAspis(registerTaint(array('show_option_none',false))),addTaint(__(array('- No Change -',false))));
$authors_dropdown = array('<label>',false);
$authors_dropdown = concat($authors_dropdown,concat2(concat1('<span class="title">',__(array('Author',false))),'</span>'));
$authors_dropdown = concat($authors_dropdown,wp_dropdown_users($users_opt));
$authors_dropdown = concat2($authors_dropdown,'</label>');
};
?>

<?php if ( (denot_boolean($bulk)))
 {echo AspisCheckPrint($authors_dropdown);
;
?>

		<div class="inline-edit-group">
			<label class="alignleft">
				<span class="title"><?php _e(array('Password',false));
;
?></span>
				<span class="input-text-wrap"><input type="text" name="post_password" class="inline-edit-password-input" value="" /></span>
			</label>

			<em style="margin:5px 10px 0 0" class="alignleft">
				<?php echo AspisCheckPrint(__(array('&ndash;OR&ndash;',false)));
;
?>
			</em>
			<label class="alignleft inline-edit-private">
				<input type="checkbox" name="keep_private" value="private" />
				<span class="checkbox-title"><?php echo AspisCheckPrint($is_page[0] ? __(array('Private page',false)) : __(array('Private post',false)));
;
?></span>
			</label>
		</div>

<?php };
?>

	</div></fieldset>

<?php if ( ((denot_boolean($is_page)) && (denot_boolean($bulk))))
 {;
?>

	<fieldset class="inline-edit-col-center inline-edit-categories"><div class="inline-edit-col">
		<span class="title inline-edit-categories-label"><?php _e(array('Categories',false));
;
?>
			<span class="catshow"><?php _e(array('[more]',false));
;
?></span>
			<span class="cathide" style="display:none;"><?php _e(array('[less]',false));
;
?></span>
		</span>
		<ul class="cat-checklist">
			<?php wp_category_checklist();
;
?>
		</ul>
	</div></fieldset>

<?php };
?>

	<fieldset class="inline-edit-col-right"><div class="inline-edit-col">

<?php if ( $bulk[0])
 echo AspisCheckPrint($authors_dropdown);
;
?>

<?php if ( $is_page[0])
 {;
?>

		<label>
			<span class="title"><?php _e(array('Parent',false));
;
?></span>
<?php $dropdown_args = array(array(deregisterTaint(array('selected',false)) => addTaint($post[0]->post_parent),'name' => array('post_parent',false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('Main Page (no parent)',false))),'option_none_value' => array(0,false,false),'sort_column' => array('menu_order, post_title',false,false)),false);
if ( $bulk[0])
 arrayAssign($dropdown_args[0],deAspis(registerTaint(array('show_option_no_change',false))),addTaint(__(array('- No Change -',false))));
$dropdown_args = apply_filters(array('quick_edit_dropdown_pages_args',false),$dropdown_args);
wp_dropdown_pages($dropdown_args);
;
?>
		</label>

<?php if ( (denot_boolean($bulk)))
 {;
?>

		<label>
			<span class="title"><?php _e(array('Order',false));
;
?></span>
			<span class="input-text-wrap"><input type="text" name="menu_order" class="inline-edit-menu-order-input" value="<?php echo AspisCheckPrint($post[0]->menu_order);
?>" /></span>
		</label>

<?php };
?>

		<label>
			<span class="title"><?php _e(array('Template',false));
;
?></span>
			<select name="page_template">
<?php if ( $bulk[0])
 {;
?>
				<option value="-1"><?php _e(array('- No Change -',false));
;
?></option>
<?php };
?>
				<option value="default"><?php _e(array('Default Template',false));
;
?></option>
				<?php page_template_dropdown();
?>
			</select>
		</label>

<?php }elseif ( (denot_boolean($bulk)))
 {;
?>

		<label class="inline-edit-tags">
			<span class="title"><?php _e(array('Tags',false));
;
?></span>
			<textarea cols="22" rows="1" name="tags_input" class="tags_input"></textarea>
		</label>

<?php };
?>

<?php if ( $bulk[0])
 {;
?>

		<div class="inline-edit-group">
		<label class="alignleft">
			<span class="title"><?php _e(array('Comments',false));
;
?></span>
			<select name="comment_status">
				<option value=""><?php _e(array('- No Change -',false));
;
?></option>
				<option value="open"><?php _e(array('Allow',false));
;
?></option>
				<option value="closed"><?php _e(array('Do not allow',false));
;
?></option>
			</select>
		</label>

		<label class="alignright">
			<span class="title"><?php _e(array('Pings',false));
;
?></span>
			<select name="ping_status">
				<option value=""><?php _e(array('- No Change -',false));
;
?></option>
				<option value="open"><?php _e(array('Allow',false));
;
?></option>
				<option value="closed"><?php _e(array('Do not allow',false));
;
?></option>
			</select>
		</label>
		</div>

<?php }else 
{;
?>

		<div class="inline-edit-group">
			<label class="alignleft">
				<input type="checkbox" name="comment_status" value="open" />
				<span class="checkbox-title"><?php _e(array('Allow Comments',false));
;
?></span>
			</label>

			<label class="alignleft">
				<input type="checkbox" name="ping_status" value="open" />
				<span class="checkbox-title"><?php _e(array('Allow Pings',false));
;
?></span>
			</label>
		</div>

<?php };
?>


		<div class="inline-edit-group">
			<label class="inline-edit-status alignleft">
				<span class="title"><?php _e(array('Status',false));
;
?></span>
				<select name="_status">
<?php if ( $bulk[0])
 {;
?>
					<option value="-1"><?php _e(array('- No Change -',false));
;
?></option>
<?php };
?>
				<?php if ( $can_publish[0])
 {;
?>
					<option value="publish"><?php _e(array('Published',false));
;
?></option>
					<option value="future"><?php _e(array('Scheduled',false));
;
?></option>
<?php if ( $bulk[0])
 {;
?>
					<option value="private"><?php _e(array('Private',false));
?></option>
<?php };
?>
				<?php };
?>
					<option value="pending"><?php _e(array('Pending Review',false));
;
?></option>
					<option value="draft"><?php _e(array('Draft',false));
;
?></option>
				</select>
			</label>

<?php if ( (((denot_boolean($is_page)) && $can_publish[0]) && deAspis(current_user_can(array('edit_others_posts',false)))))
 {;
?>

<?php if ( $bulk[0])
 {;
?>

			<label class="alignright">
				<span class="title"><?php _e(array('Sticky',false));
;
?></span>
				<select name="sticky">
					<option value="-1"><?php _e(array('- No Change -',false));
;
?></option>
					<option value="sticky"><?php _e(array('Sticky',false));
;
?></option>
					<option value="unsticky"><?php _e(array('Not Sticky',false));
;
?></option>
				</select>
			</label>

<?php }else 
{;
?>

			<label class="alignleft">
				<input type="checkbox" name="sticky" value="sticky" />
				<span class="checkbox-title"><?php _e(array('Make this post sticky',false));
;
?></span>
			</label>

<?php };
?>

<?php };
?>

		</div>

	</div></fieldset>

<?php foreach ( $columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{if ( ((isset($core_columns[0][$column_name[0]]) && Aspis_isset( $core_columns [0][$column_name[0]]))))
 continue ;
do_action($bulk[0] ? array('bulk_edit_custom_box',false) : array('quick_edit_custom_box',false),$column_name,$type);
}};
?>
	<p class="submit inline-edit-save">
		<a accesskey="c" href="#inline-edit" title="<?php _e(array('Cancel',false));
;
?>" class="button-secondary cancel alignleft"><?php _e(array('Cancel',false));
;
?></a>
		<?php if ( (denot_boolean($bulk)))
 {wp_nonce_field(array('inlineeditnonce',false),array('_inline_edit',false),array(false,false));
$update_text = deAspis(($is_page)) ? __(array('Update Page',false)) : __(array('Update Post',false));
;
?>
			<a accesskey="s" href="#inline-edit" title="<?php _e(array('Update',false));
;
?>" class="button-primary save alignright"><?php echo AspisCheckPrint(esc_attr($update_text));
;
?></a>
			<img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" />
		<?php }else 
{{$update_text = deAspis(($is_page)) ? __(array('Update Pages',false)) : __(array('Update Posts',false));
;
?>
			<input accesskey="s" class="button-primary alignright" type="submit" name="bulk_edit" value="<?php echo AspisCheckPrint(esc_attr($update_text));
;
?>" />
		<?php }};
?>
		<input type="hidden" name="post_view" value="<?php echo AspisCheckPrint($m);
;
?>" />
		<br class="clear" />
	</p>
	</td></tr>
<?php postincr($bulk);
};
?>
	</tbody></table></form>
<?php  }
function get_inline_data ( $post ) {
if ( (denot_boolean(current_user_can(concat1('edit_',$post[0]->post_type),$post[0]->ID))))
 return ;
$title = esc_attr($post[0]->post_title);
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('
<div class="hidden" id="inline_',$post[0]->ID),'">
	<div class="post_title">'),$title),'</div>
	<div class="post_name">'),apply_filters(array('editable_slug',false),$post[0]->post_name)),'</div>
	<div class="post_author">'),$post[0]->post_author),'</div>
	<div class="comment_status">'),$post[0]->comment_status),'</div>
	<div class="ping_status">'),$post[0]->ping_status),'</div>
	<div class="_status">'),$post[0]->post_status),'</div>
	<div class="jj">'),mysql2date(array('d',false),$post[0]->post_date,array(false,false))),'</div>
	<div class="mm">'),mysql2date(array('m',false),$post[0]->post_date,array(false,false))),'</div>
	<div class="aa">'),mysql2date(array('Y',false),$post[0]->post_date,array(false,false))),'</div>
	<div class="hh">'),mysql2date(array('H',false),$post[0]->post_date,array(false,false))),'</div>
	<div class="mn">'),mysql2date(array('i',false),$post[0]->post_date,array(false,false))),'</div>
	<div class="ss">'),mysql2date(array('s',false),$post[0]->post_date,array(false,false))),'</div>
	<div class="post_password">'),esc_html($post[0]->post_password)),'</div>'));
if ( ($post[0]->post_type[0] == ('page')))
 echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('
	<div class="post_parent">',$post[0]->post_parent),'</div>
	<div class="page_template">'),esc_html(get_post_meta($post[0]->ID,array('_wp_page_template',false),array(true,false)))),'</div>
	<div class="menu_order">'),$post[0]->menu_order),'</div>'));
if ( ($post[0]->post_type[0] == ('post')))
 echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('
	<div class="tags_input">',esc_html(Aspis_str_replace(array(',',false),array(', ',false),get_tags_to_edit($post[0]->ID)))),'</div>
	<div class="post_category">'),Aspis_implode(array(',',false),wp_get_post_categories($post[0]->ID))),'</div>
	<div class="sticky">'),(deAspis(is_sticky($post[0]->ID)) ? array('sticky',false) : array('',false))),'</div>'));
echo AspisCheckPrint(array('</div>',false));
 }
function post_rows ( $posts = array(array(),false) ) {
global $wp_query,$post,$mode;
add_filter(array('the_title',false),array('esc_html',false));
$post_ids = array(array(),false);
if ( ((empty($posts) || Aspis_empty( $posts))))
 $posts = &$wp_query[0]->posts;
foreach ( $posts[0] as $a_post  )
arrayAssignAdd($post_ids[0][],addTaint($a_post[0]->ID));
$comment_pending_count = get_pending_comments_num($post_ids);
if ( ((empty($comment_pending_count) || Aspis_empty( $comment_pending_count))))
 $comment_pending_count = array(array(),false);
foreach ( $posts[0] as $post  )
{if ( ((empty($comment_pending_count[0][$post[0]->ID[0]]) || Aspis_empty( $comment_pending_count [0][$post[0] ->ID [0]]))))
 arrayAssign($comment_pending_count[0],deAspis(registerTaint($post[0]->ID)),addTaint(array(0,false)));
_post_row($post,attachAspis($comment_pending_count,$post[0]->ID[0]),$mode);
} }
function _post_row ( $a_post,$pending_comments,$mode ) {
global $post,$current_user;
static $rowclass;
$global_post = $post;
$post = $a_post;
setup_postdata($post);
$rowclass = (('alternate') == $rowclass[0]) ? array('',false) : array('alternate',false);
$post_owner = (($current_user[0]->ID[0] == $post[0]->post_author[0]) ? array('self',false) : array('other',false));
$edit_link = get_edit_post_link($post[0]->ID);
$title = _draft_or_post_title();
;
?>
	<tr id='post-<?php echo AspisCheckPrint($post[0]->ID);
;
?>' class='<?php echo AspisCheckPrint(Aspis_trim(concat(concat2(concat(concat2($rowclass,' author-'),$post_owner),' status-'),$post[0]->post_status)));
;
?> iedit' valign="top">
<?php $posts_columns = get_column_headers(array('edit',false));
$hidden = get_hidden_columns(array('edit',false));
foreach ( $posts_columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):;
?>
		<th scope="row" class="check-column"><?php if ( deAspis(current_user_can(array('edit_post',false),$post[0]->ID)))
 {;
?><input type="checkbox" name="post[]" value="<?php the_ID();
;
?>" /><?php };
?></th>
		<?php break ;
case ('date'):if ( ((('0000-00-00 00:00:00') == $post[0]->post_date[0]) && (('date') == $column_name[0])))
 {$t_time = $h_time = __(array('Unpublished',false));
$time_diff = array(0,false);
}else 
{{$t_time = get_the_time(__(array('Y/m/d g:i:s A',false)));
$m_time = $post[0]->post_date;
$time = get_post_time(array('G',false),array(true,false),$post);
$time_diff = array(time() - $time[0],false);
if ( (($time_diff[0] > (0)) && ($time_diff[0] < (((24) * (60)) * (60)))))
 $h_time = Aspis_sprintf(__(array('%s ago',false)),human_time_diff($time));
else 
{$h_time = mysql2date(__(array('Y/m/d',false)),$m_time);
}}}echo AspisCheckPrint(concat2(concat1('<td ',$attributes),'>'));
if ( (('excerpt') == $mode[0]))
 echo AspisCheckPrint(apply_filters(array('post_date_column_time',false),$t_time,$post,$column_name,$mode));
else 
{echo AspisCheckPrint(concat2(concat(concat2(concat1('<abbr title="',$t_time),'">'),apply_filters(array('post_date_column_time',false),$h_time,$post,$column_name,$mode)),'</abbr>'));
}echo AspisCheckPrint(array('<br />',false));
if ( (('publish') == $post[0]->post_status[0]))
 {_e(array('Published',false));
}elseif ( (('future') == $post[0]->post_status[0]))
 {if ( ($time_diff[0] > (0)))
 echo AspisCheckPrint(concat2(concat1('<strong class="attention">',__(array('Missed schedule',false))),'</strong>'));
else 
{_e(array('Scheduled',false));
}}else 
{{_e(array('Last Modified',false));
}}echo AspisCheckPrint(array('</td>',false));
break ;
case ('title'):$attributes = concat1('class="post-title column-title"',$style);
;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><strong><?php if ( (deAspis(current_user_can(array('edit_post',false),$post[0]->ID)) && ($post[0]->post_status[0] != ('trash'))))
 {;
?><a class="row-title" href="<?php echo AspisCheckPrint($edit_link);
;
?>" title="<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$title)));
;
?>"><?php echo AspisCheckPrint($title);
?></a><?php }else 
{{echo AspisCheckPrint($title);
}};
_post_states($post);
;
?></strong>
		<?php if ( (('excerpt') == $mode[0]))
 the_excerpt();
$actions = array(array(),false);
if ( (deAspis(current_user_can(array('edit_post',false),$post[0]->ID)) && (('trash') != $post[0]->post_status[0])))
 {arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_edit_post_link($post[0]->ID,array(true,false))),'" title="'),esc_attr(__(array('Edit this post',false)))),'">'),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('inline hide-if-no-js',false))),addTaint(concat2(concat(concat2(concat1('<a href="#" class="editinline" title="',esc_attr(__(array('Edit this post inline',false)))),'">'),__(array('Quick&nbsp;Edit',false))),'</a>')));
}if ( deAspis(current_user_can(array('delete_post',false),$post[0]->ID)))
 {if ( (('trash') == $post[0]->post_status[0]))
 arrayAssign($actions[0],deAspis(registerTaint(array('untrash',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a title='",esc_attr(__(array('Restore this post from the Trash',false)))),"' href='"),wp_nonce_url(concat1("post.php?action=untrash&amp;post=",$post[0]->ID),concat1('untrash-post_',$post[0]->ID))),"'>"),__(array('Restore',false))),"</a>")));
elseif ( EMPTY_TRASH_DAYS)
 arrayAssign($actions[0],deAspis(registerTaint(array('trash',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='submitdelete' title='",esc_attr(__(array('Move this post to the Trash',false)))),"' href='"),get_delete_post_link($post[0]->ID)),"'>"),__(array('Trash',false))),"</a>")));
if ( ((('trash') == $post[0]->post_status[0]) || (!(EMPTY_TRASH_DAYS))))
 arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='submitdelete' title='",esc_attr(__(array('Delete this post permanently',false)))),"' href='"),wp_nonce_url(concat1("post.php?action=delete&amp;post=",$post[0]->ID),concat1('delete-post_',$post[0]->ID))),"'>"),__(array('Delete Permanently',false))),"</a>")));
}if ( deAspis(Aspis_in_array($post[0]->post_status,array(array(array('pending',false),array('draft',false)),false))))
 {if ( deAspis(current_user_can(array('edit_post',false),$post[0]->ID)))
 arrayAssign($actions[0],deAspis(registerTaint(array('view',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_permalink($post[0]->ID)),'" title="'),esc_attr(Aspis_sprintf(__(array('Preview &#8220;%s&#8221;',false)),$title))),'" rel="permalink">'),__(array('Preview',false))),'</a>')));
}elseif ( (('trash') != $post[0]->post_status[0]))
 {arrayAssign($actions[0],deAspis(registerTaint(array('view',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_permalink($post[0]->ID)),'" title="'),esc_attr(Aspis_sprintf(__(array('View &#8220;%s&#8221;',false)),$title))),'" rel="permalink">'),__(array('View',false))),'</a>')));
}$actions = apply_filters(array('post_row_actions',false),$actions,$post);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
echo AspisCheckPrint(array('<div class="row-actions">',false));
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
echo AspisCheckPrint(concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}echo AspisCheckPrint(array('</div>',false));
get_inline_data($post);
;
?>
		</td>
		<?php break ;
case ('categories'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php $categories = get_the_category();
if ( (!((empty($categories) || Aspis_empty( $categories)))))
 {$out = array(array(),false);
foreach ( $categories[0] as $c  )
arrayAssignAdd($out[0][],addTaint(concat2(concat(concat2(concat1("<a href='edit.php?category_name=",$c[0]->slug),"'> "),esc_html(sanitize_term_field(array('name',false),$c[0]->name,$c[0]->term_id,array('category',false),array('display',false)))),"</a>")));
echo AspisCheckPrint(Aspis_join(array(', ',false),$out));
}else 
{{_e(array('Uncategorized',false));
}};
?></td>
		<?php break ;
case ('tags'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php $tags = get_the_tags($post[0]->ID);
if ( (!((empty($tags) || Aspis_empty( $tags)))))
 {$out = array(array(),false);
foreach ( $tags[0] as $c  )
arrayAssignAdd($out[0][],addTaint(concat2(concat(concat2(concat1("<a href='edit.php?tag=",$c[0]->slug),"'> "),esc_html(sanitize_term_field(array('name',false),$c[0]->name,$c[0]->term_id,array('post_tag',false),array('display',false)))),"</a>")));
echo AspisCheckPrint(Aspis_join(array(', ',false),$out));
}else 
{{_e(array('No Tags',false));
}};
?></td>
		<?php break ;
case ('comments'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><div class="post-com-count-wrapper">
		<?php $pending_phrase = Aspis_sprintf(__(array('%s pending',false)),attAspis(number_format($pending_comments[0])));
if ( $pending_comments[0])
 echo AspisCheckPrint(array('<strong>',false));
comments_number(concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$post[0]->ID),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('0',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$post[0]->ID),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('1',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$post[0]->ID),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('%',false),array('comment count',false))),'</span></a>'));
if ( $pending_comments[0])
 echo AspisCheckPrint(array('</strong>',false));
;
?>
		</div></td>
		<?php break ;
case ('author'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><a href="edit.php?author=<?php the_author_meta(array('ID',false));
;
?>"><?php the_author();
?></a></td>
		<?php break ;
case ('control_view'):;
?>
		<td><a href="<?php the_permalink();
;
?>" rel="permalink" class="view"><?php _e(array('View',false));
;
?></a></td>
		<?php break ;
case ('control_edit'):;
?>
		<td><?php if ( deAspis(current_user_can(array('edit_post',false),$post[0]->ID)))
 {echo AspisCheckPrint(concat2(concat(concat2(concat1("<a href='",$edit_link),"' class='edit'>"),__(array('Edit',false))),"</a>"));
};
?></td>
		<?php break ;
case ('control_delete'):;
?>
		<td><?php if ( deAspis(current_user_can(array('delete_post',false),$post[0]->ID)))
 {echo AspisCheckPrint(concat2(concat(concat2(concat1("<a href='",wp_nonce_url(concat1("post.php?action=delete&amp;post=",$id),concat1('delete-post_',$post[0]->ID))),"' class='delete'>"),__(array('Delete',false))),"</a>"));
};
?></td>
		<?php break ;
default :;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php do_action(array('manage_posts_custom_column',false),$column_name,$post[0]->ID);
;
?></td>
		<?php break ;
 }
}};
?>
	</tr>
<?php $post = $global_post;
 }
function display_page_row ( $page,$level = array(0,false) ) {
global $post;
static $rowclass;
$post = $page;
setup_postdata($page);
if ( (((0) == $level[0]) && (deAspis(int_cast($page[0]->post_parent)) > (0))))
 {$find_main_page = int_cast($page[0]->post_parent);
while ( ($find_main_page[0] > (0)) )
{$parent = get_page($find_main_page);
if ( is_null(deAspisRC($parent)))
 break ;
postincr($level);
$find_main_page = int_cast($parent[0]->post_parent);
if ( (!((isset($parent_name) && Aspis_isset( $parent_name)))))
 $parent_name = $parent[0]->post_title;
}}$page[0]->post_title = esc_html($page[0]->post_title);
$pad = Aspis_str_repeat(array('&#8212; ',false),$level);
$id = int_cast($page[0]->ID);
$rowclass = (('alternate') == $rowclass[0]) ? array('',false) : array('alternate',false);
$posts_columns = get_column_headers(array('edit-pages',false));
$hidden = get_hidden_columns(array('edit-pages',false));
$title = _draft_or_post_title();
;
?>
<tr id="page-<?php echo AspisCheckPrint($id);
;
?>" class="<?php echo AspisCheckPrint($rowclass);
;
?> iedit">
<?php foreach ( $posts_columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):;
?>
		<th scope="row" class="check-column"><input type="checkbox" name="post[]" value="<?php the_ID();
;
?>" /></th>
		<?php break ;
case ('date'):if ( ((('0000-00-00 00:00:00') == $page[0]->post_date[0]) && (('date') == $column_name[0])))
 {$t_time = $h_time = __(array('Unpublished',false));
$time_diff = array(0,false);
}else 
{{$t_time = get_the_time(__(array('Y/m/d g:i:s A',false)));
$m_time = $page[0]->post_date;
$time = get_post_time(array('G',false),array(true,false));
$time_diff = array(time() - $time[0],false);
if ( (($time_diff[0] > (0)) && ($time_diff[0] < (((24) * (60)) * (60)))))
 $h_time = Aspis_sprintf(__(array('%s ago',false)),human_time_diff($time));
else 
{$h_time = mysql2date(__(array('Y/m/d',false)),$m_time);
}}}echo AspisCheckPrint(concat2(concat1('<td ',$attributes),'>'));
echo AspisCheckPrint(concat2(concat(concat2(concat1('<abbr title="',$t_time),'">'),apply_filters(array('post_date_column_time',false),$h_time,$page,$column_name,array('',false))),'</abbr>'));
echo AspisCheckPrint(array('<br />',false));
if ( (('publish') == $page[0]->post_status[0]))
 {_e(array('Published',false));
}elseif ( (('future') == $page[0]->post_status[0]))
 {if ( ($time_diff[0] > (0)))
 echo AspisCheckPrint(concat2(concat1('<strong class="attention">',__(array('Missed schedule',false))),'</strong>'));
else 
{_e(array('Scheduled',false));
}}else 
{{_e(array('Last Modified',false));
}}echo AspisCheckPrint(array('</td>',false));
break ;
case ('title'):$attributes = concat1('class="post-title page-title column-title"',$style);
$edit_link = get_edit_post_link($page[0]->ID);
;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><strong><?php if ( (deAspis(current_user_can(array('edit_page',false),$page[0]->ID)) && ($post[0]->post_status[0] != ('trash'))))
 {;
?><a class="row-title" href="<?php echo AspisCheckPrint($edit_link);
;
?>" title="<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),$title)));
;
?>"><?php echo AspisCheckPrint($pad);
echo AspisCheckPrint($title);
?></a><?php }else 
{{echo AspisCheckPrint($pad);
echo AspisCheckPrint($title);
}};
_post_states($page);
echo AspisCheckPrint(((isset($parent_name) && Aspis_isset( $parent_name))) ? concat(concat1(' | ',__(array('Parent Page: ',false))),esc_html($parent_name)) : array('',false));
;
?></strong>
		<?php $actions = array(array(),false);
if ( (deAspis(current_user_can(array('edit_page',false),$page[0]->ID)) && ($post[0]->post_status[0] != ('trash'))))
 {arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$edit_link),'" title="'),esc_attr(__(array('Edit this page',false)))),'">'),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('inline',false))),addTaint(concat2(concat1('<a href="#" class="editinline">',__(array('Quick&nbsp;Edit',false))),'</a>')));
}if ( deAspis(current_user_can(array('delete_page',false),$page[0]->ID)))
 {if ( ($post[0]->post_status[0] == ('trash')))
 arrayAssign($actions[0],deAspis(registerTaint(array('untrash',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a title='",esc_attr(__(array('Remove this page from the Trash',false)))),"' href='"),wp_nonce_url(concat1("page.php?action=untrash&amp;post=",$page[0]->ID),concat1('untrash-page_',$page[0]->ID))),"'>"),__(array('Restore',false))),"</a>")));
elseif ( EMPTY_TRASH_DAYS)
 arrayAssign($actions[0],deAspis(registerTaint(array('trash',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='submitdelete' title='",esc_attr(__(array('Move this page to the Trash',false)))),"' href='"),get_delete_post_link($page[0]->ID)),"'>"),__(array('Trash',false))),"</a>")));
if ( (($post[0]->post_status[0] == ('trash')) || (!(EMPTY_TRASH_DAYS))))
 arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a class='submitdelete' title='",esc_attr(__(array('Delete this page permanently',false)))),"' href='"),wp_nonce_url(concat1("page.php?action=delete&amp;post=",$page[0]->ID),concat1('delete-page_',$page[0]->ID))),"'>"),__(array('Delete Permanently',false))),"</a>")));
}if ( deAspis(Aspis_in_array($post[0]->post_status,array(array(array('pending',false),array('draft',false)),false))))
 {if ( deAspis(current_user_can(array('edit_page',false),$page[0]->ID)))
 arrayAssign($actions[0],deAspis(registerTaint(array('view',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_permalink($page[0]->ID)),'" title="'),esc_attr(Aspis_sprintf(__(array('Preview &#8220;%s&#8221;',false)),$title))),'" rel="permalink">'),__(array('Preview',false))),'</a>')));
}elseif ( ($post[0]->post_status[0] != ('trash')))
 {arrayAssign($actions[0],deAspis(registerTaint(array('view',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_permalink($page[0]->ID)),'" title="'),esc_attr(Aspis_sprintf(__(array('View &#8220;%s&#8221;',false)),$title))),'" rel="permalink">'),__(array('View',false))),'</a>')));
}$actions = apply_filters(array('page_row_actions',false),$actions,$page);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
echo AspisCheckPrint(array('<div class="row-actions">',false));
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
echo AspisCheckPrint(concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}echo AspisCheckPrint(array('</div>',false));
get_inline_data($post);
echo AspisCheckPrint(array('</td>',false));
break ;
case ('comments'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><div class="post-com-count-wrapper">
		<?php $left = get_pending_comments_num($page[0]->ID);
$pending_phrase = Aspis_sprintf(__(array('%s pending',false)),attAspis(number_format($left[0])));
if ( $left[0])
 echo AspisCheckPrint(array('<strong>',false));
comments_number(concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$id),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('0',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$id),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('1',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$id),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('%',false),array('comment count',false))),'</span></a>'));
if ( $left[0])
 echo AspisCheckPrint(array('</strong>',false));
;
?>
		</div></td>
		<?php break ;
case ('author'):;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><a href="edit-pages.php?author=<?php the_author_meta(array('ID',false));
;
?>"><?php the_author();
?></a></td>
		<?php break ;
default :;
?>
		<td <?php echo AspisCheckPrint($attributes);
?>><?php do_action(array('manage_pages_custom_column',false),$column_name,$id);
;
?></td>
		<?php break ;
 }
}};
?>

</tr>

<?php  }
function page_rows ( $pages,$pagenum = array(1,false),$per_page = array(20,false) ) {
global $wpdb;
$level = array(0,false);
if ( (denot_boolean($pages)))
 {$pages = get_pages(array(array('sort_column' => array('menu_order',false,false)),false));
if ( (denot_boolean($pages)))
 return array(false,false);
}if ( ((empty($_GET[0][('s')]) || Aspis_empty( $_GET [0][('s')]))))
 {$top_level_pages = array(array(),false);
$children_pages = array(array(),false);
foreach ( $pages[0] as $page  )
{if ( ($page[0]->post_parent[0] == $page[0]->ID[0]))
 {$page[0]->post_parent = array(0,false);
$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_parent = '0' WHERE ID = %d"),$page[0]->ID));
clean_page_cache($page[0]->ID);
}if ( ((0) == $page[0]->post_parent[0]))
 arrayAssignAdd($top_level_pages[0][],addTaint($page));
else 
{arrayAssignAdd($children_pages[0][$page[0]->post_parent[0]][0][],addTaint($page));
}}$pages = &$top_level_pages;
}$count = array(0,false);
$start = array(($pagenum[0] - (1)) * $per_page[0],false);
$end = array($start[0] + $per_page[0],false);
foreach ( $pages[0] as $page  )
{if ( ($count[0] >= $end[0]))
 break ;
if ( ($count[0] >= $start[0]))
 echo AspisCheckPrint(concat1("\t",display_page_row($page,$level)));
postincr($count);
if ( ((isset($children_pages) && Aspis_isset( $children_pages))))
 _page_rows($children_pages,$count,$page[0]->ID,array($level[0] + (1),false),$pagenum,$per_page);
}if ( (((isset($children_pages) && Aspis_isset( $children_pages))) && ($count[0] < $end[0])))
 {foreach ( $children_pages[0] as $orphans  )
{foreach ( $orphans[0] as $op  )
{if ( ($count[0] >= $end[0]))
 break ;
if ( ($count[0] >= $start[0]))
 echo AspisCheckPrint(concat1("\t",display_page_row($op,array(0,false))));
postincr($count);
}}} }
function _page_rows ( &$children_pages,&$count,$parent,$level,$pagenum,$per_page ) {
if ( (!((isset($children_pages[0][$parent[0]]) && Aspis_isset( $children_pages [0][$parent[0]])))))
 return ;
$start = array(($pagenum[0] - (1)) * $per_page[0],false);
$end = array($start[0] + $per_page[0],false);
foreach ( deAspis(attachAspis($children_pages,$parent[0])) as $page  )
{if ( ($count[0] >= $end[0]))
 break ;
if ( (($count[0] == $start[0]) && ($page[0]->post_parent[0] > (0))))
 {$my_parents = array(array(),false);
$my_parent = $page[0]->post_parent;
while ( $my_parent[0] )
{$my_parent = get_post($my_parent);
arrayAssignAdd($my_parents[0][],addTaint($my_parent));
if ( (denot_boolean($my_parent[0]->post_parent)))
 break ;
$my_parent = $my_parent[0]->post_parent;
}$num_parents = attAspis(count($my_parents[0]));
while ( deAspis($my_parent = Aspis_array_pop($my_parents)) )
{echo AspisCheckPrint(concat1("\t",display_page_row($my_parent,array($level[0] - $num_parents[0],false))));
postdecr($num_parents);
}}if ( ($count[0] >= $start[0]))
 echo AspisCheckPrint(concat1("\t",display_page_row($page,$level)));
postincr($count);
_page_rows($children_pages,$count,$page[0]->ID,array($level[0] + (1),false),$pagenum,$per_page);
}unset($children_pages[0][$parent[0]]);
 }
function user_row ( $user_object,$style = array('',false),$role = array('',false) ) {
global $wp_roles;
$current_user = wp_get_current_user();
if ( (!(is_object($user_object[0]) && is_a(deAspisRC($user_object),('WP_User')))))
 $user_object = array(new WP_User(int_cast($user_object)),false);
$user_object = sanitize_user_object($user_object,array('display',false));
$email = $user_object[0]->user_email;
$url = $user_object[0]->user_url;
$short_url = Aspis_str_replace(array('http://',false),array('',false),$url);
$short_url = Aspis_str_replace(array('www.',false),array('',false),$short_url);
if ( (('/') == deAspis(Aspis_substr($short_url,negate(array(1,false))))))
 $short_url = Aspis_substr($short_url,array(0,false),negate(array(1,false)));
if ( (strlen($short_url[0]) > (35)))
 $short_url = concat2(Aspis_substr($short_url,array(0,false),array(32,false)),'...');
$numposts = get_usernumposts($user_object[0]->ID);
$checkbox = array('',false);
if ( deAspis(current_user_can(array('edit_user',false),$user_object[0]->ID)))
 {if ( ($current_user[0]->ID[0] == $user_object[0]->ID[0]))
 {$edit_link = array('profile.php',false);
}else 
{{$edit_link = esc_url(add_query_arg(array('wp_http_referer',false),Aspis_urlencode(esc_url(Aspis_stripslashes($_SERVER[0]['REQUEST_URI']))),concat1("user-edit.php?user_id=",$user_object[0]->ID)));
}}$edit = concat2(concat(concat2(concat1("<strong><a href=\"",$edit_link),"\">"),$user_object[0]->user_login),"</a></strong><br />");
$actions = array(array(),false);
arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat1('<a href="',$edit_link),'">'),__(array('Edit',false))),'</a>')));
if ( ($current_user[0]->ID[0] != $user_object[0]->ID[0]))
 arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat1("<a class='submitdelete' href='",wp_nonce_url(concat1("users.php?action=delete&amp;user=",$user_object[0]->ID),array('bulk-users',false))),"'>"),__(array('Delete',false))),"</a>")));
$actions = apply_filters(array('user_row_actions',false),$actions,$user_object);
$action_count = attAspis(count($actions[0]));
$i = array(0,false);
$edit = concat2($edit,'<div class="row-actions">');
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
($i[0] == $action_count[0]) ? $sep = array('',false) : $sep = array(' | ',false);
$edit = concat($edit,concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$link),$sep),"</span>"));
}}$edit = concat2($edit,'</div>');
$checkbox = concat2(concat(concat2(concat(concat2(concat1("<input type='checkbox' name='users[]' id='user_",$user_object[0]->ID),"' class='"),$role),"' value='"),$user_object[0]->ID),"' />");
}else 
{{$edit = concat2(concat1('<strong>',$user_object[0]->user_login),'</strong>');
}}$role_name = ((isset($wp_roles[0]->role_names[0][$role[0]]) && Aspis_isset( $wp_roles[0] ->role_names [0][$role[0]] ))) ? translate_user_role($wp_roles[0]->role_names[0][$role[0]]) : __(array('None',false));
$r = concat2(concat(concat2(concat1("<tr id='user-",$user_object[0]->ID),"'"),$style),">");
$columns = get_column_headers(array('users',false));
$hidden = get_hidden_columns(array('users',false));
$avatar = get_avatar($user_object[0]->ID,array(32,false));
foreach ( $columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):$r = concat($r,concat2(concat1("<th scope='row' class='check-column'>",$checkbox),"</th>"));
break ;
case ('username'):$r = concat($r,concat2(concat(concat2(concat(concat2(concat1("<td ",$attributes),">"),$avatar)," "),$edit),"</td>"));
break ;
case ('name'):$r = concat($r,concat2(concat(concat2(concat(concat2(concat1("<td ",$attributes),">"),$user_object[0]->first_name)," "),$user_object[0]->last_name),"</td>"));
break ;
case ('email'):$r = concat($r,concat(concat(concat2(concat(concat2(concat1("<td ",$attributes),"><a href='mailto:"),$email),"' title='"),Aspis_sprintf(__(array('e-mail: %s',false)),$email)),concat2(concat1("'>",$email),"</a></td>")));
break ;
case ('role'):$r = concat($r,concat2(concat(concat2(concat1("<td ",$attributes),">"),$role_name),"</td>"));
break ;
case ('posts'):$attributes = concat1('class="posts column-posts num"',$style);
$r = concat($r,concat2(concat1("<td ",$attributes),">"));
if ( ($numposts[0] > (0)))
 {$r = concat($r,concat2(concat(concat2(concat1("<a href='edit.php?author=",$user_object[0]->ID),"' title='"),__(array('View posts by this author',false))),"' class='edit'>"));
$r = concat($r,$numposts);
$r = concat2($r,'</a>');
}else 
{{$r = concat2($r,0);
}}$r = concat2($r,"</td>");
break ;
default :$r = concat($r,concat2(concat1("<td ",$attributes),">"));
$r = concat($r,apply_filters(array('manage_users_custom_column',false),array('',false),$column_name,$user_object[0]->ID));
$r = concat2($r,"</td>");
 }
}}$r = concat2($r,'</tr>');
return $r;
 }
function _wp_get_comment_list ( $status = array('',false),$s = array(false,false),$start,$num,$post = array(0,false),$type = array('',false) ) {
global $wpdb;
$start = Aspis_abs(int_cast($start));
$num = int_cast($num);
$post = int_cast($post);
$count = wp_count_comments();
$index = array('',false);
if ( (('moderated') == $status[0]))
 {$approved = array("c.comment_approved = '0'",false);
$total = $count[0]->moderated;
}elseif ( (('approved') == $status[0]))
 {$approved = array("c.comment_approved = '1'",false);
$total = $count[0]->approved;
}elseif ( (('spam') == $status[0]))
 {$approved = array("c.comment_approved = 'spam'",false);
$total = $count[0]->spam;
}elseif ( (('trash') == $status[0]))
 {$approved = array("c.comment_approved = 'trash'",false);
$total = $count[0]->trash;
}else 
{{$approved = array("( c.comment_approved = '0' OR c.comment_approved = '1' )",false);
$total = array($count[0]->moderated[0] + $count[0]->approved[0],false);
$index = array('USE INDEX (c.comment_date_gmt)',false);
}}if ( $post[0])
 {$total = array('',false);
$post = concat2(concat1(" AND c.comment_post_ID = '",$post),"'");
}else 
{{$post = array('',false);
}}$orderby = concat(concat2(concat1("ORDER BY c.comment_date_gmt DESC LIMIT ",$start),", "),$num);
if ( (('comment') == $type[0]))
 $typesql = array("AND c.comment_type = ''",false);
elseif ( (('pings') == $type[0]))
 $typesql = array("AND ( c.comment_type = 'pingback' OR c.comment_type = 'trackback' )",false);
elseif ( (('all') == $type[0]))
 $typesql = array('',false);
elseif ( (!((empty($type) || Aspis_empty( $type)))))
 $typesql = $wpdb[0]->prepare(array("AND c.comment_type = %s",false),$type);
else 
{$typesql = array('',false);
}if ( (!((empty($type) || Aspis_empty( $type)))))
 $total = array('',false);
$query = concat2(concat(concat2(concat1("FROM ",$wpdb[0]->comments)," c LEFT JOIN "),$wpdb[0]->posts)," p ON c.comment_post_ID = p.ID WHERE p.post_status != 'trash' ");
if ( $s[0])
 {$total = array('',false);
$s = $wpdb[0]->escape($s);
$query = concat($query,concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("AND
			(c.comment_author LIKE '%",$s),"%' OR
			c.comment_author_email LIKE '%"),$s),"%' OR
			c.comment_author_url LIKE ('%"),$s),"%') OR
			c.comment_author_IP LIKE ('%"),$s),"%') OR
			c.comment_content LIKE ('%"),$s),"%') ) AND
			"),$approved),"
			"),$typesql));
}else 
{{$query = concat($query,concat(concat2(concat(concat2(concat1("AND ",$approved)," "),$post)," "),$typesql));
}}$comments = $wpdb[0]->get_results(concat(concat2(concat1("SELECT * ",$query)," "),$orderby));
if ( (('') === $total[0]))
 $total = $wpdb[0]->get_var(concat1("SELECT COUNT(c.comment_ID) ",$query));
update_comment_cache($comments);
return array(array($comments,$total),false);
 }
function _wp_comment_row ( $comment_id,$mode,$comment_status,$checkbox = array(true,false),$from_ajax = array(false,false) ) {
global $comment,$post,$_comment_pending_count;
$comment = get_comment($comment_id);
$post = get_post($comment[0]->comment_post_ID);
$the_comment_status = wp_get_comment_status($comment[0]->comment_ID);
$user_can = current_user_can(array('edit_post',false),$post[0]->ID);
$author_url = get_comment_author_url();
if ( (('http://') == $author_url[0]))
 $author_url = array('',false);
$author_url_display = Aspis_preg_replace(array('|http://(www\.)?|i',false),array('',false),$author_url);
if ( (strlen($author_url_display[0]) > (50)))
 $author_url_display = concat2(Aspis_substr($author_url_display,array(0,false),array(49,false)),'...');
$ptime = attAspis(date(('G'),strtotime($comment[0]->comment_date[0])));
if ( (deAspis((Aspis_abs(array(time() - $ptime[0],false)))) < (86400)))
 $ptime = Aspis_sprintf(__(array('%s ago',false)),human_time_diff($ptime));
else 
{$ptime = mysql2date(__(array('Y/m/d \a\t g:i A',false)),$comment[0]->comment_date);
}if ( $user_can[0])
 {$del_nonce = esc_html(concat1('_wpnonce=',wp_create_nonce(concat1("delete-comment_",$comment[0]->comment_ID))));
$approve_nonce = esc_html(concat1('_wpnonce=',wp_create_nonce(concat1("approve-comment_",$comment[0]->comment_ID))));
$comment_url = esc_url(get_comment_link($comment[0]->comment_ID));
$approve_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=approvecomment&p=",$post[0]->ID),"&c="),$comment[0]->comment_ID),"&"),$approve_nonce));
$unapprove_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=unapprovecomment&p=",$post[0]->ID),"&c="),$comment[0]->comment_ID),"&"),$approve_nonce));
$spam_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=spamcomment&p=",$post[0]->ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
$unspam_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=unspamcomment&p=",$post[0]->ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
$trash_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=trashcomment&p=",$post[0]->ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
$untrash_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=untrashcomment&p=",$post[0]->ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
$delete_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=deletecomment&p=",$post[0]->ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
}echo AspisCheckPrint(concat2(concat(concat2(concat1("<tr id='comment-",$comment[0]->comment_ID),"' class='"),$the_comment_status),"'>"));
$columns = get_column_headers(array('edit-comments',false));
$hidden = get_hidden_columns(array('edit-comments',false));
foreach ( $columns[0] as $column_name =>$column_display_name )
{restoreTaint($column_name,$column_display_name);
{$class = concat2(concat(concat2(concat1("class=\"",$column_name)," column-"),$column_name),"\"");
$style = array('',false);
if ( deAspis(Aspis_in_array($column_name,$hidden)))
 $style = array(' style="display:none;"',false);
$attributes = concat($class,$style);
switch ( $column_name[0] ) {
case ('cb'):if ( (denot_boolean($checkbox)))
 break ;
echo AspisCheckPrint(array('<th scope="row" class="check-column">',false));
if ( $user_can[0])
 echo AspisCheckPrint(concat2(concat1("<input type='checkbox' name='delete_comments[]' value='",$comment[0]->comment_ID),"' />"));
echo AspisCheckPrint(array('</th>',false));
break ;
case ('comment'):echo AspisCheckPrint(concat2(concat1("<td ",$attributes),">"));
echo AspisCheckPrint(array('<div id="submitted-on">',false));
printf(deAspis(__(array('Submitted on <a href="%1$s">%2$s at %3$s</a>',false))),deAspisRC($comment_url),deAspisRC(get_comment_date(__(array('Y/m/d',false)))),deAspisRC(get_comment_date(__(array('g:ia',false)))));
echo AspisCheckPrint(array('</div>',false));
comment_text();
if ( $user_can[0])
 {;
?>
				<div id="inline-<?php echo AspisCheckPrint($comment[0]->comment_ID);
;
?>" class="hidden">
				<textarea class="comment" rows="1" cols="1"><?php echo AspisCheckPrint(Aspis_htmlspecialchars(apply_filters(array('comment_edit_pre',false),$comment[0]->comment_content),array(ENT_QUOTES,false)));
;
?></textarea>
				<div class="author-email"><?php echo AspisCheckPrint(esc_attr($comment[0]->comment_author_email));
;
?></div>
				<div class="author"><?php echo AspisCheckPrint(esc_attr($comment[0]->comment_author));
;
?></div>
				<div class="author-url"><?php echo AspisCheckPrint(esc_attr($comment[0]->comment_author_url));
;
?></div>
				<div class="comment_status"><?php echo AspisCheckPrint($comment[0]->comment_approved);
;
?></div>
				</div>
				<?php }if ( $user_can[0])
 {$actions = array(array('approve' => array('',false,false),'unapprove' => array('',false,false),'reply' => array('',false,false),'quickedit' => array('',false,false),'edit' => array('',false,false),'spam' => array('',false,false),'unspam' => array('',false,false),'trash' => array('',false,false),'untrash' => array('',false,false),'delete' => array('',false,false)),false);
if ( ($comment_status[0] && (('all') != $comment_status[0])))
 {if ( (('approved') == $the_comment_status[0]))
 arrayAssign($actions[0],deAspis(registerTaint(array('unapprove',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$unapprove_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),":e7e7d3:action=dim-comment&amp;new=unapproved vim-u vim-destructive' title='"),esc_attr__(array('Unapprove this comment',false))),"'>"),__(array('Unapprove',false))),'</a>')));
else 
{if ( (('unapproved') == $the_comment_status[0]))
 arrayAssign($actions[0],deAspis(registerTaint(array('approve',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$approve_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),":e7e7d3:action=dim-comment&amp;new=approved vim-a vim-destructive' title='"),esc_attr__(array('Approve this comment',false))),"'>"),__(array('Approve',false))),'</a>')));
}}else 
{{arrayAssign($actions[0],deAspis(registerTaint(array('approve',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$approve_url),"' class='dim:the-comment-list:comment-"),$comment[0]->comment_ID),":unapproved:e7e7d3:e7e7d3:new=approved vim-a' title='"),esc_attr__(array('Approve this comment',false))),"'>"),__(array('Approve',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('unapprove',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$unapprove_url),"' class='dim:the-comment-list:comment-"),$comment[0]->comment_ID),":unapproved:e7e7d3:e7e7d3:new=unapproved vim-u' title='"),esc_attr__(array('Unapprove this comment',false))),"'>"),__(array('Unapprove',false))),'</a>')));
}}if ( ((('spam') != $the_comment_status[0]) && (('trash') != $the_comment_status[0])))
 {arrayAssign($actions[0],deAspis(registerTaint(array('spam',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$spam_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),"::spam=1 vim-s vim-destructive' title='"),esc_attr__(array('Mark this comment as spam',false))),"'>"),_x(array('Spam',false),array('verb',false))),'</a>')));
}elseif ( (('spam') == $the_comment_status[0]))
 {arrayAssign($actions[0],deAspis(registerTaint(array('unspam',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a href='",$untrash_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),":66cc66:unspam=1 vim-z vim-destructive'>"),__(array('Not Spam',false))),'</a>')));
}elseif ( (('trash') == $the_comment_status[0]))
 {arrayAssign($actions[0],deAspis(registerTaint(array('untrash',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a href='",$untrash_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),":66cc66:untrash=1 vim-z vim-destructive'>"),__(array('Restore',false))),'</a>')));
}if ( (((('spam') == $the_comment_status[0]) || (('trash') == $the_comment_status[0])) || (!(EMPTY_TRASH_DAYS))))
 {arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a href='",$delete_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),"::delete=1 delete vim-d vim-destructive'>"),__(array('Delete Permanently',false))),'</a>')));
}else 
{{arrayAssign($actions[0],deAspis(registerTaint(array('trash',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$trash_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),"::trash=1 delete vim-d vim-destructive' title='"),esc_attr__(array('Move this comment to the trash',false))),"'>"),_x(array('Trash',false),array('verb',false))),'</a>')));
}}if ( (('trash') != $the_comment_status[0]))
 {arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a href='comment.php?action=editcomment&amp;c=",$comment[0]->comment_ID),"' title='"),esc_attr__(array('Edit comment',false))),"'>"),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('quickedit',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<a onclick="commentReply.open(\'',$comment[0]->comment_ID),'\',\''),$post[0]->ID),'\',\'edit\');return false;" class="vim-q" title="'),esc_attr__(array('Quick Edit',false))),'" href="#">'),__(array('Quick&nbsp;Edit',false))),'</a>')));
if ( (('spam') != $the_comment_status[0]))
 arrayAssign($actions[0],deAspis(registerTaint(array('reply',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<a onclick="commentReply.open(\'',$comment[0]->comment_ID),'\',\''),$post[0]->ID),'\');return false;" class="vim-r" title="'),esc_attr__(array('Reply to this comment',false))),'" href="#">'),__(array('Reply',false))),'</a>')));
}$actions = apply_filters(array('comment_row_actions',false),attAspisRC(array_filter(deAspisRC($actions))),$comment);
$i = array(0,false);
echo AspisCheckPrint(array('<div class="row-actions">',false));
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
((((('approve') == $action[0]) || (('unapprove') == $action[0])) && ((2) === $i[0])) || ((1) === $i[0])) ? $sep = array('',false) : $sep = array(' | ',false);
if ( (((('reply') == $action[0]) || (('quickedit') == $action[0])) && (denot_boolean($from_ajax))))
 $action = concat2($action,' hide-if-no-js');
elseif ( ((($action[0] == ('untrash')) && ($the_comment_status[0] == ('trash'))) || (($action[0] == ('unspam')) && ($the_comment_status[0] == ('spam')))))
 {if ( (('1') == deAspis(get_comment_meta($comment_id,array('_wp_trash_meta_status',false),array(true,false)))))
 $action = concat2($action,' approve');
else 
{$action = concat2($action,' unapprove');
}}echo AspisCheckPrint(concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$sep),$link),"</span>"));
}}echo AspisCheckPrint(array('</div>',false));
}echo AspisCheckPrint(array('</td>',false));
break ;
case ('author'):echo AspisCheckPrint(concat2(concat1("<td ",$attributes),"><strong>"));
comment_author();
echo AspisCheckPrint(array('</strong><br />',false));
if ( (!((empty($author_url) || Aspis_empty( $author_url)))))
 echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("<a title='",$author_url),"' href='"),$author_url),"'>"),$author_url_display),"</a><br />"));
if ( $user_can[0])
 {if ( (!((empty($comment[0]->comment_author_email) || Aspis_empty( $comment[0] ->comment_author_email )))))
 {comment_author_email_link();
echo AspisCheckPrint(array('<br />',false));
}echo AspisCheckPrint(array('<a href="edit-comments.php?s=',false));
comment_author_IP();
echo AspisCheckPrint(array('&amp;mode=detail',false));
if ( (('spam') == $comment_status[0]))
 echo AspisCheckPrint(array('&amp;comment_status=spam',false));
echo AspisCheckPrint(array('">',false));
comment_author_IP();
echo AspisCheckPrint(array('</a>',false));
}echo AspisCheckPrint(array('</td>',false));
break ;
case ('date'):echo AspisCheckPrint(concat2(concat(concat2(concat1("<td ",$attributes),">"),get_comment_date(__(array('Y/m/d \a\t g:ia',false)))),'</td>'));
break ;
case ('response'):if ( (('single') !== $mode[0]))
 {if ( ((isset($_comment_pending_count[0][$post[0]->ID[0]]) && Aspis_isset( $_comment_pending_count [0][$post[0] ->ID [0]]))))
 {$pending_comments = absint(attachAspis($_comment_pending_count,$post[0]->ID[0]));
}else 
{{$_comment_pending_count_temp = array_cast(get_pending_comments_num(array(array($post[0]->ID),false)));
$pending_comments = arrayAssign($_comment_pending_count[0],deAspis(registerTaint($post[0]->ID)),addTaint(attachAspis($_comment_pending_count_temp,$post[0]->ID[0])));
}}if ( $user_can[0])
 {$post_link = concat2(concat1("<a href='",get_edit_post_link($post[0]->ID)),"'>");
$post_link = concat($post_link,concat2(get_the_title($post[0]->ID),'</a>'));
}else 
{{$post_link = get_the_title($post[0]->ID);
}}echo AspisCheckPrint(concat2(concat1("<td ",$attributes),">\n"));
echo AspisCheckPrint(array('<div class="response-links"><span class="post-com-count-wrapper">',false));
echo AspisCheckPrint(concat2($post_link,'<br />'));
$pending_phrase = esc_attr(Aspis_sprintf(__(array('%s pending',false)),attAspis(number_format($pending_comments[0]))));
if ( $pending_comments[0])
 echo AspisCheckPrint(array('<strong>',false));
comments_number(concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$post[0]->ID),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('0',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$post[0]->ID),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('1',false),array('comment count',false))),'</span></a>'),concat2(concat(concat2(concat(concat2(concat1("<a href='edit-comments.php?p=",$post[0]->ID),"' title='"),$pending_phrase),"' class='post-com-count'><span class='comment-count'>"),_x(array('%',false),array('comment count',false))),'</span></a>'));
if ( $pending_comments[0])
 echo AspisCheckPrint(array('</strong>',false));
echo AspisCheckPrint(array('</span> ',false));
echo AspisCheckPrint(concat2(concat1("<a href='",get_permalink($post[0]->ID)),"'>#</a>"));
echo AspisCheckPrint(array('</div>',false));
if ( ((('attachment') == $post[0]->post_type[0]) && deAspis(($thumb = wp_get_attachment_image($post[0]->ID,array(array(array(80,false),array(60,false)),false),array(true,false))))))
 echo AspisCheckPrint($thumb);
echo AspisCheckPrint(array('</td>',false));
}break ;
default :echo AspisCheckPrint(concat2(concat1("<td ",$attributes),">\n"));
do_action(array('manage_comments_custom_column',false),$column_name,$comment[0]->comment_ID);
echo AspisCheckPrint(array("</td>\n",false));
break ;
 }
}}echo AspisCheckPrint(array("</tr>\n",false));
 }
function wp_comment_reply ( $position = array('1',false),$checkbox = array(false,false),$mode = array('single',false),$table_row = array(true,false) ) {
global $current_user;
$content = apply_filters(array('wp_comment_reply',false),array('',false),array(array(deregisterTaint(array('position',false)) => addTaint($position),deregisterTaint(array('checkbox',false)) => addTaint($checkbox),deregisterTaint(array('mode',false)) => addTaint($mode)),false));
if ( (!((empty($content) || Aspis_empty( $content)))))
 {echo AspisCheckPrint($content);
return ;
}$columns = get_column_headers(array('edit-comments',false));
$hidden = Aspis_array_intersect(attAspisRC(array_keys(deAspisRC($columns))),attAspisRC(array_filter(deAspisRC(get_hidden_columns(array('edit-comments',false))))));
$col_count = array(count($columns[0]) - count($hidden[0]),false);
;
?>
<form method="get" action="">
<?php if ( $table_row[0])
 {;
?>
<table style="display:none;"><tbody id="com-reply"><tr id="replyrow" style="display:none;"><td colspan="<?php echo AspisCheckPrint($col_count);
;
?>">
<?php }else 
{;
?>
<div id="com-reply" style="display:none;"><div id="replyrow" style="display:none;">
<?php };
?>
	<div id="replyhead" style="display:none;"><?php _e(array('Reply to Comment',false));
;
?></div>

	<div id="edithead" style="display:none;">
		<div class="inside">
		<label for="author"><?php _e(array('Name',false));
?></label>
		<input type="text" name="newcomment_author" size="50" value="" tabindex="101" id="author" />
		</div>

		<div class="inside">
		<label for="author-email"><?php _e(array('E-mail',false));
?></label>
		<input type="text" name="newcomment_author_email" size="50" value="" tabindex="102" id="author-email" />
		</div>

		<div class="inside">
		<label for="author-url"><?php _e(array('URL',false));
?></label>
		<input type="text" id="author-url" name="newcomment_author_url" size="103" value="" tabindex="103" />
		</div>
		<div style="clear:both;"></div>
	</div>

	<div id="replycontainer"><textarea rows="8" cols="40" name="replycontent" tabindex="104" id="replycontent"></textarea></div>

	<p id="replysubmit" class="submit">
	<a href="#comments-form" class="cancel button-secondary alignleft" tabindex="106"><?php _e(array('Cancel',false));
;
?></a>
	<a href="#comments-form" class="save button-primary alignright" tabindex="104">
	<span id="savebtn" style="display:none;"><?php _e(array('Update Comment',false));
;
?></span>
	<span id="replybtn" style="display:none;"><?php _e(array('Submit Reply',false));
;
?></span></a>
	<img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" />
	<span class="error" style="display:none;"></span>
	<br class="clear" />
	</p>

	<input type="hidden" name="user_ID" id="user_ID" value="<?php echo AspisCheckPrint($current_user[0]->ID);
;
?>" />
	<input type="hidden" name="action" id="action" value="" />
	<input type="hidden" name="comment_ID" id="comment_ID" value="" />
	<input type="hidden" name="comment_post_ID" id="comment_post_ID" value="" />
	<input type="hidden" name="status" id="status" value="" />
	<input type="hidden" name="position" id="position" value="<?php echo AspisCheckPrint($position);
;
?>" />
	<input type="hidden" name="checkbox" id="checkbox" value="<?php echo AspisCheckPrint($checkbox[0] ? array(1,false) : array(0,false));
;
?>" />
	<input type="hidden" name="mode" id="mode" value="<?php echo AspisCheckPrint(esc_attr($mode));
;
?>" />
	<?php wp_nonce_field(array('replyto-comment',false),array('_ajax_nonce',false),array(false,false));
;
?>
	<?php wp_comment_form_unfiltered_html_nonce();
;
?>
<?php if ( $table_row[0])
 {;
?>
</td></tr></tbody></table>
<?php }else 
{;
?>
</div></div>
<?php };
?>
</form>
<?php  }
function wp_comment_trashnotice (  ) {
;
?>
<div class="hidden" id="trash-undo-holder">
	<div class="trash-undo-inside"><?php printf(deAspis(__(array('Comment by %s moved to the trash.',false))),'<strong></strong>');
;
?> <span class="undo untrash"><a href="#"><?php _e(array('Undo',false));
;
?></a></span></div>
</div>
<div class="hidden" id="spam-undo-holder">
	<div class="spam-undo-inside"><?php printf(deAspis(__(array('Comment by %s marked as spam.',false))),'<strong></strong>');
;
?> <span class="undo unspam"><a href="#"><?php _e(array('Undo',false));
;
?></a></span></div>
</div>
<?php  }
function wp_dropdown_cats ( $currentcat = array(0,false),$currentparent = array(0,false),$parent = array(0,false),$level = array(0,false),$categories = array(0,false) ) {
if ( (denot_boolean($categories)))
 $categories = get_categories(array(array('hide_empty' => array(0,false,false)),false));
if ( $categories[0])
 {foreach ( $categories[0] as $category  )
{if ( (($currentcat[0] != $category[0]->term_id[0]) && ($parent[0] == $category[0]->parent[0])))
 {$pad = Aspis_str_repeat(array('&#8211; ',false),$level);
$category[0]->name = esc_html($category[0]->name);
echo AspisCheckPrint(concat2(concat1("\n\t<option value='",$category[0]->term_id),"'"));
if ( ($currentparent[0] == $category[0]->term_id[0]))
 echo AspisCheckPrint(array(" selected='selected'",false));
echo AspisCheckPrint(concat2(concat(concat1(">",$pad),$category[0]->name),"</option>"));
wp_dropdown_cats($currentcat,$currentparent,$category[0]->term_id,array($level[0] + (1),false),$categories);
}}}else 
{{return array(false,false);
}} }
function list_meta ( $meta ) {
if ( (denot_boolean($meta)))
 {echo AspisCheckPrint(concat2(concat(concat2(concat1('
<table id="list-table" style="display: none;">
	<thead>
	<tr>
		<th class="left">',__(array('Name',false))),'</th>
		<th>'),__(array('Value',false))),'</th>
	</tr>
	</thead>
	<tbody id="the-list" class="list:meta">
	<tr><td></td></tr>
	</tbody>
</table>'));
return ;
}$count = array(0,false);
;
?>
<table id="list-table">
	<thead>
	<tr>
		<th class="left"><?php _e(array('Name',false));
?></th>
		<th><?php _e(array('Value',false));
?></th>
	</tr>
	</thead>
	<tbody id='the-list' class='list:meta'>
<?php foreach ( $meta[0] as $entry  )
echo AspisCheckPrint(_list_meta_row($entry,$count));
;
?>
	</tbody>
</table>
<?php  }
function _list_meta_row ( $entry,&$count ) {
static $update_nonce = array(false,false);
if ( (denot_boolean($update_nonce)))
 $update_nonce = wp_create_nonce(array('add-meta',false));
$r = array('',false);
preincr($count);
if ( ($count[0] % (2)))
 $style = array('alternate',false);
else 
{$style = array('',false);
}if ( (('_') == deAspis(attachAspis($entry[0][('meta_key')],(0)))))
 $style = concat2($style,' hidden');
if ( deAspis(is_serialized($entry[0]['meta_value'])))
 {if ( deAspis(is_serialized_string($entry[0]['meta_value'])))
 {arrayAssign($entry[0],deAspis(registerTaint(array('meta_value',false))),addTaint(maybe_unserialize($entry[0]['meta_value'])));
}else 
{{predecr($count);
return ;
}}}arrayAssign($entry[0],deAspis(registerTaint(array('meta_key',false))),addTaint(esc_attr($entry[0]['meta_key'])));
arrayAssign($entry[0],deAspis(registerTaint(array('meta_value',false))),addTaint(Aspis_htmlspecialchars($entry[0]['meta_value'])));
arrayAssign($entry[0],deAspis(registerTaint(array('meta_id',false))),addTaint(int_cast($entry[0]['meta_id'])));
$delete_nonce = wp_create_nonce(concat1('delete-meta_',$entry[0]['meta_id']));
$r = concat($r,concat2(concat(concat2(concat1("\n\t<tr id='meta-",$entry[0]['meta_id']),"' class='"),$style),"'>"));
$r = concat($r,concat(concat(concat2(concat1("\n\t\t<td class='left'><label class='screen-reader-text' for='meta[",$entry[0]['meta_id']),"][key]'>"),__(array('Key',false))),concat2(concat(concat2(concat(concat2(concat1("</label><input name='meta[",$entry[0]['meta_id']),"][key]' id='meta["),$entry[0]['meta_id']),"][key]' tabindex='6' type='text' size='20' value='"),$entry[0]['meta_key']),"' />")));
$r = concat($r,concat2(concat1("\n\t\t<div class='submit'><input name='deletemeta[",$entry[0]['meta_id']),"]' type='submit' "));
$r = concat($r,concat2(concat(concat2(concat(concat2(concat1("class='delete:the-list:meta-",$entry[0]['meta_id']),"::_ajax_nonce="),$delete_nonce)," deletemeta' tabindex='6' value='"),esc_attr__(array('Delete',false))),"' />"));
$r = concat($r,concat(concat1("\n\t\t<input name='updatemeta' type='submit' tabindex='6' value='",esc_attr__(array('Update',false))),concat2(concat(concat2(concat1("' class='add:the-list:meta-",$entry[0]['meta_id']),"::_ajax_nonce="),$update_nonce)," updatemeta' /></div>")));
$r = concat($r,wp_nonce_field(array('change-meta',false),array('_ajax_nonce',false),array(false,false),array(false,false)));
$r = concat2($r,"</td>");
$r = concat($r,concat(concat(concat2(concat1("\n\t\t<td><label class='screen-reader-text' for='meta[",$entry[0]['meta_id']),"][value]'>"),__(array('Value',false))),concat2(concat(concat2(concat(concat2(concat1("</label><textarea name='meta[",$entry[0]['meta_id']),"][value]' id='meta["),$entry[0]['meta_id']),"][value]' tabindex='6' rows='2' cols='30'>"),$entry[0]['meta_value']),"</textarea></td>\n\t</tr>")));
return $r;
 }
function meta_form (  ) {
global $wpdb;
$limit = int_cast(apply_filters(array('postmeta_form_limit',false),array(30,false)));
$keys = $wpdb[0]->get_col(concat(concat2(concat1("
		SELECT meta_key
		FROM ",$wpdb[0]->postmeta),"
		GROUP BY meta_key
		HAVING meta_key NOT LIKE '\_%'
		ORDER BY LOWER(meta_key)
		LIMIT "),$limit));
if ( $keys[0])
 Aspis_natcasesort($keys);
;
?>
<p><strong><?php _e(array('Add new custom field:',false));
?></strong></p>
<table id="newmeta">
<thead>
<tr>
<th class="left"><label for="metakeyselect"><?php _e(array('Name',false));
?></label></th>
<th><label for="metavalue"><?php _e(array('Value',false));
?></label></th>
</tr>
</thead>

<tbody>
<tr>
<td id="newmetaleft" class="left">
<?php if ( $keys[0])
 {;
?>
<select id="metakeyselect" name="metakeyselect" tabindex="7">
<option value="#NONE#"><?php _e(array('- Select -',false));
;
?></option>
<?php foreach ( $keys[0] as $key  )
{$key = esc_attr($key);
echo AspisCheckPrint(concat(concat1("\n<option value='",esc_attr($key)),concat2(concat1("'>",$key),"</option>")));
};
?>
</select>
<input class="hide-if-js" type="text" id="metakeyinput" name="metakeyinput" tabindex="7" value="" />
<a href="#postcustomstuff" class="hide-if-no-js" onclick="jQuery('#metakeyinput, #metakeyselect, #enternew, #cancelnew').toggle();return false;">
<span id="enternew"><?php _e(array('Enter new',false));
;
?></span>
<span id="cancelnew" class="hidden"><?php _e(array('Cancel',false));
;
?></span></a>
<?php }else 
{{;
?>
<input type="text" id="metakeyinput" name="metakeyinput" tabindex="7" value="" />
<?php }};
?>
</td>
<td><textarea id="metavalue" name="metavalue" rows="2" cols="25" tabindex="8"></textarea></td>
</tr>

<tr><td colspan="2" class="submit">
<input type="submit" id="addmetasub" name="addmeta" class="add:the-list:newmeta" tabindex="9" value="<?php esc_attr_e(array('Add Custom Field',false));
?>" />
<?php wp_nonce_field(array('add-meta',false),array('_ajax_nonce',false),array(false,false));
;
?>
</td></tr>
</tbody>
</table>
<?php  }
function touch_time ( $edit = array(1,false),$for_post = array(1,false),$tab_index = array(0,false),$multi = array(0,false) ) {
global $wp_locale,$post,$comment;
if ( $for_post[0])
 $edit = (deAspis(Aspis_in_array($post[0]->post_status,array(array(array('draft',false),array('pending',false)),false))) && ((denot_boolean($post[0]->post_date_gmt)) || (('0000-00-00 00:00:00') == $post[0]->post_date_gmt[0]))) ? array(false,false) : array(true,false);
$tab_index_attribute = array('',false);
if ( (deAspis(int_cast($tab_index)) > (0)))
 $tab_index_attribute = concat2(concat1(" tabindex=\"",$tab_index),"\"");
$time_adj = array(time() + (deAspis(get_option(array('gmt_offset',false))) * (3600)),false);
$post_date = deAspis(($for_post)) ? $post[0]->post_date : $comment[0]->comment_date;
$jj = deAspis(($edit)) ? mysql2date(array('d',false),$post_date,array(false,false)) : attAspis(gmdate(('d'),$time_adj[0]));
$mm = deAspis(($edit)) ? mysql2date(array('m',false),$post_date,array(false,false)) : attAspis(gmdate(('m'),$time_adj[0]));
$aa = deAspis(($edit)) ? mysql2date(array('Y',false),$post_date,array(false,false)) : attAspis(gmdate(('Y'),$time_adj[0]));
$hh = deAspis(($edit)) ? mysql2date(array('H',false),$post_date,array(false,false)) : attAspis(gmdate(('H'),$time_adj[0]));
$mn = deAspis(($edit)) ? mysql2date(array('i',false),$post_date,array(false,false)) : attAspis(gmdate(('i'),$time_adj[0]));
$ss = deAspis(($edit)) ? mysql2date(array('s',false),$post_date,array(false,false)) : attAspis(gmdate(('s'),$time_adj[0]));
$cur_jj = attAspis(gmdate(('d'),$time_adj[0]));
$cur_mm = attAspis(gmdate(('m'),$time_adj[0]));
$cur_aa = attAspis(gmdate(('Y'),$time_adj[0]));
$cur_hh = attAspis(gmdate(('H'),$time_adj[0]));
$cur_mn = attAspis(gmdate(('i'),$time_adj[0]));
$month = concat(concat1("<select ",($multi[0] ? array('',false) : array('id="mm" ',false))),concat2(concat1("name=\"mm\"",$tab_index_attribute),">\n"));
for ( $i = array(1,false) ; ($i[0] < (13)) ; $i = array($i[0] + (1),false) )
{$month = concat($month,concat2(concat(concat12("\t\t\t",'<option value="'),zeroise($i,array(2,false))),'"'));
if ( ($i[0] == $mm[0]))
 $month = concat2($month,' selected="selected"');
$month = concat($month,concat2(concat1('>',$wp_locale[0]->get_month_abbrev($wp_locale[0]->get_month($i))),"</option>\n"));
}$month = concat2($month,'</select>');
$day = concat2(concat(concat2(concat(concat2(concat1('<input type="text" ',($multi[0] ? array('',false) : array('id="jj" ',false))),'name="jj" value="'),$jj),'" size="2" maxlength="2"'),$tab_index_attribute),' autocomplete="off" />');
$year = concat2(concat(concat2(concat(concat2(concat1('<input type="text" ',($multi[0] ? array('',false) : array('id="aa" ',false))),'name="aa" value="'),$aa),'" size="4" maxlength="4"'),$tab_index_attribute),' autocomplete="off" />');
$hour = concat2(concat(concat2(concat(concat2(concat1('<input type="text" ',($multi[0] ? array('',false) : array('id="hh" ',false))),'name="hh" value="'),$hh),'" size="2" maxlength="2"'),$tab_index_attribute),' autocomplete="off" />');
$minute = concat2(concat(concat2(concat(concat2(concat1('<input type="text" ',($multi[0] ? array('',false) : array('id="mn" ',false))),'name="mn" value="'),$mn),'" size="2" maxlength="2"'),$tab_index_attribute),' autocomplete="off" />');
echo AspisCheckPrint(array('<div class="timestamp-wrap">',false));
printf(deAspis(__(array('%1$s%2$s, %3$s @ %4$s : %5$s',false))),deAspisRC($month),deAspisRC($day),deAspisRC($year),deAspisRC($hour),deAspisRC($minute));
echo AspisCheckPrint(concat2(concat1('</div><input type="hidden" id="ss" name="ss" value="',$ss),'" />'));
if ( $multi[0])
 return ;
echo AspisCheckPrint(array("\n\n",false));
foreach ( (array(array('mm',false),array('jj',false),array('aa',false),array('hh',false),array('mn',false))) as $timeunit  )
{echo AspisCheckPrint(concat2(concat2(concat(concat2(concat(concat2(concat1('<input type="hidden" id="hidden_',$timeunit),'" name="hidden_'),$timeunit),'" value="'),${$timeunit[0]}),'" />'),"\n"));
$cur_timeunit = concat1('cur_',$timeunit);
echo AspisCheckPrint(concat2(concat2(concat(concat2(concat(concat2(concat1('<input type="hidden" id="',$cur_timeunit),'" name="'),$cur_timeunit),'" value="'),${$cur_timeunit[0]}),'" />'),"\n"));
};
?>

<p>
<a href="#edit_timestamp" class="save-timestamp hide-if-no-js button"><?php _e(array('OK',false));
;
?></a>
<a href="#edit_timestamp" class="cancel-timestamp hide-if-no-js"><?php _e(array('Cancel',false));
;
?></a>
</p>
<?php  }
function page_template_dropdown ( $default = array('',false) ) {
$templates = get_page_templates();
Aspis_ksort($templates);
foreach ( deAspis(attAspisRC(array_keys(deAspisRC($templates)))) as $template  )
{if ( ($default[0] == deAspis(attachAspis($templates,$template[0]))))
 $selected = array(" selected='selected'",false);
else 
{$selected = array('',false);
}echo AspisCheckPrint(concat(concat1("\n\t<option value='",attachAspis($templates,$template[0])),concat2(concat(concat2(concat1("' ",$selected),">"),$template),"</option>")));
} }
function parent_dropdown ( $default = array(0,false),$parent = array(0,false),$level = array(0,false) ) {
global $wpdb,$post_ID;
$items = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT ID, post_parent, post_title FROM ",$wpdb[0]->posts)," WHERE post_parent = %d AND post_type = 'page' ORDER BY menu_order"),$parent));
if ( $items[0])
 {foreach ( $items[0] as $item  )
{if ( (!((empty($post_ID) || Aspis_empty( $post_ID)))))
 {if ( ($item[0]->ID[0] == $post_ID[0]))
 {continue ;
}}$pad = Aspis_str_repeat(array('&nbsp;',false),array($level[0] * (3),false));
if ( ($item[0]->ID[0] == $default[0]))
 $current = array(' selected="selected"',false);
else 
{$current = array('',false);
}echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("\n\t<option class='level-",$level),"' value='"),$item[0]->ID),"'"),$current),">"),$pad)," "),esc_html($item[0]->post_title)),"</option>"));
parent_dropdown($default,$item[0]->ID,array($level[0] + (1),false));
}}else 
{{return array(false,false);
}} }
function browse_happy (  ) {
$getit = __(array('WordPress recommends a better browser',false));
echo AspisCheckPrint(concat2(concat1('
		<div id="bh"><a href="http://browsehappy.com/" title="',$getit),'"><img src="images/browse-happy.gif" alt="Browse Happy" /></a></div>
'));
 }
function the_attachment_links ( $id = array(false,false) ) {
$id = int_cast($id);
$post = &get_post($id);
if ( ($post[0]->post_type[0] != ('attachment')))
 return array(false,false);
$icon = get_attachment_icon($post[0]->ID);
$attachment_data = wp_get_attachment_metadata($id);
$thumb = array((isset($attachment_data[0][('thumb')]) && Aspis_isset( $attachment_data [0][('thumb')])),false);
;
?>
<form id="the-attachment-links">
<table>
	<col />
	<col class="widefat" />
	<tr>
		<th scope="row"><?php _e(array('URL',false));
?></th>
		<td><textarea rows="1" cols="40" type="text" class="attachmentlinks" readonly="readonly"><?php echo AspisCheckPrint(wp_get_attachment_url());
;
?></textarea></td>
	</tr>
<?php if ( $icon[0])
 {;
?>
	<tr>
		<th scope="row"><?php $thumb[0] ? _e(array('Thumbnail linked to file',false)) : _e(array('Image linked to file',false));
;
?></th>
		<td><textarea rows="1" cols="40" type="text" class="attachmentlinks" readonly="readonly"><a href="<?php echo AspisCheckPrint(wp_get_attachment_url());
;
?>"><?php echo AspisCheckPrint($icon);
?></a></textarea></td>
	</tr>
	<tr>
		<th scope="row"><?php $thumb[0] ? _e(array('Thumbnail linked to page',false)) : _e(array('Image linked to page',false));
;
?></th>
		<td><textarea rows="1" cols="40" type="text" class="attachmentlinks" readonly="readonly"><a href="<?php echo AspisCheckPrint(get_attachment_link($post[0]->ID));
?>" rel="attachment wp-att-<?php echo AspisCheckPrint($post[0]->ID);
;
?>"><?php echo AspisCheckPrint($icon);
?></a></textarea></td>
	</tr>
<?php }else 
{;
?>
	<tr>
		<th scope="row"><?php _e(array('Link to file',false));
?></th>
		<td><textarea rows="1" cols="40" type="text" class="attachmentlinks" readonly="readonly"><a href="<?php echo AspisCheckPrint(wp_get_attachment_url());
;
?>" class="attachmentlink"><?php echo AspisCheckPrint(Aspis_basename(wp_get_attachment_url()));
;
?></a></textarea></td>
	</tr>
	<tr>
		<th scope="row"><?php _e(array('Link to page',false));
?></th>
		<td><textarea rows="1" cols="40" type="text" class="attachmentlinks" readonly="readonly"><a href="<?php echo AspisCheckPrint(get_attachment_link($post[0]->ID));
?>" rel="attachment wp-att-<?php echo AspisCheckPrint($post[0]->ID);
?>"><?php the_title();
;
?></a></textarea></td>
	</tr>
<?php };
?>
</table>
</form>
<?php  }
function wp_dropdown_roles ( $selected = array(false,false) ) {
global $wp_roles;
$p = array('',false);
$r = array('',false);
$editable_roles = get_editable_roles();
foreach ( $editable_roles[0] as $role =>$details )
{restoreTaint($role,$details);
{$name = translate_user_role($details[0]['name']);
if ( ($selected[0] == $role[0]))
 $p = concat(concat1("\n\t<option selected='selected' value='",esc_attr($role)),concat2(concat1("'>",$name),"</option>"));
else 
{$r = concat($r,concat(concat1("\n\t<option value='",esc_attr($role)),concat2(concat1("'>",$name),"</option>")));
}}}echo AspisCheckPrint(concat($p,$r));
 }
function wp_convert_hr_to_bytes ( $size ) {
$size = Aspis_strtolower($size);
$bytes = int_cast($size);
if ( (strpos($size[0],'k') !== false))
 $bytes = array(deAspis(Aspis_intval($size)) * (1024),false);
elseif ( (strpos($size[0],'m') !== false))
 $bytes = array((deAspis(Aspis_intval($size)) * (1024)) * (1024),false);
elseif ( (strpos($size[0],'g') !== false))
 $bytes = array(((deAspis(Aspis_intval($size)) * (1024)) * (1024)) * (1024),false);
return $bytes;
 }
function wp_convert_bytes_to_hr ( $bytes ) {
$units = array(array(0 => array('B',false,false),1 => array('kB',false,false),2 => array('MB',false,false),3 => array('GB',false,false)),false);
$log = attAspis(log($bytes[0],(1024)));
$power = int_cast($log);
$size = Aspis_pow(array(1024,false),array($log[0] - $power[0],false));
return concat($size,attachAspis($units,$power[0]));
 }
function wp_max_upload_size (  ) {
$u_bytes = wp_convert_hr_to_bytes(array(ini_get('upload_max_filesize'),false));
$p_bytes = wp_convert_hr_to_bytes(array(ini_get('post_max_size'),false));
$bytes = apply_filters(array('upload_size_limit',false),attAspisRC(min(deAspisRC($u_bytes),deAspisRC($p_bytes))),$u_bytes,$p_bytes);
return $bytes;
 }
function wp_import_upload_form ( $action ) {
$bytes = apply_filters(array('import_upload_size_limit',false),wp_max_upload_size());
$size = wp_convert_bytes_to_hr($bytes);
$upload_dir = wp_upload_dir();
if ( (!((empty($upload_dir[0][('error')]) || Aspis_empty( $upload_dir [0][('error')])))))
 {;
?><div class="error"><p><?php _e(array('Before you can upload your import file, you will need to fix the following error:',false));
;
?></p>
		<p><strong><?php echo AspisCheckPrint($upload_dir[0]['error']);
;
?></strong></p></div><?php }else 
{;
?>
<form enctype="multipart/form-data" id="import-upload-form" method="post" action="<?php echo AspisCheckPrint(esc_attr(wp_nonce_url($action,array('import-upload',false))));
;
?>">
<p>
<label for="upload"><?php _e(array('Choose a file from your computer:',false));
;
?></label> (<?php printf(deAspis(__(array('Maximum size: %s',false))),deAspisRC($size));
;
?>)
<input type="file" id="upload" name="import" size="25" />
<input type="hidden" name="action" value="save" />
<input type="hidden" name="max_file_size" value="<?php echo AspisCheckPrint($bytes);
;
?>" />
</p>
<p class="submit">
<input type="submit" class="button" value="<?php esc_attr_e(array('Upload file and import',false));
;
?>" />
</p>
</form>
<?php } }
function wp_remember_old_slug (  ) {
global $post;
$name = esc_attr($post[0]->post_name);
if ( strlen($name[0]))
 echo AspisCheckPrint(concat2(concat1('<input type="hidden" id="wp-old-slug" name="wp-old-slug" value="',$name),'" />'));
 }
function add_meta_box ( $id,$title,$callback,$page,$context = array('advanced',false),$priority = array('default',false),$callback_args = array(null,false) ) {
global $wp_meta_boxes;
if ( (!((isset($wp_meta_boxes) && Aspis_isset( $wp_meta_boxes)))))
 $wp_meta_boxes = array(array(),false);
if ( (!((isset($wp_meta_boxes[0][$page[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]])))))
 arrayAssign($wp_meta_boxes[0],deAspis(registerTaint($page)),addTaint(array(array(),false)));
if ( (!((isset($wp_meta_boxes[0][$page[0]][0][$context[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]] [0][$context[0]])))))
 arrayAssign($wp_meta_boxes[0][$page[0]][0],deAspis(registerTaint($context)),addTaint(array(array(),false)));
foreach ( deAspis(attAspisRC(array_keys(deAspisRC(attachAspis($wp_meta_boxes,$page[0]))))) as $a_context  )
{foreach ( (array(array('high',false),array('core',false),array('default',false),array('low',false))) as $a_priority  )
{if ( (!((isset($wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][$a_priority[0]][0][$id[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]] [0][$a_context[0]] [0][$a_priority[0]] [0][$id[0]])))))
 continue ;
if ( (('core') == $priority[0]))
 {if ( (false === deAspis(attachAspis($wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][$a_priority[0]],$id[0]))))
 return ;
if ( (('default') == $a_priority[0]))
 {arrayAssign($wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][('core')][0],deAspis(registerTaint($id)),addTaint(attachAspis($wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][('default')],$id[0])));
unset($wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][('default')][0][$id[0]]);
}return ;
}if ( ((empty($priority) || Aspis_empty( $priority))))
 {$priority = $a_priority;
}elseif ( (('sorted') == $priority[0]))
 {$title = $wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][$a_priority[0]][0][$id[0]][0]['title'];
$callback = $wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][$a_priority[0]][0][$id[0]][0]['callback'];
$callback_args = $wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][$a_priority[0]][0][$id[0]][0]['args'];
}if ( (($priority[0] != $a_priority[0]) || ($context[0] != $a_context[0])))
 unset($wp_meta_boxes[0][$page[0]][0][$a_context[0]][0][$a_priority[0]][0][$id[0]]);
}}if ( ((empty($priority) || Aspis_empty( $priority))))
 $priority = array('low',false);
if ( (!((isset($wp_meta_boxes[0][$page[0]][0][$context[0]][0][$priority[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]] [0][$context[0]] [0][$priority[0]])))))
 arrayAssign($wp_meta_boxes[0][$page[0]][0][$context[0]][0],deAspis(registerTaint($priority)),addTaint(array(array(),false)));
arrayAssign($wp_meta_boxes[0][$page[0]][0][$context[0]][0][$priority[0]][0],deAspis(registerTaint($id)),addTaint(array(array(deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('title',false)) => addTaint($title),deregisterTaint(array('callback',false)) => addTaint($callback),deregisterTaint(array('args',false)) => addTaint($callback_args)),false)));
 }
function do_meta_boxes ( $page,$context,$object ) {
global $wp_meta_boxes;
static $already_sorted = array(false,false);
$hidden = get_hidden_meta_boxes($page);
echo AspisCheckPrint(concat2(concat1("<div id='",$context),"-sortables' class='meta-box-sortables'>\n"));
$i = array(0,false);
do {if ( ((denot_boolean($already_sorted)) && deAspis($sorted = get_user_option(concat1("meta-box-order_",$page),array(0,false),array(false,false)))))
 {foreach ( $sorted[0] as $box_context =>$ids )
{restoreTaint($box_context,$ids);
foreach ( deAspis(Aspis_explode(array(',',false),$ids)) as $id  )
if ( $id[0])
 add_meta_box($id,array(null,false),array(null,false),$page,$box_context,array('sorted',false));
}}$already_sorted = array(true,false);
if ( (((!((isset($wp_meta_boxes) && Aspis_isset( $wp_meta_boxes)))) || (!((isset($wp_meta_boxes[0][$page[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]]))))) || (!((isset($wp_meta_boxes[0][$page[0]][0][$context[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]] [0][$context[0]]))))))
 break ;
foreach ( (array(array('high',false),array('sorted',false),array('core',false),array('default',false),array('low',false))) as $priority  )
{if ( ((isset($wp_meta_boxes[0][$page[0]][0][$context[0]][0][$priority[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]] [0][$context[0]] [0][$priority[0]]))))
 {foreach ( deAspis(array_cast(attachAspis($wp_meta_boxes[0][$page[0]][0][$context[0]],$priority[0]))) as $box  )
{if ( ((false == $box[0]) || (denot_boolean($box[0]['title']))))
 continue ;
postincr($i);
$style = array('',false);
if ( deAspis(Aspis_in_array($box[0]['id'],$hidden)))
 $style = array('style="display:none;"',false);
echo AspisCheckPrint(concat2(concat2(concat(concat2(concat(concat2(concat1('<div id="',$box[0]['id']),'" class="postbox '),postbox_classes($box[0]['id'],$page)),'" '),$style),'>'),"\n"));
echo AspisCheckPrint(concat2(concat1('<div class="handlediv" title="',__(array('Click to toggle',false))),'"><br /></div>'));
echo AspisCheckPrint(concat2(concat1("<h3 class='hndle'><span>",$box[0]['title']),"</span></h3>\n"));
echo AspisCheckPrint(concat12('<div class="inside">',"\n"));
Aspis_call_user_func($box[0]['callback'],$object,$box);
echo AspisCheckPrint(array("</div>\n",false));
echo AspisCheckPrint(array("</div>\n",false));
}}}}while ((0) )
;
echo AspisCheckPrint(array("</div>",false));
return $i;
 }
function remove_meta_box ( $id,$page,$context ) {
global $wp_meta_boxes;
if ( (!((isset($wp_meta_boxes) && Aspis_isset( $wp_meta_boxes)))))
 $wp_meta_boxes = array(array(),false);
if ( (!((isset($wp_meta_boxes[0][$page[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]])))))
 arrayAssign($wp_meta_boxes[0],deAspis(registerTaint($page)),addTaint(array(array(),false)));
if ( (!((isset($wp_meta_boxes[0][$page[0]][0][$context[0]]) && Aspis_isset( $wp_meta_boxes [0][$page[0]] [0][$context[0]])))))
 arrayAssign($wp_meta_boxes[0][$page[0]][0],deAspis(registerTaint($context)),addTaint(array(array(),false)));
foreach ( (array(array('high',false),array('core',false),array('default',false),array('low',false))) as $priority  )
arrayAssign($wp_meta_boxes[0][$page[0]][0][$context[0]][0][$priority[0]][0],deAspis(registerTaint($id)),addTaint(array(false,false)));
 }
function meta_box_prefs ( $page ) {
global $wp_meta_boxes;
if ( ((empty($wp_meta_boxes[0][$page[0]]) || Aspis_empty( $wp_meta_boxes [0][$page[0]]))))
 return ;
$hidden = get_hidden_meta_boxes($page);
foreach ( deAspis(attAspisRC(array_keys(deAspisRC(attachAspis($wp_meta_boxes,$page[0]))))) as $context  )
{foreach ( deAspis(attAspisRC(array_keys(deAspisRC(attachAspis($wp_meta_boxes[0][$page[0]],$context[0]))))) as $priority  )
{foreach ( deAspis(attachAspis($wp_meta_boxes[0][$page[0]][0][$context[0]],$priority[0])) as $box  )
{if ( ((false == $box[0]) || (denot_boolean($box[0]['title']))))
 continue ;
if ( ((('submitdiv') == deAspis($box[0]['id'])) || (('linksubmitdiv') == deAspis($box[0]['id']))))
 continue ;
$box_id = $box[0]['id'];
echo AspisCheckPrint(concat2(concat1('<label for="',$box_id),'-hide">'));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<input class="hide-postbox-tog" name="',$box_id),'-hide" type="checkbox" id="'),$box_id),'-hide" value="'),$box_id),'"'),((denot_boolean(Aspis_in_array($box_id,$hidden))) ? array(' checked="checked"',false) : array('',false))),' />'));
echo AspisCheckPrint(concat2($box[0]['title'],"</label>\n"));
}}} }
function get_hidden_meta_boxes ( $page ) {
$hidden = array_cast(get_user_option(concat1("meta-box-hidden_",$page),array(0,false),array(false,false)));
if ( ((empty($hidden[0][(0)]) || Aspis_empty( $hidden [0][(0)]))))
 {$hidden = array(array(array('slugdiv',false)),false);
}return $hidden;
 }
function add_settings_section ( $id,$title,$callback,$page ) {
global $wp_settings_sections;
if ( (!((isset($wp_settings_sections) && Aspis_isset( $wp_settings_sections)))))
 $wp_settings_sections = array(array(),false);
if ( (!((isset($wp_settings_sections[0][$page[0]]) && Aspis_isset( $wp_settings_sections [0][$page[0]])))))
 arrayAssign($wp_settings_sections[0],deAspis(registerTaint($page)),addTaint(array(array(),false)));
if ( (!((isset($wp_settings_sections[0][$page[0]][0][$id[0]]) && Aspis_isset( $wp_settings_sections [0][$page[0]] [0][$id[0]])))))
 arrayAssign($wp_settings_sections[0][$page[0]][0],deAspis(registerTaint($id)),addTaint(array(array(),false)));
arrayAssign($wp_settings_sections[0][$page[0]][0],deAspis(registerTaint($id)),addTaint(array(array(deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('title',false)) => addTaint($title),deregisterTaint(array('callback',false)) => addTaint($callback)),false)));
 }
function add_settings_field ( $id,$title,$callback,$page,$section = array('default',false),$args = array(array(),false) ) {
global $wp_settings_fields;
if ( (!((isset($wp_settings_fields) && Aspis_isset( $wp_settings_fields)))))
 $wp_settings_fields = array(array(),false);
if ( (!((isset($wp_settings_fields[0][$page[0]]) && Aspis_isset( $wp_settings_fields [0][$page[0]])))))
 arrayAssign($wp_settings_fields[0],deAspis(registerTaint($page)),addTaint(array(array(),false)));
if ( (!((isset($wp_settings_fields[0][$page[0]][0][$section[0]]) && Aspis_isset( $wp_settings_fields [0][$page[0]] [0][$section[0]])))))
 arrayAssign($wp_settings_fields[0][$page[0]][0],deAspis(registerTaint($section)),addTaint(array(array(),false)));
arrayAssign($wp_settings_fields[0][$page[0]][0][$section[0]][0],deAspis(registerTaint($id)),addTaint(array(array(deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('title',false)) => addTaint($title),deregisterTaint(array('callback',false)) => addTaint($callback),deregisterTaint(array('args',false)) => addTaint($args)),false)));
 }
function do_settings_sections ( $page ) {
global $wp_settings_sections,$wp_settings_fields;
if ( ((!((isset($wp_settings_sections) && Aspis_isset( $wp_settings_sections)))) || (!((isset($wp_settings_sections[0][$page[0]]) && Aspis_isset( $wp_settings_sections [0][$page[0]]))))))
 return ;
foreach ( deAspis(array_cast(attachAspis($wp_settings_sections,$page[0]))) as $section  )
{echo AspisCheckPrint(concat2(concat1("<h3>",$section[0]['title']),"</h3>\n"));
Aspis_call_user_func($section[0]['callback'],$section);
if ( (((!((isset($wp_settings_fields) && Aspis_isset( $wp_settings_fields)))) || (!((isset($wp_settings_fields[0][$page[0]]) && Aspis_isset( $wp_settings_fields [0][$page[0]]))))) || (!((isset($wp_settings_fields[0][$page[0]][0][deAspis($section[0]['id'])]) && Aspis_isset( $wp_settings_fields [0][$page[0]] [0][deAspis($section [0]['id'])]))))))
 continue ;
echo AspisCheckPrint(array('<table class="form-table">',false));
do_settings_fields($page,$section[0]['id']);
echo AspisCheckPrint(array('</table>',false));
} }
function do_settings_fields ( $page,$section ) {
global $wp_settings_fields;
if ( (((!((isset($wp_settings_fields) && Aspis_isset( $wp_settings_fields)))) || (!((isset($wp_settings_fields[0][$page[0]]) && Aspis_isset( $wp_settings_fields [0][$page[0]]))))) || (!((isset($wp_settings_fields[0][$page[0]][0][$section[0]]) && Aspis_isset( $wp_settings_fields [0][$page[0]] [0][$section[0]]))))))
 return ;
foreach ( deAspis(array_cast(attachAspis($wp_settings_fields[0][$page[0]],$section[0]))) as $field  )
{echo AspisCheckPrint(array('<tr valign="top">',false));
if ( (!((empty($field[0][('args')][0][('label_for')]) || Aspis_empty( $field [0][('args')] [0][('label_for')])))))
 echo AspisCheckPrint(concat2(concat(concat2(concat1('<th scope="row"><label for="',$field[0][('args')][0]['label_for']),'">'),$field[0]['title']),'</label></th>'));
else 
{echo AspisCheckPrint(concat2(concat1('<th scope="row">',$field[0]['title']),'</th>'));
}echo AspisCheckPrint(array('<td>',false));
Aspis_call_user_func($field[0]['callback'],$field[0]['args']);
echo AspisCheckPrint(array('</td>',false));
echo AspisCheckPrint(array('</tr>',false));
} }
function manage_columns_prefs ( $page ) {
$columns = get_column_headers($page);
$hidden = get_hidden_columns($page);
foreach ( $columns[0] as $column =>$title )
{restoreTaint($column,$title);
{if ( ((((((('cb') == $column[0]) || (('title') == $column[0])) || (('name') == $column[0])) || (('username') == $column[0])) || (('media') == $column[0])) || (('comment') == $column[0])))
 continue ;
if ( ((empty($title) || Aspis_empty( $title))))
 continue ;
if ( (('comments') == $column[0]))
 $title = __(array('Comments',false));
$id = concat2($column,"-hide");
echo AspisCheckPrint(concat2(concat1('<label for="',$id),'">'));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<input class="hide-column-tog" name="',$id),'" type="checkbox" id="'),$id),'" value="'),$column),'"'),((denot_boolean(Aspis_in_array($column,$hidden))) ? array(' checked="checked"',false) : array('',false))),' />'));
echo AspisCheckPrint(concat2($title,"</label>\n"));
}} }
function find_posts_div ( $found_action = array('',false) ) {
;
?>
	<div id="find-posts" class="find-box" style="display:none;">
		<div id="find-posts-head" class="find-box-head"><?php _e(array('Find Posts or Pages',false));
;
?></div>
		<div class="find-box-inside">
			<div class="find-box-search">
				<?php if ( $found_action[0])
 {;
?>
					<input type="hidden" name="found_action" value="<?php echo AspisCheckPrint(esc_attr($found_action));
;
?>" />
				<?php };
?>

				<input type="hidden" name="affected" id="affected" value="" />
				<?php wp_nonce_field(array('find-posts',false),array('_ajax_nonce',false),array(false,false));
;
?>
				<label class="screen-reader-text" for="find-posts-input"><?php _e(array('Search',false));
;
?></label>
				<input type="text" id="find-posts-input" name="ps" value="" />
				<input type="button" onclick="findPosts.send();" value="<?php esc_attr_e(array('Search',false));
;
?>" class="button" /><br />

				<input type="radio" name="find-posts-what" id="find-posts-posts" checked="checked" value="posts" />
				<label for="find-posts-posts"><?php _e(array('Posts',false));
;
?></label>
				<input type="radio" name="find-posts-what" id="find-posts-pages" value="pages" />
				<label for="find-posts-pages"><?php _e(array('Pages',false));
;
?></label>
			</div>
			<div id="find-posts-response"></div>
		</div>
		<div class="find-box-buttons">
			<input type="button" class="button alignleft" onclick="findPosts.close();" value="<?php esc_attr_e(array('Close',false));
;
?>" />
			<input id="find-posts-submit" type="submit" class="button-primary alignright" value="<?php esc_attr_e(array('Select',false));
;
?>" />
		</div>
	</div>
<?php  }
function the_post_password (  ) {
global $post;
if ( ((isset($post[0]->post_password) && Aspis_isset( $post[0] ->post_password ))))
 echo AspisCheckPrint(esc_attr($post[0]->post_password));
 }
function favorite_actions ( $screen = array(null,false) ) {
switch ( $screen[0] ) {
case ('post-new.php'):$default_action = array(array('edit.php' => array(array(__(array('Edit Posts',false)),array('edit_posts',false)),false,false)),false);
break ;
case ('edit-pages.php'):$default_action = array(array('page-new.php' => array(array(__(array('New Page',false)),array('edit_pages',false)),false,false)),false);
break ;
case ('page-new.php'):$default_action = array(array('edit-pages.php' => array(array(__(array('Edit Pages',false)),array('edit_pages',false)),false,false)),false);
break ;
case ('upload.php'):$default_action = array(array('media-new.php' => array(array(__(array('New Media',false)),array('upload_files',false)),false,false)),false);
break ;
case ('media-new.php'):$default_action = array(array('upload.php' => array(array(__(array('Edit Media',false)),array('upload_files',false)),false,false)),false);
break ;
case ('link-manager.php'):$default_action = array(array('link-add.php' => array(array(__(array('New Link',false)),array('manage_links',false)),false,false)),false);
break ;
case ('link-add.php'):$default_action = array(array('link-manager.php' => array(array(__(array('Edit Links',false)),array('manage_links',false)),false,false)),false);
break ;
case ('users.php'):$default_action = array(array('user-new.php' => array(array(__(array('New User',false)),array('create_users',false)),false,false)),false);
break ;
case ('user-new.php'):$default_action = array(array('users.php' => array(array(__(array('Edit Users',false)),array('edit_users',false)),false,false)),false);
break ;
case ('plugins.php'):$default_action = array(array('plugin-install.php' => array(array(__(array('Install Plugins',false)),array('install_plugins',false)),false,false)),false);
break ;
case ('plugin-install.php'):$default_action = array(array('plugins.php' => array(array(__(array('Manage Plugins',false)),array('activate_plugins',false)),false,false)),false);
break ;
case ('themes.php'):$default_action = array(array('theme-install.php' => array(array(__(array('Install Themes',false)),array('install_themes',false)),false,false)),false);
break ;
case ('theme-install.php'):$default_action = array(array('themes.php' => array(array(__(array('Manage Themes',false)),array('switch_themes',false)),false,false)),false);
break ;
default :$default_action = array(array('post-new.php' => array(array(__(array('New Post',false)),array('edit_posts',false)),false,false)),false);
break ;
 }
$actions = array(array('post-new.php' => array(array(__(array('New Post',false)),array('edit_posts',false)),false,false),'edit.php?post_status=draft' => array(array(__(array('Drafts',false)),array('edit_posts',false)),false,false),'page-new.php' => array(array(__(array('New Page',false)),array('edit_pages',false)),false,false),'media-new.php' => array(array(__(array('Upload',false)),array('upload_files',false)),false,false),'edit-comments.php' => array(array(__(array('Comments',false)),array('moderate_comments',false)),false,false)),false);
$default_key = attAspisRC(array_keys(deAspisRC($default_action)));
$default_key = attachAspis($default_key,(0));
if ( ((isset($actions[0][$default_key[0]]) && Aspis_isset( $actions [0][$default_key[0]]))))
 unset($actions[0][$default_key[0]]);
$actions = Aspis_array_merge($default_action,$actions);
$actions = apply_filters(array('favorite_actions',false),$actions);
$allowed_actions = array(array(),false);
foreach ( $actions[0] as $action =>$data )
{restoreTaint($action,$data);
{if ( deAspis(current_user_can(attachAspis($data,(1)))))
 arrayAssign($allowed_actions[0],deAspis(registerTaint($action)),addTaint(attachAspis($data,(0))));
}}if ( ((empty($allowed_actions) || Aspis_empty( $allowed_actions))))
 return ;
$first = attAspisRC(array_keys(deAspisRC($allowed_actions)));
$first = attachAspis($first,(0));
echo AspisCheckPrint(array('<div id="favorite-actions">',false));
echo AspisCheckPrint(concat2(concat(concat2(concat1('<div id="favorite-first"><a href="',$first),'">'),attachAspis($allowed_actions,$first[0])),'</a></div><div id="favorite-toggle"><br /></div>'));
echo AspisCheckPrint(array('<div id="favorite-inside">',false));
Aspis_array_shift($allowed_actions);
foreach ( $allowed_actions[0] as $action =>$label )
{restoreTaint($action,$label);
{echo AspisCheckPrint(concat2(concat1("<div class='favorite-action'><a href='",$action),"'>"));
echo AspisCheckPrint($label);
echo AspisCheckPrint(array("</a></div>\n",false));
}}echo AspisCheckPrint(array("</div></div>\n",false));
 }
function _draft_or_post_title ( $post_id = array(0,false) ) {
$title = get_the_title($post_id);
if ( ((empty($title) || Aspis_empty( $title))))
 $title = __(array('(no title)',false));
return $title;
 }
function _admin_search_query (  ) {
echo AspisCheckPrint(((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) ? esc_attr(Aspis_stripslashes($_GET[0]['s'])) : array('',false));
 }
function iframe_header ( $title = array('',false),$limit_styles = array(false,false) ) {
;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action(array('admin_xml_ns',false));
;
?> <?php language_attributes();
;
?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php echo AspisCheckPrint(get_option(array('blog_charset',false)));
;
?>" />
<title><?php bloginfo(array('name',false));
?> &rsaquo; <?php echo AspisCheckPrint($title);
?> &#8212; <?php _e(array('WordPress',false));
;
?></title>
<?php wp_enqueue_style(array('global',false));
if ( (denot_boolean($limit_styles)))
 wp_enqueue_style(array('wp-admin',false));
wp_enqueue_style(array('colors',false));
;
?>
<script type="text/javascript">
//<![CDATA[
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
function tb_close(){var win=window.dialogArguments||opener||parent||top;win.tb_remove();}
//]]>
</script>
<?php do_action(array('admin_print_styles',false));
do_action(array('admin_print_scripts',false));
do_action(array('admin_head',false));
;
?>
</head>
<body<?php if ( ((isset($GLOBALS[0][('body_id')]) && Aspis_isset( $GLOBALS [0][('body_id')]))))
 echo AspisCheckPrint(concat2(concat1(' id="',$GLOBALS[0]['body_id']),'"'));
;
?>>
<?php  }
function iframe_footer (  ) {
;
?>
	<div class="hidden">
<?php do_action(array('admin_footer',false),array('',false));
do_action(array('admin_print_footer_scripts',false));
;
?>
	</div>
<script type="text/javascript">if(typeof wpOnload=="function")wpOnload();</script>
</body>
</html>
<?php  }
function _post_states ( $post ) {
$post_states = array(array(),false);
if ( ((isset($_GET[0][('post_status')]) && Aspis_isset( $_GET [0][('post_status')]))))
 $post_status = $_GET[0]['post_status'];
else 
{$post_status = array('',false);
}if ( (!((empty($post[0]->post_password) || Aspis_empty( $post[0] ->post_password )))))
 arrayAssignAdd($post_states[0][],addTaint(__(array('Password protected',false))));
if ( ((('private') == $post[0]->post_status[0]) && (('private') != $post_status[0])))
 arrayAssignAdd($post_states[0][],addTaint(__(array('Private',false))));
if ( ((('draft') == $post[0]->post_status[0]) && (('draft') != $post_status[0])))
 arrayAssignAdd($post_states[0][],addTaint(__(array('Draft',false))));
if ( ((('pending') == $post[0]->post_status[0]) && (('pending') != $post_status[0])))
 arrayAssignAdd($post_states[0][],addTaint(_x(array('Pending',false),array('post state',false))));
if ( deAspis(is_sticky($post[0]->ID)))
 arrayAssignAdd($post_states[0][],addTaint(__(array('Sticky',false))));
$post_states = apply_filters(array('display_post_states',false),$post_states);
if ( (!((empty($post_states) || Aspis_empty( $post_states)))))
 {$state_count = attAspis(count($post_states[0]));
$i = array(0,false);
echo AspisCheckPrint(array(' - ',false));
foreach ( $post_states[0] as $state  )
{preincr($i);
($i[0] == $state_count[0]) ? $sep = array('',false) : $sep = array(', ',false);
echo AspisCheckPrint(concat2(concat(concat1("<span class='post-state'>",$state),$sep),"</span>"));
}} }
function screen_meta ( $screen ) {
global $wp_meta_boxes,$_wp_contextual_help;
$screen = Aspis_str_replace(array('.php',false),array('',false),$screen);
$screen = Aspis_str_replace(array('-new',false),array('',false),$screen);
$screen = Aspis_str_replace(array('-add',false),array('',false),$screen);
$screen = apply_filters(array('screen_meta_screen',false),$screen);
$column_screens = get_column_headers($screen);
$meta_screens = array(array('index' => array('dashboard',false,false)),false);
if ( ((isset($meta_screens[0][$screen[0]]) && Aspis_isset( $meta_screens [0][$screen[0]]))))
 $screen = attachAspis($meta_screens,$screen[0]);
$show_screen = array(false,false);
$show_on_screen = array(false,false);
if ( ((!((empty($wp_meta_boxes[0][$screen[0]]) || Aspis_empty( $wp_meta_boxes [0][$screen[0]])))) || (!((empty($column_screens) || Aspis_empty( $column_screens))))))
 {$show_screen = array(true,false);
$show_on_screen = array(true,false);
}$screen_options = screen_options($screen);
if ( $screen_options[0])
 $show_screen = array(true,false);
if ( (!((isset($_wp_contextual_help) && Aspis_isset( $_wp_contextual_help)))))
 $_wp_contextual_help = array(array(),false);
$settings = array('',false);
switch ( $screen[0] ) {
case ('post'):if ( (!((isset($_wp_contextual_help[0][('post')]) && Aspis_isset( $_wp_contextual_help [0][('post')])))))
 {$help = drag_drop_help();
$help = concat($help,concat2(concat1('<p>',__(array('<a href="http://codex.wordpress.org/Writing_Posts" target="_blank">Writing Posts</a>',false))),'</p>'));
arrayAssign($_wp_contextual_help[0],deAspis(registerTaint(array('post',false))),addTaint($help));
}break ;
case ('page'):if ( (!((isset($_wp_contextual_help[0][('page')]) && Aspis_isset( $_wp_contextual_help [0][('page')])))))
 {$help = drag_drop_help();
arrayAssign($_wp_contextual_help[0],deAspis(registerTaint(array('page',false))),addTaint($help));
}break ;
case ('dashboard'):if ( (!((isset($_wp_contextual_help[0][('dashboard')]) && Aspis_isset( $_wp_contextual_help [0][('dashboard')])))))
 {$help = concat2(concat1('<p>',__(array('The modules on this screen can be arranged in several columns. You can select the number of columns from the Screen Options tab.',false))),"</p>\n");
$help = concat($help,drag_drop_help());
arrayAssign($_wp_contextual_help[0],deAspis(registerTaint(array('dashboard',false))),addTaint($help));
}break ;
case ('link'):if ( (!((isset($_wp_contextual_help[0][('link')]) && Aspis_isset( $_wp_contextual_help [0][('link')])))))
 {$help = drag_drop_help();
arrayAssign($_wp_contextual_help[0],deAspis(registerTaint(array('link',false))),addTaint($help));
}break ;
case ('options-general'):if ( (!((isset($_wp_contextual_help[0][('options-general')]) && Aspis_isset( $_wp_contextual_help [0][('options-general')])))))
 arrayAssign($_wp_contextual_help[0],deAspis(registerTaint(array('options-general',false))),addTaint(__(array('<a href="http://codex.wordpress.org/Settings_General_SubPanel" target="_blank">General Settings</a>',false))));
break ;
case ('theme-install'):case ('plugin-install'):if ( (((!((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')])))) || (('dashboard') == deAspis($_GET[0]['tab']))) && (!((isset($_wp_contextual_help[0][$screen[0]]) && Aspis_isset( $_wp_contextual_help [0][$screen[0]]))))))
 {$help = plugins_search_help();
arrayAssign($_wp_contextual_help[0],deAspis(registerTaint($screen)),addTaint($help));
}break ;
case ('widgets'):if ( (!((isset($_wp_contextual_help[0][('widgets')]) && Aspis_isset( $_wp_contextual_help [0][('widgets')])))))
 {$help = widgets_help();
arrayAssign($_wp_contextual_help[0],deAspis(registerTaint(array('widgets',false))),addTaint($help));
}$settings = concat2(concat(concat2(concat1('<p><a id="access-on" href="widgets.php?widgets-access=on">',__(array('Enable accessibility mode',false))),'</a><a id="access-off" href="widgets.php?widgets-access=off">'),__(array('Disable accessibility mode',false))),"</a></p>\n");
$show_screen = array(true,false);
break ;
 }
;
?>
<div id="screen-meta">
<?php if ( $show_screen[0])
 {;
?>
<div id="screen-options-wrap" class="hidden">
	<form id="adv-settings" action="" method="post">
<?php if ( $show_on_screen[0])
 {;
?>
	<h5><?php _e(array('Show on screen',false));
?></h5>
	<div class="metabox-prefs">
<?php if ( ((denot_boolean(meta_box_prefs($screen))) && ((isset($column_screens) && Aspis_isset( $column_screens)))))
 {manage_columns_prefs($screen);
};
?>
	<br class="clear" />
	</div>
<?php };
?>
<?php echo AspisCheckPrint(screen_layout($screen));
;
?>
<?php echo AspisCheckPrint($screen_options);
;
?>
<?php echo AspisCheckPrint($settings);
;
?>
<div><?php wp_nonce_field(array('screen-options-nonce',false),array('screenoptionnonce',false),array(false,false));
;
?></div>
</form>
</div>

<?php }global $title;
$_wp_contextual_help = apply_filters(array('contextual_help_list',false),$_wp_contextual_help,$screen);
;
?>
	<div id="contextual-help-wrap" class="hidden">
	<?php $contextual_help = array('',false);
if ( ((isset($_wp_contextual_help[0][$screen[0]]) && Aspis_isset( $_wp_contextual_help [0][$screen[0]]))))
 {if ( (!((empty($title) || Aspis_empty( $title)))))
 $contextual_help = concat($contextual_help,concat2(concat1('<h5>',Aspis_sprintf(__(array('Get help with &#8220;%s&#8221;',false)),$title)),'</h5>'));
else 
{$contextual_help = concat($contextual_help,concat2(concat1('<h5>',__(array('Get help with this page',false))),'</h5>'));
}$contextual_help = concat($contextual_help,concat2(concat1('<div class="metabox-prefs">',attachAspis($_wp_contextual_help,$screen[0])),"</div>\n"));
$contextual_help = concat($contextual_help,concat2(concat1('<h5>',__(array('Other Help',false))),'</h5>'));
}else 
{{$contextual_help = concat($contextual_help,concat2(concat1('<h5>',__(array('Help',false))),'</h5>'));
}}$contextual_help = concat2($contextual_help,'<div class="metabox-prefs">');
$default_help = __(array('<a href="http://codex.wordpress.org/" target="_blank">Documentation</a>',false));
$default_help = concat2($default_help,'<br />');
$default_help = concat($default_help,__(array('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>',false)));
$contextual_help = concat($contextual_help,apply_filters(array('default_contextual_help',false),$default_help));
$contextual_help = concat2($contextual_help,"</div>\n");
echo AspisCheckPrint(apply_filters(array('contextual_help',false),$contextual_help,$screen));
;
?>
	</div>

<div id="screen-meta-links">
<div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
<a href="#contextual-help" id="contextual-help-link" class="show-settings"><?php _e(array('Help',false));
?></a>
</div>
<?php if ( $show_screen[0])
 {;
?>
<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
<a href="#screen-options" id="show-settings-link" class="show-settings"><?php _e(array('Screen Options',false));
?></a>
</div>
<?php };
?>
</div>
</div>
<?php  }
function add_contextual_help ( $screen,$help ) {
global $_wp_contextual_help;
if ( (!((isset($_wp_contextual_help) && Aspis_isset( $_wp_contextual_help)))))
 $_wp_contextual_help = array(array(),false);
arrayAssign($_wp_contextual_help[0],deAspis(registerTaint($screen)),addTaint($help));
 }
function drag_drop_help (  ) {
return concat2(concat(concat2(concat1('
	<p>',__(array('Most of the modules on this screen can be moved. If you hover your mouse over the title bar of a module you&rsquo;ll notice the 4 arrow cursor appears to let you know it is movable. Click on it, hold down the mouse button and start dragging the module to a new location. As you drag the module, notice the dotted gray box that also moves. This box indicates where the module will be placed when you release the mouse button.',false))),'</p>
	<p>'),__(array('The same modules can be expanded and collapsed by clicking once on their title bar and also completely hidden from the Screen Options tab.',false))),'</p>
');
 }
function plugins_search_help (  ) {
return concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat2(concat1('
	<p><strong>',__(array('Search help',false))),'</strong></p>'),'<p>'),__(array('You may search based on 3 criteria:',false))),'<br />'),__(array('<strong>Term:</strong> Searches theme names and descriptions for the specified term.',false))),'<br />'),__(array('<strong>Tag:</strong> Searches for themes tagged as such.',false))),'<br />'),__(array('<strong>Author:</strong> Searches for themes created by the Author, or which the Author contributed to.',false))),'</p>
');
 }
function widgets_help (  ) {
return concat2(concat(concat2(concat(concat2(concat(concat2(concat1('
	<p>',__(array('Widgets are added and arranged by simple drag &#8217;n&#8217; drop. If you hover your mouse over the titlebar of a widget, you&#8217;ll see a 4-arrow cursor which indicates that the widget is movable.  Click on the titlebar, hold down the mouse button and drag the widget to a sidebar. As you drag, you&#8217;ll see a dotted box that also moves. This box shows where the widget will go once you drop it.',false))),'</p>
	<p>'),__(array('To remove a widget from a sidebar, drag it back to Available Widgets or click on the arrow on its titlebar to reveal its settings, and then click Remove.',false))),'</p>
	<p>'),__(array('To remove a widget from a sidebar <em>and keep its configuration</em>, drag it to Inactive Widgets.',false))),'</p>
	<p>'),__(array('The Inactive Widgets area stores widgets that are configured but not curently used. If you change themes and the new theme has fewer sidebars than the old, all extra widgets will be stored to Inactive Widgets automatically.',false))),'</p>
');
 }
function screen_layout ( $screen ) {
global $screen_layout_columns;
$columns = array(array('dashboard' => array(4,false,false),'post' => array(2,false,false),'page' => array(2,false,false),'link' => array(2,false,false)),false);
$columns = apply_filters(array('screen_layout_columns',false),$columns,$screen);
if ( (!((isset($columns[0][$screen[0]]) && Aspis_isset( $columns [0][$screen[0]])))))
 {$screen_layout_columns = array(0,false);
return array('',false);
}$screen_layout_columns = get_user_option(concat1("screen_layout_",$screen));
$num = attachAspis($columns,$screen[0]);
if ( (denot_boolean($screen_layout_columns)))
 $screen_layout_columns = array(2,false);
$i = array(1,false);
$return = concat2(concat(concat2(concat1('<h5>',__(array('Screen Layout',false))),"</h5>\n<div class='columns-prefs'>"),__(array('Number of Columns:',false))),"\n");
while ( ($i[0] <= $num[0]) )
{$return = concat($return,concat(concat(concat2(concat1("<label><input type='radio' name='screen_columns' value='",$i),"'"),(($screen_layout_columns[0] == $i[0]) ? array(" checked='checked'",false) : array("",false))),concat2(concat1(" /> ",$i),"</label>\n")));
preincr($i);
}$return = concat2($return,"</div>\n");
return $return;
 }
function screen_options ( $screen ) {
switch ( $screen[0] ) {
case ('edit'):$per_page_label = __(array('Posts per page:',false));
break ;
case ('edit-pages'):$per_page_label = __(array('Pages per page:',false));
break ;
case ('edit-comments'):$per_page_label = __(array('Comments per page:',false));
break ;
case ('upload'):$per_page_label = __(array('Media items per page:',false));
break ;
case ('categories'):$per_page_label = __(array('Categories per page:',false));
break ;
case ('edit-tags'):$per_page_label = __(array('Tags per page:',false));
break ;
case ('plugins'):$per_page_label = __(array('Plugins per page:',false));
break ;
default :return array('',false);
 }
$option = Aspis_str_replace(array('-',false),array('_',false),concat2($screen,"_per_page"));
$per_page = int_cast(get_user_option($option,array(0,false),array(false,false)));
if ( (((empty($per_page) || Aspis_empty( $per_page))) || ($per_page[0] < (1))))
 {if ( (('plugins') == $screen[0]))
 $per_page = array(999,false);
else 
{$per_page = array(20,false);
}}if ( (('edit_comments_per_page') == $option[0]))
 $per_page = apply_filters(array('comments_per_page',false),$per_page,((isset($_REQUEST[0][('comment_status')]) && Aspis_isset( $_REQUEST [0][('comment_status')]))) ? $_REQUEST[0]['comment_status'] : array('all',false));
elseif ( (('categories') == $option[0]))
 $per_page = apply_filters(array('edit_categories_per_page',false),$per_page);
else 
{$per_page = apply_filters($option,$per_page);
}$return = concat2(concat1('<h5>',__(array('Options',false))),"</h5>\n");
$return = concat2($return,"<div class='screen-options'>\n");
if ( (!((empty($per_page_label) || Aspis_empty( $per_page_label)))))
 $return = concat($return,concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<label for='",$option),"'>"),$per_page_label),"</label> <input type='text' class='screen-per-page' name='wp_screen_options[value]' id='"),$option),"' maxlength='3' value='"),$per_page),"' />\n"));
$return = concat($return,concat2(concat1("<input type='submit' class='button' value='",esc_attr__(array('Apply',false))),"' />"));
$return = concat($return,concat2(concat1("<input type='hidden' name='wp_screen_options[option]' value='",esc_attr($option)),"' />"));
$return = concat2($return,"</div>\n");
return $return;
 }
function screen_icon ( $name = array('',false) ) {
global $parent_file,$hook_suffix;
if ( ((empty($name) || Aspis_empty( $name))))
 {if ( (((isset($parent_file) && Aspis_isset( $parent_file))) && (!((empty($parent_file) || Aspis_empty( $parent_file))))))
 $name = Aspis_substr($parent_file,array(0,false),negate(array(4,false)));
else 
{$name = Aspis_str_replace(array(array(array('.php',false),array('-new',false),array('-add',false)),false),array('',false),$hook_suffix);
}};
?>
	<div id="icon-<?php echo AspisCheckPrint($name);
;
?>" class="icon32"><br /></div>
<?php  }
function compression_test (  ) {
;
?>
	<script type="text/javascript">
	/* <![CDATA[ */
	var testCompression = {
		get : function(test) {
			var x;
			if ( window.XMLHttpRequest ) {
				x = new XMLHttpRequest();
			} else {
				try{x=new ActiveXObject('Msxml2.XMLHTTP');}catch(e){try{x=new ActiveXObject('Microsoft.XMLHTTP');}catch(e){};}
			}

			if (x) {
				x.onreadystatechange = function() {
					var r, h;
					if ( x.readyState == 4 ) {
						r = x.responseText.substr(0, 18);
						h = x.getResponseHeader('Content-Encoding');
						testCompression.check(r, h, test);
					}
				}

				x.open('GET', 'admin-ajax.php?action=wp-compression-test&test='+test+'&'+(new Date()).getTime(), true);
				x.send('');
			}
		},

		check : function(r, h, test) {
			if ( ! r && ! test )
				this.get(1);

			if ( 1 == test ) {
				if ( h && ( h.match(/deflate/i) || h.match(/gzip/i) ) )
					this.get('no');
				else
					this.get(2);

				return;
			}

			if ( 2 == test ) {
				if ( '"wpCompressionTest' == r )
					this.get('yes');
				else
					this.get('no');
			}
		}
	};
	testCompression.check();
	/* ]]> */
	</script>
<?php  }
;
?>
<?php 