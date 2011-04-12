<?php require_once('AspisMain.php'); ?><?php
class WP_Widget_Pages extends WP_Widget{function WP_Widget_Pages (  ) {
{$widget_ops = array(array('classname' => array('widget_pages',false,false),deregisterTaint(array('description',false)) => addTaint(__(array('Your blog&#8217;s WordPress Pages',false)))),false);
$this->WP_Widget(array('pages',false),__(array('Pages',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? __(array('Pages',false)) : $instance[0]['title']);
$sortby = ((empty($instance[0][('sortby')]) || Aspis_empty( $instance [0][('sortby')]))) ? array('menu_order',false) : $instance[0]['sortby'];
$exclude = ((empty($instance[0][('exclude')]) || Aspis_empty( $instance [0][('exclude')]))) ? array('',false) : $instance[0]['exclude'];
if ( ($sortby[0] == ('menu_order')))
 $sortby = array('menu_order, post_title',false);
$out = wp_list_pages(apply_filters(array('widget_pages_args',false),array(array('title_li' => array('',false,false),'echo' => array(0,false,false),deregisterTaint(array('sort_column',false)) => addTaint($sortby),deregisterTaint(array('exclude',false)) => addTaint($exclude)),false)));
if ( (!((empty($out) || Aspis_empty( $out)))))
 {echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
;
?>
		<ul>
			<?php echo AspisCheckPrint($out);
;
?>
		</ul>
		<?php echo AspisCheckPrint($after_widget);
}} }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
if ( deAspis(Aspis_in_array($new_instance[0]['sortby'],array(array(array('post_title',false),array('menu_order',false),array('ID',false)),false))))
 {arrayAssign($instance[0],deAspis(registerTaint(array('sortby',false))),addTaint($new_instance[0]['sortby']));
}else 
{{arrayAssign($instance[0],deAspis(registerTaint(array('sortby',false))),addTaint(array('menu_order',false)));
}}arrayAssign($instance[0],deAspis(registerTaint(array('exclude',false))),addTaint(Aspis_strip_tags($new_instance[0]['exclude'])));
return $instance;
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('sortby' => array('post_title',false,false),'title' => array('',false,false),'exclude' => array('',false,false)),false));
$title = esc_attr($instance[0]['title']);
$exclude = esc_attr($instance[0]['exclude']);
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label> <input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint($title);
;
?>" /></p>
		<p>
			<label for="<?php echo AspisCheckPrint($this->get_field_id(array('sortby',false)));
;
?>"><?php _e(array('Sort by:',false));
;
?></label>
			<select name="<?php echo AspisCheckPrint($this->get_field_name(array('sortby',false)));
;
?>" id="<?php echo AspisCheckPrint($this->get_field_id(array('sortby',false)));
;
?>" class="widefat">
				<option value="post_title"<?php selected($instance[0]['sortby'],array('post_title',false));
;
?>><?php _e(array('Page title',false));
;
?></option>
				<option value="menu_order"<?php selected($instance[0]['sortby'],array('menu_order',false));
;
?>><?php _e(array('Page order',false));
;
?></option>
				<option value="ID"<?php selected($instance[0]['sortby'],array('ID',false));
;
?>><?php _e(array('Page ID',false));
;
?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo AspisCheckPrint($this->get_field_id(array('exclude',false)));
;
?>"><?php _e(array('Exclude:',false));
;
?></label> <input type="text" value="<?php echo AspisCheckPrint($exclude);
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('exclude',false)));
;
?>" id="<?php echo AspisCheckPrint($this->get_field_id(array('exclude',false)));
;
?>" class="widefat" />
			<br />
			<small><?php _e(array('Page IDs, separated by commas.',false));
;
?></small>
		</p>
<?php } }
}class WP_Widget_Links extends WP_Widget{function WP_Widget_Links (  ) {
{$widget_ops = array(array(deregisterTaint(array('description',false)) => addTaint(__(array("Your blogroll",false)))),false);
$this->WP_Widget(array('links',false),__(array('Links',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]),EXTR_SKIP);
$show_description = ((isset($instance[0][('description')]) && Aspis_isset( $instance [0][('description')]))) ? $instance[0]['description'] : array(false,false);
$show_name = ((isset($instance[0][('name')]) && Aspis_isset( $instance [0][('name')]))) ? $instance[0]['name'] : array(false,false);
$show_rating = ((isset($instance[0][('rating')]) && Aspis_isset( $instance [0][('rating')]))) ? $instance[0]['rating'] : array(false,false);
$show_images = ((isset($instance[0][('images')]) && Aspis_isset( $instance [0][('images')]))) ? $instance[0]['images'] : array(true,false);
$category = ((isset($instance[0][('category')]) && Aspis_isset( $instance [0][('category')]))) ? $instance[0]['category'] : array(false,false);
if ( (deAspis(is_admin()) && (denot_boolean($category))))
 {echo AspisCheckPrint(concat(concat(concat(concat($before_widget,$before_title),__(array('All Links',false))),$after_title),$after_widget));
return ;
}$before_widget = Aspis_preg_replace(array('/id="[^"]*"/',false),array('id="%id"',false),$before_widget);
wp_list_bookmarks(apply_filters(array('widget_links_args',false),array(array(deregisterTaint(array('title_before',false)) => addTaint($before_title),deregisterTaint(array('title_after',false)) => addTaint($after_title),deregisterTaint(array('category_before',false)) => addTaint($before_widget),deregisterTaint(array('category_after',false)) => addTaint($after_widget),deregisterTaint(array('show_images',false)) => addTaint($show_images),deregisterTaint(array('show_description',false)) => addTaint($show_description),deregisterTaint(array('show_name',false)) => addTaint($show_name),deregisterTaint(array('show_rating',false)) => addTaint($show_rating),deregisterTaint(array('category',false)) => addTaint($category),'class' => array('linkcat widget',false,false)),false)));
} }
function update ( $new_instance,$old_instance ) {
{$new_instance = array_cast($new_instance);
$instance = array(array('images' => array(0,false,false),'name' => array(0,false,false),'description' => array(0,false,false),'rating' => array(0,false,false)),false);
foreach ( $instance[0] as $field =>$val )
{restoreTaint($field,$val);
{if ( ((isset($new_instance[0][$field[0]]) && Aspis_isset( $new_instance [0][$field[0]]))))
 arrayAssign($instance[0],deAspis(registerTaint($field)),addTaint(array(1,false)));
}}arrayAssign($instance[0],deAspis(registerTaint(array('category',false))),addTaint(Aspis_intval($new_instance[0]['category'])));
return $instance;
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('images' => array(true,false,false),'name' => array(true,false,false),'description' => array(false,false,false),'rating' => array(false,false,false),'category' => array(false,false,false)),false));
$link_cats = get_terms(array('link_category',false));
;
?>
		<p>
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('category',false)));
;
?>" class="screen-reader-text"><?php _e(array('Select Link Category',false));
;
?></label>
		<select class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('category',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('category',false)));
;
?>">
		<option value=""><?php _e(array('All Links',false));
;
?></option>
		<?php foreach ( $link_cats[0] as $link_cat  )
{echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('<option value="',Aspis_intval($link_cat[0]->term_id)),'"'),(($link_cat[0]->term_id[0] == deAspis($instance[0]['category'])) ? array(' selected="selected"',false) : array('',false))),'>'),$link_cat[0]->name),"</option>\n"));
};
?>
		</select></p>
		<p>
		<input class="checkbox" type="checkbox" <?php checked($instance[0]['images'],array(true,false));
;
?> id="<?php echo AspisCheckPrint($this->get_field_id(array('images',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('images',false)));
;
?>" />
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('images',false)));
;
?>"><?php _e(array('Show Link Image',false));
;
?></label><br />
		<input class="checkbox" type="checkbox" <?php checked($instance[0]['name'],array(true,false));
;
?> id="<?php echo AspisCheckPrint($this->get_field_id(array('name',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('name',false)));
;
?>" />
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('name',false)));
;
?>"><?php _e(array('Show Link Name',false));
;
?></label><br />
		<input class="checkbox" type="checkbox" <?php checked($instance[0]['description'],array(true,false));
;
?> id="<?php echo AspisCheckPrint($this->get_field_id(array('description',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('description',false)));
;
?>" />
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('description',false)));
;
?>"><?php _e(array('Show Link Description',false));
;
?></label><br />
		<input class="checkbox" type="checkbox" <?php checked($instance[0]['rating'],array(true,false));
;
?> id="<?php echo AspisCheckPrint($this->get_field_id(array('rating',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('rating',false)));
;
?>" />
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('rating',false)));
;
?>"><?php _e(array('Show Link Rating',false));
;
?></label>
		</p>
<?php } }
}class WP_Widget_Search extends WP_Widget{function WP_Widget_Search (  ) {
{$widget_ops = array(array('classname' => array('widget_search',false,false),deregisterTaint(array('description',false)) => addTaint(__(array("A search form for your blog",false)))),false);
$this->WP_Widget(array('search',false),__(array('Search',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$title = apply_filters(array('widget_title',false),$instance[0]['title']);
echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
get_search_form();
echo AspisCheckPrint($after_widget);
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('title' => array('',false,false)),false));
$title = $instance[0]['title'];
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?> <input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>" /></label></p>
<?php } }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
$new_instance = wp_parse_args(array_cast($new_instance),array(array('title' => array('',false,false)),false));
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
return $instance;
} }
}class WP_Widget_Archives extends WP_Widget{function WP_Widget_Archives (  ) {
{$widget_ops = array(array('classname' => array('widget_archive',false,false),deregisterTaint(array('description',false)) => addTaint(__(array('A monthly archive of your blog&#8217;s posts',false)))),false);
$this->WP_Widget(array('archives',false),__(array('Archives',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$c = deAspis($instance[0]['count']) ? array('1',false) : array('0',false);
$d = deAspis($instance[0]['dropdown']) ? array('1',false) : array('0',false);
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? __(array('Archives',false)) : $instance[0]['title']);
echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
if ( $d[0])
 {;
?>
		<select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> <option value=""><?php echo AspisCheckPrint(esc_attr(__(array('Select Month',false))));
;
?></option> <?php wp_get_archives(apply_filters(array('widget_archives_dropdown_args',false),array(array('type' => array('monthly',false,false),'format' => array('option',false,false),deregisterTaint(array('show_post_count',false)) => addTaint($c)),false)));
;
?> </select>
<?php }else 
{{;
?>
		<ul>
		<?php wp_get_archives(apply_filters(array('widget_archives_args',false),array(array('type' => array('monthly',false,false),deregisterTaint(array('show_post_count',false)) => addTaint($c)),false)));
;
?>
		</ul>
<?php }}echo AspisCheckPrint($after_widget);
} }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
$new_instance = wp_parse_args(array_cast($new_instance),array(array('title' => array('',false,false),'count' => array(0,false,false),'dropdown' => array('',false,false)),false));
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
arrayAssign($instance[0],deAspis(registerTaint(array('count',false))),addTaint(deAspis($new_instance[0]['count']) ? array(1,false) : array(0,false)));
arrayAssign($instance[0],deAspis(registerTaint(array('dropdown',false))),addTaint(deAspis($new_instance[0]['dropdown']) ? array(1,false) : array(0,false)));
return $instance;
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('title' => array('',false,false),'count' => array(0,false,false),'dropdown' => array('',false,false)),false));
$title = Aspis_strip_tags($instance[0]['title']);
$count = deAspis($instance[0]['count']) ? array('checked="checked"',false) : array('',false);
$dropdown = deAspis($instance[0]['dropdown']) ? array('checked="checked"',false) : array('',false);
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label> <input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>" /></p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo AspisCheckPrint($count);
;
?> id="<?php echo AspisCheckPrint($this->get_field_id(array('count',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('count',false)));
;
?>" /> <label for="<?php echo AspisCheckPrint($this->get_field_id(array('count',false)));
;
?>"><?php _e(array('Show post counts',false));
;
?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo AspisCheckPrint($dropdown);
;
?> id="<?php echo AspisCheckPrint($this->get_field_id(array('dropdown',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('dropdown',false)));
;
?>" /> <label for="<?php echo AspisCheckPrint($this->get_field_id(array('dropdown',false)));
;
?>"><?php _e(array('Display as a drop down',false));
;
?></label>
		</p>
<?php } }
}class WP_Widget_Meta extends WP_Widget{function WP_Widget_Meta (  ) {
{$widget_ops = array(array('classname' => array('widget_meta',false,false),deregisterTaint(array('description',false)) => addTaint(__(array("Log in/out, admin, feed and WordPress links",false)))),false);
$this->WP_Widget(array('meta',false),__(array('Meta',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? __(array('Meta',false)) : $instance[0]['title']);
echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
;
?>
			<ul>
			<?php wp_register();
;
?>
			<li><?php wp_loginout();
;
?></li>
			<li><a href="<?php bloginfo(array('rss2_url',false));
;
?>" title="<?php echo AspisCheckPrint(esc_attr(__(array('Syndicate this site using RSS 2.0',false))));
;
?>"><?php _e(array('Entries <abbr title="Really Simple Syndication">RSS</abbr>',false));
;
?></a></li>
			<li><a href="<?php bloginfo(array('comments_rss2_url',false));
;
?>" title="<?php echo AspisCheckPrint(esc_attr(__(array('The latest comments to all posts in RSS',false))));
;
?>"><?php _e(array('Comments <abbr title="Really Simple Syndication">RSS</abbr>',false));
;
?></a></li>
			<li><a href="http://wordpress.org/" title="<?php echo AspisCheckPrint(esc_attr(__(array('Powered by WordPress, state-of-the-art semantic personal publishing platform.',false))));
;
?>">WordPress.org</a></li>
			<?php wp_meta();
;
?>
			</ul>
<?php echo AspisCheckPrint($after_widget);
} }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
return $instance;
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('title' => array('',false,false)),false));
$title = Aspis_strip_tags($instance[0]['title']);
;
?>
			<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label> <input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>" /></p>
<?php } }
}class WP_Widget_Calendar extends WP_Widget{function WP_Widget_Calendar (  ) {
{$widget_ops = array(array('classname' => array('widget_calendar',false,false),deregisterTaint(array('description',false)) => addTaint(__(array('A calendar of your blog&#8217;s posts',false)))),false);
$this->WP_Widget(array('calendar',false),__(array('Calendar',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? array('&nbsp;',false) : $instance[0]['title']);
echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
echo AspisCheckPrint(array('<div id="calendar_wrap">',false));
get_calendar();
echo AspisCheckPrint(array('</div>',false));
echo AspisCheckPrint($after_widget);
} }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
return $instance;
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('title' => array('',false,false)),false));
$title = Aspis_strip_tags($instance[0]['title']);
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label>
		<input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>" /></p>
<?php } }
}class WP_Widget_Text extends WP_Widget{function WP_Widget_Text (  ) {
{$widget_ops = array(array('classname' => array('widget_text',false,false),deregisterTaint(array('description',false)) => addTaint(__(array('Arbitrary text or HTML',false)))),false);
$control_ops = array(array('width' => array(400,false,false),'height' => array(350,false,false)),false);
$this->WP_Widget(array('text',false),__(array('Text',false)),$widget_ops,$control_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? array('',false) : $instance[0]['title'],$instance);
$text = apply_filters(array('widget_text',false),$instance[0]['text'],$instance);
echo AspisCheckPrint($before_widget);
if ( (!((empty($title) || Aspis_empty( $title)))))
 {echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
};
?>
			<div class="textwidget"><?php echo AspisCheckPrint(deAspis($instance[0]['filter']) ? wpautop($text) : $text);
;
?></div>
		<?php echo AspisCheckPrint($after_widget);
} }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
if ( deAspis(current_user_can(array('unfiltered_html',false))))
 arrayAssign($instance[0],deAspis(registerTaint(array('text',false))),addTaint($new_instance[0]['text']));
else 
{arrayAssign($instance[0],deAspis(registerTaint(array('text',false))),addTaint(Aspis_stripslashes(wp_filter_post_kses(Aspis_addslashes($new_instance[0]['text'])))));
}arrayAssign($instance[0],deAspis(registerTaint(array('filter',false))),addTaint(array((isset($new_instance[0][('filter')]) && Aspis_isset( $new_instance [0][('filter')])),false)));
return $instance;
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('title' => array('',false,false),'text' => array('',false,false)),false));
$title = Aspis_strip_tags($instance[0]['title']);
$text = format_to_edit($instance[0]['text']);
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label>
		<input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo AspisCheckPrint($this->get_field_id(array('text',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('text',false)));
;
?>"><?php echo AspisCheckPrint($text);
;
?></textarea>

		<p><input id="<?php echo AspisCheckPrint($this->get_field_id(array('filter',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('filter',false)));
;
?>" type="checkbox" <?php checked(((isset($instance[0][('filter')]) && Aspis_isset( $instance [0][('filter')]))) ? $instance[0]['filter'] : array(0,false));
;
?> />&nbsp;<label for="<?php echo AspisCheckPrint($this->get_field_id(array('filter',false)));
;
?>"><?php _e(array('Automatically add paragraphs.',false));
;
?></label></p>
<?php } }
}class WP_Widget_Categories extends WP_Widget{function WP_Widget_Categories (  ) {
{$widget_ops = array(array('classname' => array('widget_categories',false,false),deregisterTaint(array('description',false)) => addTaint(__(array("A list or dropdown of categories",false)))),false);
$this->WP_Widget(array('categories',false),__(array('Categories',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? __(array('Categories',false)) : $instance[0]['title']);
$c = deAspis($instance[0]['count']) ? array('1',false) : array('0',false);
$h = deAspis($instance[0]['hierarchical']) ? array('1',false) : array('0',false);
$d = deAspis($instance[0]['dropdown']) ? array('1',false) : array('0',false);
echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
$cat_args = array(array('orderby' => array('name',false,false),deregisterTaint(array('show_count',false)) => addTaint($c),deregisterTaint(array('hierarchical',false)) => addTaint($h)),false);
if ( $d[0])
 {arrayAssign($cat_args[0],deAspis(registerTaint(array('show_option_none',false))),addTaint(__(array('Select Category',false))));
wp_dropdown_categories(apply_filters(array('widget_categories_dropdown_args',false),$cat_args));
;
?>

<script type='text/javascript'>
/* <![CDATA[ */
	var dropdown = document.getElementById("cat");
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "<?php echo AspisCheckPrint(get_option(array('home',false)));
;
?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>

<?php }else 
{{;
?>
		<ul>
<?php arrayAssign($cat_args[0],deAspis(registerTaint(array('title_li',false))),addTaint(array('',false)));
wp_list_categories(apply_filters(array('widget_categories_args',false),$cat_args));
;
?>
		</ul>
<?php }}echo AspisCheckPrint($after_widget);
} }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
arrayAssign($instance[0],deAspis(registerTaint(array('count',false))),addTaint(deAspis($new_instance[0]['count']) ? array(1,false) : array(0,false)));
arrayAssign($instance[0],deAspis(registerTaint(array('hierarchical',false))),addTaint(deAspis($new_instance[0]['hierarchical']) ? array(1,false) : array(0,false)));
arrayAssign($instance[0],deAspis(registerTaint(array('dropdown',false))),addTaint(deAspis($new_instance[0]['dropdown']) ? array(1,false) : array(0,false)));
return $instance;
} }
function form ( $instance ) {
{$instance = wp_parse_args(array_cast($instance),array(array('title' => array('',false,false)),false));
$title = esc_attr($instance[0]['title']);
$count = ((isset($instance[0][('count')]) && Aspis_isset( $instance [0][('count')]))) ? bool_cast($instance[0]['count']) : array(false,false);
$hierarchical = ((isset($instance[0][('hierarchical')]) && Aspis_isset( $instance [0][('hierarchical')]))) ? bool_cast($instance[0]['hierarchical']) : array(false,false);
$dropdown = ((isset($instance[0][('dropdown')]) && Aspis_isset( $instance [0][('dropdown')]))) ? bool_cast($instance[0]['dropdown']) : array(false,false);
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label>
		<input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint($title);
;
?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo AspisCheckPrint($this->get_field_id(array('dropdown',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('dropdown',false)));
;
?>"<?php checked($dropdown);
;
?> />
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('dropdown',false)));
;
?>"><?php _e(array('Show as dropdown',false));
;
?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo AspisCheckPrint($this->get_field_id(array('count',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('count',false)));
;
?>"<?php checked($count);
;
?> />
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('count',false)));
;
?>"><?php _e(array('Show post counts',false));
;
?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo AspisCheckPrint($this->get_field_id(array('hierarchical',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('hierarchical',false)));
;
?>"<?php checked($hierarchical);
;
?> />
		<label for="<?php echo AspisCheckPrint($this->get_field_id(array('hierarchical',false)));
;
?>"><?php _e(array('Show hierarchy',false));
;
?></label></p>
<?php } }
}class WP_Widget_Recent_Posts extends WP_Widget{function WP_Widget_Recent_Posts (  ) {
{$widget_ops = array(array('classname' => array('widget_recent_entries',false,false),deregisterTaint(array('description',false)) => addTaint(__(array("The most recent posts on your blog",false)))),false);
$this->WP_Widget(array('recent-posts',false),__(array('Recent Posts',false)),$widget_ops);
$this->alt_option_name = array('widget_recent_entries',false);
add_action(array('save_post',false),array(array(array($this,false),array('flush_widget_cache',false)),false));
add_action(array('deleted_post',false),array(array(array($this,false),array('flush_widget_cache',false)),false));
add_action(array('switch_theme',false),array(array(array($this,false),array('flush_widget_cache',false)),false));
} }
function widget ( $args,$instance ) {
{$cache = wp_cache_get(array('widget_recent_posts',false),array('widget',false));
if ( (!(is_array($cache[0]))))
 $cache = array(array(),false);
if ( ((isset($cache[0][deAspis($args[0]['widget_id'])]) && Aspis_isset( $cache [0][deAspis($args [0]['widget_id'])]))))
 {echo AspisCheckPrint(attachAspis($cache,deAspis($args[0]['widget_id'])));
return ;
}ob_start();
extract(($args[0]));
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? __(array('Recent Posts',false)) : $instance[0]['title']);
if ( (denot_boolean($number = int_cast($instance[0]['number']))))
 $number = array(10,false);
else 
{if ( ($number[0] < (1)))
 $number = array(1,false);
else 
{if ( ($number[0] > (15)))
 $number = array(15,false);
}}$r = array(new WP_Query(array(array(deregisterTaint(array('showposts',false)) => addTaint($number),'nopaging' => array(0,false,false),'post_status' => array('publish',false,false),'caller_get_posts' => array(1,false,false)),false)),false);
if ( deAspis($r[0]->have_posts()))
 {;
?>
		<?php echo AspisCheckPrint($before_widget);
;
?>
		<?php if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
;
?>
		<ul>
		<?php while ( deAspis($r[0]->have_posts()) )
{$r[0]->the_post();
;
?>
		<li><a href="<?php the_permalink();
;
?>" title="<?php echo AspisCheckPrint(esc_attr(deAspis(get_the_title()) ? get_the_title() : get_the_ID()));
;
?>"><?php if ( deAspis(get_the_title()))
 the_title();
else 
{the_ID();
};
?> </a></li>
		<?php };
?>
		</ul>
		<?php echo AspisCheckPrint($after_widget);
;
?>
<?php wp_reset_query();
}arrayAssign($cache[0],deAspis(registerTaint($args[0]['widget_id'])),addTaint(attAspis(ob_get_flush())));
wp_cache_add(array('widget_recent_posts',false),$cache,array('widget',false));
} }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
arrayAssign($instance[0],deAspis(registerTaint(array('number',false))),addTaint(int_cast($new_instance[0]['number'])));
$this->flush_widget_cache();
$alloptions = wp_cache_get(array('alloptions',false),array('options',false));
if ( ((isset($alloptions[0][('widget_recent_entries')]) && Aspis_isset( $alloptions [0][('widget_recent_entries')]))))
 delete_option(array('widget_recent_entries',false));
return $instance;
} }
function flush_widget_cache (  ) {
{wp_cache_delete(array('widget_recent_posts',false),array('widget',false));
} }
function form ( $instance ) {
{$title = ((isset($instance[0][('title')]) && Aspis_isset( $instance [0][('title')]))) ? esc_attr($instance[0]['title']) : array('',false);
if ( ((!((isset($instance[0][('number')]) && Aspis_isset( $instance [0][('number')])))) || (denot_boolean($number = int_cast($instance[0]['number'])))))
 $number = array(5,false);
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label>
		<input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint($title);
;
?>" /></p>

		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('number',false)));
;
?>"><?php _e(array('Number of posts to show:',false));
;
?></label>
		<input id="<?php echo AspisCheckPrint($this->get_field_id(array('number',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('number',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint($number);
;
?>" size="3" /><br />
		<small><?php _e(array('(at most 15)',false));
;
?></small></p>
<?php } }
}class WP_Widget_Recent_Comments extends WP_Widget{function WP_Widget_Recent_Comments (  ) {
{$widget_ops = array(array('classname' => array('widget_recent_comments',false,false),deregisterTaint(array('description',false)) => addTaint(__(array('The most recent comments',false)))),false);
$this->WP_Widget(array('recent-comments',false),__(array('Recent Comments',false)),$widget_ops);
$this->alt_option_name = array('widget_recent_comments',false);
if ( deAspis(is_active_widget(array(false,false),array(false,false),$this->id_base)))
 add_action(array('wp_head',false),array(array(array($this,false),array('recent_comments_style',false)),false));
add_action(array('comment_post',false),array(array(array($this,false),array('flush_widget_cache',false)),false));
add_action(array('transition_comment_status',false),array(array(array($this,false),array('flush_widget_cache',false)),false));
} }
function recent_comments_style (  ) {
{;
?>
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<?php } }
function flush_widget_cache (  ) {
{wp_cache_delete(array('recent_comments',false),array('widget',false));
} }
function widget ( $args,$instance ) {
{global $wpdb,$comments,$comment;
extract(($args[0]),EXTR_SKIP);
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? __(array('Recent Comments',false)) : $instance[0]['title']);
if ( (denot_boolean($number = int_cast($instance[0]['number']))))
 $number = array(5,false);
else 
{if ( ($number[0] < (1)))
 $number = array(1,false);
else 
{if ( ($number[0] > (15)))
 $number = array(15,false);
}}if ( (denot_boolean($comments = wp_cache_get(array('recent_comments',false),array('widget',false)))))
 {$comments = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT ",$wpdb[0]->comments),".* FROM "),$wpdb[0]->comments)," JOIN "),$wpdb[0]->posts)," ON "),$wpdb[0]->posts),".ID = "),$wpdb[0]->comments),".comment_post_ID WHERE comment_approved = '1' AND post_status = 'publish' ORDER BY comment_date_gmt DESC LIMIT 15"));
wp_cache_add(array('recent_comments',false),$comments,array('widget',false));
}$comments = Aspis_array_slice(array_cast($comments),array(0,false),$number);
;
?>
		<?php echo AspisCheckPrint($before_widget);
;
?>
			<?php if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
;
?>
			<ul id="recentcomments"><?php if ( $comments[0])
 {foreach ( deAspis(array_cast($comments)) as $comment  )
{echo AspisCheckPrint(concat2(concat1('<li class="recentcomments">',Aspis_sprintf(_x(array('%1$s on %2$s',false),array('widgets',false)),get_comment_author_link(),concat2(concat(concat2(concat1('<a href="',esc_url(get_comment_link($comment[0]->comment_ID))),'">'),get_the_title($comment[0]->comment_post_ID)),'</a>'))),'</li>'));
}};
?></ul>
		<?php echo AspisCheckPrint($after_widget);
;
?>
<?php } }
function update ( $new_instance,$old_instance ) {
{$instance = $old_instance;
arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags($new_instance[0]['title'])));
arrayAssign($instance[0],deAspis(registerTaint(array('number',false))),addTaint(int_cast($new_instance[0]['number'])));
$this->flush_widget_cache();
$alloptions = wp_cache_get(array('alloptions',false),array('options',false));
if ( ((isset($alloptions[0][('widget_recent_comments')]) && Aspis_isset( $alloptions [0][('widget_recent_comments')]))))
 delete_option(array('widget_recent_comments',false));
return $instance;
} }
function form ( $instance ) {
{$title = ((isset($instance[0][('title')]) && Aspis_isset( $instance [0][('title')]))) ? esc_attr($instance[0]['title']) : array('',false);
$number = ((isset($instance[0][('number')]) && Aspis_isset( $instance [0][('number')]))) ? absint($instance[0]['number']) : array(5,false);
;
?>
		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label>
		<input class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint($title);
;
?>" /></p>

		<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('number',false)));
;
?>"><?php _e(array('Number of comments to show:',false));
;
?></label>
		<input id="<?php echo AspisCheckPrint($this->get_field_id(array('number',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('number',false)));
;
?>" type="text" value="<?php echo AspisCheckPrint($number);
;
?>" size="3" /><br />
		<small><?php _e(array('(at most 15)',false));
;
?></small></p>
<?php } }
}class WP_Widget_RSS extends WP_Widget{function WP_Widget_RSS (  ) {
{$widget_ops = array(array(deregisterTaint(array('description',false)) => addTaint(__(array('Entries from any RSS or Atom feed',false)))),false);
$control_ops = array(array('width' => array(400,false,false),'height' => array(200,false,false)),false);
$this->WP_Widget(array('rss',false),__(array('RSS',false)),$widget_ops,$control_ops);
} }
function widget ( $args,$instance ) {
{if ( (((isset($instance[0][('error')]) && Aspis_isset( $instance [0][('error')]))) && deAspis($instance[0]['error'])))
 return ;
extract(($args[0]),EXTR_SKIP);
$url = $instance[0]['url'];
while ( (deAspis(Aspis_stristr($url,array('http',false))) != $url[0]) )
$url = Aspis_substr($url,array(1,false));
if ( ((empty($url) || Aspis_empty( $url))))
 return ;
$rss = fetch_feed($url);
$title = $instance[0]['title'];
$desc = array('',false);
$link = array('',false);
if ( (denot_boolean(is_wp_error($rss))))
 {$desc = esc_attr(Aspis_strip_tags(@Aspis_html_entity_decode($rss[0]->get_description(),array(ENT_QUOTES,false),get_option(array('blog_charset',false)))));
if ( ((empty($title) || Aspis_empty( $title))))
 $title = esc_html(Aspis_strip_tags($rss[0]->get_title()));
$link = esc_url(Aspis_strip_tags($rss[0]->get_permalink()));
while ( (deAspis(Aspis_stristr($link,array('http',false))) != $link[0]) )
$link = Aspis_substr($link,array(1,false));
}if ( ((empty($title) || Aspis_empty( $title))))
 $title = ((empty($desc) || Aspis_empty( $desc))) ? __(array('Unknown Feed',false)) : $desc;
$title = apply_filters(array('widget_title',false),$title);
$url = esc_url(Aspis_strip_tags($url));
$icon = includes_url(array('images/rss.png',false));
if ( $title[0])
 $title = concat(concat(concat2(concat1("<a class='rsswidget' href='",$url),"' title='"),esc_attr(__(array('Syndicate this content',false)))),concat2(concat(concat2(concat(concat2(concat(concat2(concat1("'><img style='background:orange;color:white;border:none;' width='14' height='14' src='",$icon),"' alt='RSS' /></a> <a class='rsswidget' href='"),$link),"' title='"),$desc),"'>"),$title),"</a>"));
echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
wp_widget_rss_output($rss,$instance);
echo AspisCheckPrint($after_widget);
if ( (denot_boolean(is_wp_error($rss))))
 $rss[0]->__destruct();
unset($rss);
} }
function update ( $new_instance,$old_instance ) {
{$testurl = array(deAspis($new_instance[0]['url']) != deAspis($old_instance[0]['url']),false);
return wp_widget_rss_process($new_instance,$testurl);
} }
function form ( $instance ) {
{if ( ((empty($instance) || Aspis_empty( $instance))))
 $instance = array(array('title' => array('',false,false),'url' => array('',false,false),'items' => array(10,false,false),'error' => array(false,false,false),'show_summary' => array(0,false,false),'show_author' => array(0,false,false),'show_date' => array(0,false,false)),false);
arrayAssign($instance[0],deAspis(registerTaint(array('number',false))),addTaint($this->number));
wp_widget_rss_form($instance);
} }
}function wp_widget_rss_output ( $rss,$args = array(array(),false) ) {
if ( is_string(deAspisRC($rss)))
 {$rss = fetch_feed($rss);
}elseif ( (is_array($rss[0]) && ((isset($rss[0][('url')]) && Aspis_isset( $rss [0][('url')])))))
 {$args = $rss;
$rss = fetch_feed($rss[0]['url']);
}elseif ( (!(is_object($rss[0]))))
 {return ;
}if ( deAspis(is_wp_error($rss)))
 {if ( (deAspis(is_admin()) || deAspis(current_user_can(array('manage_options',false)))))
 echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(__(array('<strong>RSS Error</strong>: %s',false)),$rss[0]->get_error_message())),'</p>'));
return ;
}$default_args = array(array('show_author' => array(0,false,false),'show_date' => array(0,false,false),'show_summary' => array(0,false,false)),false);
$args = wp_parse_args($args,$default_args);
extract(($args[0]),EXTR_SKIP);
$items = int_cast($items);
if ( (($items[0] < (1)) || ((20) < $items[0])))
 $items = array(10,false);
$show_summary = int_cast($show_summary);
$show_author = int_cast($show_author);
$show_date = int_cast($show_date);
if ( (denot_boolean($rss[0]->get_item_quantity())))
 {echo AspisCheckPrint(concat2(concat1('<ul><li>',__(array('An error has occurred; the feed is probably down. Try again later.',false))),'</li></ul>'));
$rss[0]->__destruct();
unset($rss);
return ;
}echo AspisCheckPrint(array('<ul>',false));
foreach ( deAspis($rss[0]->get_items(array(0,false),$items)) as $item  )
{$link = $item[0]->get_link();
while ( (deAspis(Aspis_stristr($link,array('http',false))) != $link[0]) )
$link = Aspis_substr($link,array(1,false));
$link = esc_url(Aspis_strip_tags($link));
$title = esc_attr(Aspis_strip_tags($item[0]->get_title()));
if ( ((empty($title) || Aspis_empty( $title))))
 $title = __(array('Untitled',false));
$desc = Aspis_str_replace(array(array(array("\n",false),array("\r",false)),false),array(' ',false),esc_attr(Aspis_strip_tags(@Aspis_html_entity_decode($item[0]->get_description(),array(ENT_QUOTES,false),get_option(array('blog_charset',false))))));
$desc = concat2(wp_html_excerpt($desc,array(360,false)),' [&hellip;]');
$desc = esc_html($desc);
if ( $show_summary[0])
 {$summary = concat2(concat1("<div class='rssSummary'>",$desc),"</div>");
}else 
{{$summary = array('',false);
}}$date = array('',false);
if ( $show_date[0])
 {$date = $item[0]->get_date();
if ( $date[0])
 {if ( deAspis($date_stamp = attAspis(strtotime($date[0]))))
 $date = concat2(concat1(' <span class="rss-date">',date_i18n(get_option(array('date_format',false)),$date_stamp)),'</span>');
else 
{$date = array('',false);
}}}$author = array('',false);
if ( $show_author[0])
 {$author = $item[0]->get_author();
if ( is_object($author[0]))
 {$author = $author[0]->get_name();
$author = concat2(concat1(' <cite>',esc_html(Aspis_strip_tags($author))),'</cite>');
}}if ( ($link[0] == ('')))
 {echo AspisCheckPrint(concat2(concat1("<li>",$title{$date}{$summary}{$author}),"</li>"));
}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<li><a class='rsswidget' href='",$link),"' title='"),$desc),"'>"),$title),"</a>"),$date),"</li>"));
}}}echo AspisCheckPrint(array('</ul>',false));
$rss[0]->__destruct();
unset($rss);
 }
function wp_widget_rss_form ( $args,$inputs = array(null,false) ) {
$default_inputs = array(array('url' => array(true,false,false),'title' => array(true,false,false),'items' => array(true,false,false),'show_summary' => array(true,false,false),'show_author' => array(true,false,false),'show_date' => array(true,false,false)),false);
$inputs = wp_parse_args($inputs,$default_inputs);
extract(($args[0]));
extract(($inputs[0]),EXTR_SKIP);
$number = esc_attr($number);
$title = esc_attr($title);
$url = esc_url($url);
$items = int_cast($items);
if ( (($items[0] < (1)) || ((20) < $items[0])))
 $items = array(10,false);
$show_summary = int_cast($show_summary);
$show_author = int_cast($show_author);
$show_date = int_cast($show_date);
if ( (!((empty($error) || Aspis_empty( $error)))))
 echo AspisCheckPrint(concat2(concat1('<p class="widget-error"><strong>',Aspis_sprintf(__(array('RSS Error: %s',false)),$error)),'</strong></p>'));
if ( deAspis($inputs[0]['url']))
 {;
?>
	<p><label for="rss-url-<?php echo AspisCheckPrint($number);
;
?>"><?php _e(array('Enter the RSS feed URL here:',false));
;
?></label>
	<input class="widefat" id="rss-url-<?php echo AspisCheckPrint($number);
;
?>" name="widget-rss[<?php echo AspisCheckPrint($number);
;
?>][url]" type="text" value="<?php echo AspisCheckPrint($url);
;
?>" /></p>
<?php }if ( deAspis($inputs[0]['title']))
 {;
?>
	<p><label for="rss-title-<?php echo AspisCheckPrint($number);
;
?>"><?php _e(array('Give the feed a title (optional):',false));
;
?></label>
	<input class="widefat" id="rss-title-<?php echo AspisCheckPrint($number);
;
?>" name="widget-rss[<?php echo AspisCheckPrint($number);
;
?>][title]" type="text" value="<?php echo AspisCheckPrint($title);
;
?>" /></p>
<?php }if ( deAspis($inputs[0]['items']))
 {;
?>
	<p><label for="rss-items-<?php echo AspisCheckPrint($number);
;
?>"><?php _e(array('How many items would you like to display?',false));
;
?></label>
	<select id="rss-items-<?php echo AspisCheckPrint($number);
;
?>" name="widget-rss[<?php echo AspisCheckPrint($number);
;
?>][items]">
<?php for ( $i = array(1,false) ; ($i[0] <= (20)) ; preincr($i) )
echo AspisCheckPrint(concat(concat(concat2(concat1("<option value='",$i),"' "),(($items[0] == $i[0]) ? array("selected='selected'",false) : array('',false))),concat2(concat1(">",$i),"</option>")));
;
?>
	</select></p>
<?php }if ( deAspis($inputs[0]['show_summary']))
 {;
?>
	<p><input id="rss-show-summary-<?php echo AspisCheckPrint($number);
;
?>" name="widget-rss[<?php echo AspisCheckPrint($number);
;
?>][show_summary]" type="checkbox" value="1" <?php if ( $show_summary[0])
 echo AspisCheckPrint(array('checked="checked"',false));
;
?>/>
	<label for="rss-show-summary-<?php echo AspisCheckPrint($number);
;
?>"><?php _e(array('Display item content?',false));
;
?></label></p>
<?php }if ( deAspis($inputs[0]['show_author']))
 {;
?>
	<p><input id="rss-show-author-<?php echo AspisCheckPrint($number);
;
?>" name="widget-rss[<?php echo AspisCheckPrint($number);
;
?>][show_author]" type="checkbox" value="1" <?php if ( $show_author[0])
 echo AspisCheckPrint(array('checked="checked"',false));
;
?>/>
	<label for="rss-show-author-<?php echo AspisCheckPrint($number);
;
?>"><?php _e(array('Display item author if available?',false));
;
?></label></p>
<?php }if ( deAspis($inputs[0]['show_date']))
 {;
?>
	<p><input id="rss-show-date-<?php echo AspisCheckPrint($number);
;
?>" name="widget-rss[<?php echo AspisCheckPrint($number);
;
?>][show_date]" type="checkbox" value="1" <?php if ( $show_date[0])
 echo AspisCheckPrint(array('checked="checked"',false));
;
?>/>
	<label for="rss-show-date-<?php echo AspisCheckPrint($number);
;
?>"><?php _e(array('Display item date?',false));
;
?></label></p>
<?php }foreach ( deAspis(attAspisRC(array_keys(deAspisRC($default_inputs)))) as $input  )
{if ( (('hidden') === deAspis(attachAspis($inputs,$input[0]))))
 {$id = Aspis_str_replace(array('_',false),array('-',false),$input);
;
?>
	<input type="hidden" id="rss-<?php echo AspisCheckPrint($id);
;
?>-<?php echo AspisCheckPrint($number);
;
?>" name="widget-rss[<?php echo AspisCheckPrint($number);
;
?>][<?php echo AspisCheckPrint($input);
;
?>]" value="<?php echo AspisCheckPrint(${$input[0]});
;
?>" />
<?php }} }
function wp_widget_rss_process ( $widget_rss,$check_feed = array(true,false) ) {
$items = int_cast($widget_rss[0]['items']);
if ( (($items[0] < (1)) || ((20) < $items[0])))
 $items = array(10,false);
$url = esc_url_raw(Aspis_strip_tags($widget_rss[0]['url']));
$title = Aspis_trim(Aspis_strip_tags($widget_rss[0]['title']));
$show_summary = int_cast($widget_rss[0]['show_summary']);
$show_author = int_cast($widget_rss[0]['show_author']);
$show_date = int_cast($widget_rss[0]['show_date']);
if ( $check_feed[0])
 {$rss = fetch_feed($url);
$error = array(false,false);
$link = array('',false);
if ( deAspis(is_wp_error($rss)))
 {$error = $rss[0]->get_error_message();
}else 
{{$link = esc_url(Aspis_strip_tags($rss[0]->get_permalink()));
while ( (deAspis(Aspis_stristr($link,array('http',false))) != $link[0]) )
$link = Aspis_substr($link,array(1,false));
$rss[0]->__destruct();
unset($rss);
}}}return array(compact('title','url','link','items','error','show_summary','show_author','show_date'),false);
 }
class WP_Widget_Tag_Cloud extends WP_Widget{function WP_Widget_Tag_Cloud (  ) {
{$widget_ops = array(array(deregisterTaint(array('description',false)) => addTaint(__(array("Your most used tags in cloud format",false)))),false);
$this->WP_Widget(array('tag_cloud',false),__(array('Tag Cloud',false)),$widget_ops);
} }
function widget ( $args,$instance ) {
{extract(($args[0]));
$title = apply_filters(array('widget_title',false),((empty($instance[0][('title')]) || Aspis_empty( $instance [0][('title')]))) ? __(array('Tags',false)) : $instance[0]['title']);
echo AspisCheckPrint($before_widget);
if ( $title[0])
 echo AspisCheckPrint(concat(concat($before_title,$title),$after_title));
echo AspisCheckPrint(array('<div>',false));
wp_tag_cloud(apply_filters(array('widget_tag_cloud_args',false),array(array(),false)));
echo AspisCheckPrint(array("</div>\n",false));
echo AspisCheckPrint($after_widget);
} }
function update ( $new_instance,$old_instance ) {
{arrayAssign($instance[0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_strip_tags(Aspis_stripslashes($new_instance[0]['title']))));
return $instance;
} }
function form ( $instance ) {
{;
?>
	<p><label for="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>"><?php _e(array('Title:',false));
;
?></label>
	<input type="text" class="widefat" id="<?php echo AspisCheckPrint($this->get_field_id(array('title',false)));
;
?>" name="<?php echo AspisCheckPrint($this->get_field_name(array('title',false)));
;
?>" value="<?php if ( ((isset($instance[0][('title')]) && Aspis_isset( $instance [0][('title')]))))
 {echo AspisCheckPrint(esc_attr($instance[0]['title']));
};
?>" /></p>
<?php } }
}function wp_widgets_init (  ) {
if ( (denot_boolean(is_blog_installed())))
 return ;
register_widget(array('WP_Widget_Pages',false));
register_widget(array('WP_Widget_Calendar',false));
register_widget(array('WP_Widget_Archives',false));
register_widget(array('WP_Widget_Links',false));
register_widget(array('WP_Widget_Meta',false));
register_widget(array('WP_Widget_Search',false));
register_widget(array('WP_Widget_Text',false));
register_widget(array('WP_Widget_Categories',false));
register_widget(array('WP_Widget_Recent_Posts',false));
register_widget(array('WP_Widget_Recent_Comments',false));
register_widget(array('WP_Widget_RSS',false));
register_widget(array('WP_Widget_Tag_Cloud',false));
do_action(array('widgets_init',false));
 }
add_action(array('init',false),array('wp_widgets_init',false),array(1,false));
