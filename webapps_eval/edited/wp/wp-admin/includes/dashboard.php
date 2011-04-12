<?php require_once('AspisMain.php'); ?><?php
function wp_dashboard_setup (  ) {
global $wp_registered_widgets,$wp_registered_widget_controls,$wp_dashboard_control_callbacks;
$wp_dashboard_control_callbacks = array(array(),false);
$update = array(false,false);
$widget_options = get_option(array('dashboard_widget_options',false));
if ( ((denot_boolean($widget_options)) || (!(is_array($widget_options[0])))))
 $widget_options = array(array(),false);
wp_add_dashboard_widget(array('dashboard_right_now',false),__(array('Right Now',false)),array('wp_dashboard_right_now',false));
$recent_comments_title = __(array('Recent Comments',false));
wp_add_dashboard_widget(array('dashboard_recent_comments',false),$recent_comments_title,array('wp_dashboard_recent_comments',false));
if ( (((!((isset($widget_options[0][('dashboard_incoming_links')]) && Aspis_isset( $widget_options [0][('dashboard_incoming_links')])))) || (!((isset($widget_options[0][('dashboard_incoming_links')][0][('home')]) && Aspis_isset( $widget_options [0][('dashboard_incoming_links')] [0][('home')]))))) || (deAspis($widget_options[0][('dashboard_incoming_links')][0]['home']) != deAspis(get_option(array('home',false))))))
 {$update = array(true,false);
$num_items = ((isset($widget_options[0][('dashboard_incoming_links')][0][('items')]) && Aspis_isset( $widget_options [0][('dashboard_incoming_links')] [0][('items')]))) ? $widget_options[0][('dashboard_incoming_links')][0]['items'] : array(10,false);
arrayAssign($widget_options[0],deAspis(registerTaint(array('dashboard_incoming_links',false))),addTaint(array(array(deregisterTaint(array('home',false)) => addTaint(get_option(array('home',false))),deregisterTaint(array('link',false)) => addTaint(apply_filters(array('dashboard_incoming_links_link',false),concat1('http://blogsearch.google.com/blogsearch?scoring=d&partner=wordpress&q=link:',trailingslashit(get_option(array('home',false)))))),deregisterTaint(array('url',false)) => addTaint(((isset($widget_options[0][('dashboard_incoming_links')][0][('url')]) && Aspis_isset( $widget_options [0][('dashboard_incoming_links')] [0][('url')]))) ? apply_filters(array('dashboard_incoming_links_feed',false),$widget_options[0][('dashboard_incoming_links')][0]['url']) : apply_filters(array('dashboard_incoming_links_feed',false),concat(concat2(concat1('http://blogsearch.google.com/blogsearch_feeds?scoring=d&ie=utf-8&num=',$num_items),'&output=rss&partner=wordpress&q=link:'),trailingslashit(get_option(array('home',false)))))),deregisterTaint(array('items',false)) => addTaint($num_items),deregisterTaint(array('show_date',false)) => addTaint(((isset($widget_options[0][('dashboard_incoming_links')][0][('show_date')]) && Aspis_isset( $widget_options [0][('dashboard_incoming_links')] [0][('show_date')]))) ? $widget_options[0][('dashboard_incoming_links')][0]['show_date'] : array(false,false))),false)));
}wp_add_dashboard_widget(array('dashboard_incoming_links',false),__(array('Incoming Links',false)),array('wp_dashboard_incoming_links',false),array('wp_dashboard_incoming_links_control',false));
if ( deAspis(current_user_can(array('activate_plugins',false))))
 wp_add_dashboard_widget(array('dashboard_plugins',false),__(array('Plugins',false)),array('wp_dashboard_plugins',false));
if ( deAspis(current_user_can(array('edit_posts',false))))
 wp_add_dashboard_widget(array('dashboard_quick_press',false),__(array('QuickPress',false)),array('wp_dashboard_quick_press',false));
if ( deAspis(current_user_can(array('edit_posts',false))))
 wp_add_dashboard_widget(array('dashboard_recent_drafts',false),__(array('Recent Drafts',false)),array('wp_dashboard_recent_drafts',false));
if ( (!((isset($widget_options[0][('dashboard_primary')]) && Aspis_isset( $widget_options [0][('dashboard_primary')])))))
 {$update = array(true,false);
arrayAssign($widget_options[0],deAspis(registerTaint(array('dashboard_primary',false))),addTaint(array(array(deregisterTaint(array('link',false)) => addTaint(apply_filters(array('dashboard_primary_link',false),__(array('http://wordpress.org/development/',false)))),deregisterTaint(array('url',false)) => addTaint(apply_filters(array('dashboard_primary_feed',false),__(array('http://wordpress.org/development/feed/',false)))),deregisterTaint(array('title',false)) => addTaint(apply_filters(array('dashboard_primary_title',false),__(array('WordPress Development Blog',false)))),'items' => array(2,false,false),'show_summary' => array(1,false,false),'show_author' => array(0,false,false),'show_date' => array(1,false,false)),false)));
}wp_add_dashboard_widget(array('dashboard_primary',false),$widget_options[0][('dashboard_primary')][0]['title'],array('wp_dashboard_primary',false),array('wp_dashboard_primary_control',false));
if ( (!((isset($widget_options[0][('dashboard_secondary')]) && Aspis_isset( $widget_options [0][('dashboard_secondary')])))))
 {$update = array(true,false);
arrayAssign($widget_options[0],deAspis(registerTaint(array('dashboard_secondary',false))),addTaint(array(array(deregisterTaint(array('link',false)) => addTaint(apply_filters(array('dashboard_secondary_link',false),__(array('http://planet.wordpress.org/',false)))),deregisterTaint(array('url',false)) => addTaint(apply_filters(array('dashboard_secondary_feed',false),__(array('http://planet.wordpress.org/feed/',false)))),deregisterTaint(array('title',false)) => addTaint(apply_filters(array('dashboard_secondary_title',false),__(array('Other WordPress News',false)))),'items' => array(5,false,false)),false)));
}wp_add_dashboard_widget(array('dashboard_secondary',false),$widget_options[0][('dashboard_secondary')][0]['title'],array('wp_dashboard_secondary',false),array('wp_dashboard_secondary_control',false));
do_action(array('wp_dashboard_setup',false));
$dashboard_widgets = apply_filters(array('wp_dashboard_widgets',false),array(array(),false));
foreach ( $dashboard_widgets[0] as $widget_id  )
{$name = ((empty($wp_registered_widgets[0][$widget_id[0]][0][('all_link')]) || Aspis_empty( $wp_registered_widgets [0][$widget_id[0]] [0][('all_link')]))) ? $wp_registered_widgets[0][$widget_id[0]][0]['name'] : concat2(concat(concat($wp_registered_widgets[0][$widget_id[0]][0]['name'],concat2(concat1(" <a href='",$wp_registered_widgets[0][$widget_id[0]][0]['all_link']),"' class='edit-box open-box'>")),__(array('View all',false))),'</a>');
wp_add_dashboard_widget($widget_id,$name,$wp_registered_widgets[0][$widget_id[0]][0]['callback'],$wp_registered_widget_controls[0][$widget_id[0]][0]['callback']);
}if ( ((('POST') == deAspis($_SERVER[0]['REQUEST_METHOD'])) && ((isset($_POST[0][('widget_id')]) && Aspis_isset( $_POST [0][('widget_id')])))))
 {ob_start();
wp_dashboard_trigger_widget_control($_POST[0]['widget_id']);
ob_end_clean();
wp_redirect(remove_query_arg(array('edit',false)));
Aspis_exit();
}if ( $update[0])
 update_option(array('dashboard_widget_options',false),$widget_options);
do_action(array('do_meta_boxes',false),array('dashboard',false),array('normal',false),array('',false));
do_action(array('do_meta_boxes',false),array('dashboard',false),array('side',false),array('',false));
 }
function wp_add_dashboard_widget ( $widget_id,$widget_name,$callback,$control_callback = array(null,false) ) {
global $wp_dashboard_control_callbacks;
if ( (($control_callback[0] && deAspis(current_user_can(array('edit_dashboard',false)))) && is_callable(deAspisRC($control_callback))))
 {arrayAssign($wp_dashboard_control_callbacks[0],deAspis(registerTaint($widget_id)),addTaint($control_callback));
if ( (((isset($_GET[0][('edit')]) && Aspis_isset( $_GET [0][('edit')]))) && ($widget_id[0] == deAspis($_GET[0]['edit']))))
 {list($url) = deAspisList(Aspis_explode(array('#',false),add_query_arg(array('edit',false),array(false,false)),array(2,false)),array());
$widget_name = concat($widget_name,concat2(concat(concat2(concat1(' <span class="postbox-title-action"><a href="',esc_url($url)),'">'),__(array('Cancel',false))),'</a></span>'));
add_meta_box($widget_id,$widget_name,array('_wp_dashboard_control_callback',false),array('dashboard',false),array('normal',false),array('core',false));
return ;
}list($url) = deAspisList(Aspis_explode(array('#',false),add_query_arg(array('edit',false),$widget_id),array(2,false)),array());
$widget_name = concat($widget_name,concat2(concat(concat2(concat1(' <span class="postbox-title-action"><a href="',esc_url(concat(concat2($url,"#"),$widget_id))),'" class="edit-box open-box">'),__(array('Configure',false))),'</a></span>'));
}$side_widgets = array(array(array('dashboard_quick_press',false),array('dashboard_recent_drafts',false),array('dashboard_primary',false),array('dashboard_secondary',false)),false);
$location = array('normal',false);
if ( deAspis(Aspis_in_array($widget_id,$side_widgets)))
 $location = array('side',false);
add_meta_box($widget_id,$widget_name,$callback,array('dashboard',false),$location,array('core',false));
 }
function _wp_dashboard_control_callback ( $dashboard,$meta_box ) {
echo AspisCheckPrint(array('<form action="" method="post" class="dashboard-widget-control-form">',false));
wp_dashboard_trigger_widget_control($meta_box[0]['id']);
echo AspisCheckPrint(concat2(concat(concat2(concat1('<p class="submit"><input type="hidden" name="widget_id" value="',esc_attr($meta_box[0]['id'])),'" /><input type="submit" value="'),esc_attr__(array('Submit',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
 }
function wp_dashboard (  ) {
global $screen_layout_columns;
$hide2 = $hide3 = $hide4 = array('',false);
switch ( $screen_layout_columns[0] ) {
case (4):$width = array('width:24.5%;',false);
break ;
case (3):$width = array('width:32.67%;',false);
$hide4 = array('display:none;',false);
break ;
case (2):$width = array('width:49%;',false);
$hide3 = $hide4 = array('display:none;',false);
break ;
default :$width = array('width:98%;',false);
$hide2 = $hide3 = $hide4 = array('display:none;',false);
 }
;
?>
<div id="dashboard-widgets" class="metabox-holder">
<?php echo AspisCheckPrint(concat2(concat1("\t<div class='postbox-container' style='",$width),"'>\n"));
do_meta_boxes(array('dashboard',false),array('normal',false),array('',false));
echo AspisCheckPrint(concat2(concat1("\t</div><div class='postbox-container' style='",$hide2),"'>\n"));
do_meta_boxes(array('dashboard',false),array('side',false),array('',false));
echo AspisCheckPrint(concat2(concat1("\t</div><div class='postbox-container' style='",$hide3),"'>\n"));
do_meta_boxes(array('dashboard',false),array('column3',false),array('',false));
echo AspisCheckPrint(concat2(concat1("\t</div><div class='postbox-container' style='",$hide4),"'>\n"));
do_meta_boxes(array('dashboard',false),array('column4',false),array('',false));
;
?>
</div></div>

<form style="display:none" method="get" action="">
	<p>
<?php wp_nonce_field(array('closedpostboxes',false),array('closedpostboxesnonce',false),array(false,false));
wp_nonce_field(array('meta-box-order',false),array('meta-box-order-nonce',false),array(false,false));
;
?>
	</p>
</form>

<?php  }
function wp_dashboard_right_now (  ) {
global $wp_registered_sidebars;
$num_posts = wp_count_posts(array('post',false));
$num_pages = wp_count_posts(array('page',false));
$num_cats = wp_count_terms(array('category',false));
$num_tags = wp_count_terms(array('post_tag',false));
$num_comm = wp_count_comments();
echo AspisCheckPrint(concat2(concat(concat12("\n\t",'<p class="sub">'),__(array('At a Glance',false))),'</p>'));
echo AspisCheckPrint(concat2(concat2(concat12("\n\t",'<div class="table">'),"\n\t"),'<table>'));
echo AspisCheckPrint(concat12("\n\t",'<tr class="first">'));
$num = number_format_i18n($num_posts[0]->publish);
$text = _n(array('Post',false),array('Posts',false),Aspis_intval($num_posts[0]->publish));
if ( deAspis(current_user_can(array('edit_posts',false))))
 {$num = concat2(concat1("<a href='edit.php'>",$num),"</a>");
$text = concat2(concat1("<a href='edit.php'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="first b b-posts">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="t posts">',$text),'</td>'));
$num = concat2(concat1('<span class="total-count">',number_format_i18n($num_comm[0]->total_comments)),'</span>');
$text = _n(array('Comment',false),array('Comments',false),$num_comm[0]->total_comments);
if ( deAspis(current_user_can(array('moderate_comments',false))))
 {$num = concat2(concat1("<a href='edit-comments.php'>",$num),"</a>");
$text = concat2(concat1("<a href='edit-comments.php'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="b b-comments">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="last t comments">',$text),'</td>'));
echo AspisCheckPrint(array('</tr><tr>',false));
$num = number_format_i18n($num_pages[0]->publish);
$text = _n(array('Page',false),array('Pages',false),$num_pages[0]->publish);
if ( deAspis(current_user_can(array('edit_pages',false))))
 {$num = concat2(concat1("<a href='edit-pages.php'>",$num),"</a>");
$text = concat2(concat1("<a href='edit-pages.php'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="first b b_pages">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="t pages">',$text),'</td>'));
$num = concat2(concat1('<span class="approved-count">',number_format_i18n($num_comm[0]->approved)),'</span>');
$text = _nc(array('Approved|Right Now',false),array('Approved',false),$num_comm[0]->approved);
if ( deAspis(current_user_can(array('moderate_comments',false))))
 {$num = concat2(concat1("<a href='edit-comments.php?comment_status=approved'>",$num),"</a>");
$text = concat2(concat1("<a class='approved' href='edit-comments.php?comment_status=approved'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="b b_approved">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="last t">',$text),'</td>'));
echo AspisCheckPrint(array("</tr>\n\t<tr>",false));
$num = number_format_i18n($num_cats);
$text = _n(array('Category',false),array('Categories',false),$num_cats);
if ( deAspis(current_user_can(array('manage_categories',false))))
 {$num = concat2(concat1("<a href='categories.php'>",$num),"</a>");
$text = concat2(concat1("<a href='categories.php'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="first b b-cats">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="t cats">',$text),'</td>'));
$num = concat2(concat1('<span class="pending-count">',number_format_i18n($num_comm[0]->moderated)),'</span>');
$text = _n(array('Pending',false),array('Pending',false),$num_comm[0]->moderated);
if ( deAspis(current_user_can(array('moderate_comments',false))))
 {$num = concat2(concat1("<a href='edit-comments.php?comment_status=moderated'>",$num),"</a>");
$text = concat2(concat1("<a class='waiting' href='edit-comments.php?comment_status=moderated'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="b b-waiting">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="last t">',$text),'</td>'));
echo AspisCheckPrint(array("</tr>\n\t<tr>",false));
$num = number_format_i18n($num_tags);
$text = _n(array('Tag',false),array('Tags',false),$num_tags);
if ( deAspis(current_user_can(array('manage_categories',false))))
 {$num = concat2(concat1("<a href='edit-tags.php'>",$num),"</a>");
$text = concat2(concat1("<a href='edit-tags.php'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="first b b-tags">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="t tags">',$text),'</td>'));
$num = number_format_i18n($num_comm[0]->spam);
$text = _n(array('Spam',false),array('Spam',false),$num_comm[0]->spam);
if ( deAspis(current_user_can(array('moderate_comments',false))))
 {$num = concat2(concat1("<a href='edit-comments.php?comment_status=spam'><span class='spam-count'>",$num),"</span></a>");
$text = concat2(concat1("<a class='spam' href='edit-comments.php?comment_status=spam'>",$text),"</a>");
}echo AspisCheckPrint(concat2(concat1('<td class="b b-spam">',$num),'</td>'));
echo AspisCheckPrint(concat2(concat1('<td class="last t">',$text),'</td>'));
echo AspisCheckPrint(array("</tr>",false));
do_action(array('right_now_table_end',false));
echo AspisCheckPrint(array("\n\t</table>\n\t</div>",false));
echo AspisCheckPrint(concat12("\n\t",'<div class="versions">'));
$ct = current_theme_info();
echo AspisCheckPrint(array("\n\t<p>",false));
if ( (!((empty($wp_registered_sidebars) || Aspis_empty( $wp_registered_sidebars)))))
 {$sidebars_widgets = wp_get_sidebars_widgets();
$num_widgets = array(0,false);
foreach ( deAspis(array_cast($sidebars_widgets)) as $k =>$v )
{restoreTaint($k,$v);
{if ( (('wp_inactive_widgets') == $k[0]))
 continue ;
if ( is_array($v[0]))
 $num_widgets = array($num_widgets[0] + count($v[0]),false);
}}$num = number_format_i18n($num_widgets);
if ( deAspis(current_user_can(array('switch_themes',false))))
 {echo AspisCheckPrint(concat2(concat1('<a href="themes.php" class="button rbutton">',__(array('Change Theme',false))),'</a>'));
printf(deAspis(_n(array('Theme <span class="b"><a href="themes.php">%1$s</a></span> with <span class="b"><a href="widgets.php">%2$s Widget</a></span>',false),array('Theme <span class="b"><a href="themes.php">%1$s</a></span> with <span class="b"><a href="widgets.php">%2$s Widgets</a></span>',false),$num_widgets)),deAspisRC($ct[0]->title),deAspisRC($num));
}else 
{{printf(deAspis(_n(array('Theme <span class="b">%1$s</span> with <span class="b">%2$s Widget</span>',false),array('Theme <span class="b">%1$s</span> with <span class="b">%2$s Widgets</span>',false),$num_widgets)),deAspisRC($ct[0]->title),deAspisRC($num));
}}}else 
{{if ( deAspis(current_user_can(array('switch_themes',false))))
 {echo AspisCheckPrint(concat2(concat1('<a href="themes.php" class="button rbutton">',__(array('Change Theme',false))),'</a>'));
printf(deAspis(__(array('Theme <span class="b"><a href="themes.php">%1$s</a></span>',false))),deAspisRC($ct[0]->title));
}else 
{{printf(deAspis(__(array('Theme <span class="b">%1$s</span>',false))),deAspisRC($ct[0]->title));
}}}}echo AspisCheckPrint(array('</p>',false));
update_right_now_message();
echo AspisCheckPrint(concat12("\n\t",'<br class="clear" /></div>'));
do_action(array('rightnow_end',false));
do_action(array('activity_box_end',false));
 }
function wp_dashboard_quick_press (  ) {
$drafts = array(false,false);
if ( ((((('post') === deAspis(Aspis_strtolower($_SERVER[0]['REQUEST_METHOD']))) && ((isset($_POST[0][('action')]) && Aspis_isset( $_POST [0][('action')])))) && ((0) === strpos(deAspis($_POST[0]['action']),'post-quickpress'))) && deAspis(int_cast($_POST[0]['post_ID']))))
 {$view = get_permalink($_POST[0]['post_ID']);
$edit = esc_url(get_edit_post_link($_POST[0]['post_ID']));
if ( (('post-quickpress-publish') == deAspis($_POST[0]['action'])))
 {if ( deAspis(current_user_can(array('publish_posts',false))))
 printf((deconcat2(concat1('<div class="message"><p>',__(array('Post Published. <a href="%s">View post</a> | <a href="%s">Edit post</a>',false))),'</p></div>')),deAspisRC(esc_url($view)),deAspisRC($edit));
else 
{printf((deconcat2(concat1('<div class="message"><p>',__(array('Post submitted. <a href="%s">Preview post</a> | <a href="%s">Edit post</a>',false))),'</p></div>')),deAspisRC(esc_url(add_query_arg(array('preview',false),array(1,false),$view))),deAspisRC($edit));
}}else 
{{printf((deconcat2(concat1('<div class="message"><p>',__(array('Draft Saved. <a href="%s">Preview post</a> | <a href="%s">Edit post</a>',false))),'</p></div>')),deAspisRC(esc_url(add_query_arg(array('preview',false),array(1,false),$view))),deAspisRC($edit));
$drafts_query = array(new WP_Query(array(array('post_type' => array('post',false,false),'post_status' => array('draft',false,false),deregisterTaint(array('author',false)) => addTaint($GLOBALS[0][('current_user')][0]->ID),'posts_per_page' => array(1,false,false),'orderby' => array('modified',false,false),'order' => array('DESC',false,false)),false)),false);
if ( $drafts_query[0]->posts[0])
 $drafts = &$drafts_query[0]->posts;
}}printf((deconcat2(concat1('<p class="textright">',__(array('You can also try %s, easy blogging from anywhere on the Web.',false))),'</p>')),(deconcat2(concat1('<a href="tools.php">',__(array('Press This',false))),'</a>')));
$_REQUEST = array(array(),false);
}$post = get_default_post_to_edit();
;
?>

	<form name="post" action="<?php echo AspisCheckPrint(esc_url(admin_url(array('post.php',false))));
;
?>" method="post" id="quick-press">
		<h4 id="quick-post-title"><label for="title"><?php _e(array('Title',false));
?></label></h4>
		<div class="input-text-wrap">
			<input type="text" name="post_title" id="title" tabindex="1" autocomplete="off" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_title));
;
?>" />
		</div>

		<?php if ( deAspis(current_user_can(array('upload_files',false))))
 {;
?>
		<div id="media-buttons" class="hide-if-no-js">
			<?php do_action(array('media_buttons',false));
;
?>
		</div>
		<?php };
?>

		<h4 id="content-label"><label for="content"><?php _e(array('Content',false));
?></label></h4>
		<div class="textarea-wrap">
			<textarea name="content" id="content" class="mceEditor" rows="3" cols="15" tabindex="2"><?php echo AspisCheckPrint($post[0]->post_content);
;
?></textarea>
		</div>

		<script type="text/javascript">edCanvas = document.getElementById('content');edInsertContent = null;</script>

		<h4><label for="tags-input"><?php _e(array('Tags',false));
?></label></h4>
		<div class="input-text-wrap">
			<input type="text" name="tags_input" id="tags-input" tabindex="3" value="<?php echo AspisCheckPrint(get_tags_to_edit($post[0]->ID));
;
?>" />
		</div>

		<p class="submit">
			<input type="hidden" name="action" id="quickpost-action" value="post-quickpress-save" />
			<input type="hidden" name="quickpress_post_ID" value="<?php echo AspisCheckPrint(int_cast($post[0]->ID));
;
?>" />
			<?php wp_nonce_field(array('add-post',false));
;
?>
			<input type="submit" name="save" id="save-post" class="button" tabindex="4" value="<?php esc_attr_e(array('Save Draft',false));
;
?>" />
			<input type="reset" value="<?php esc_attr_e(array('Reset',false));
;
?>" class="button" />
			<?php if ( deAspis(current_user_can(array('publish_posts',false))))
 {;
?>
			<input type="submit" name="publish" id="publish" accesskey="p" tabindex="5" class="button-primary" value="<?php esc_attr_e(array('Publish',false));
;
?>" />
			<?php }else 
{{;
?>
			<input type="submit" name="publish" id="publish" accesskey="p" tabindex="5" class="button-primary" value="<?php esc_attr_e(array('Submit for Review',false));
;
?>" />
			<?php }};
?>
			<br class="clear" />
		</p>

	</form>

<?php if ( $drafts[0])
 wp_dashboard_recent_drafts($drafts);
 }
function wp_dashboard_recent_drafts ( $drafts = array(false,false) ) {
if ( (denot_boolean($drafts)))
 {$drafts_query = array(new WP_Query(array(array('post_type' => array('post',false,false),'post_status' => array('draft',false,false),deregisterTaint(array('author',false)) => addTaint($GLOBALS[0][('current_user')][0]->ID),'posts_per_page' => array(5,false,false),'orderby' => array('modified',false,false),'order' => array('DESC',false,false)),false)),false);
$drafts = &$drafts_query[0]->posts;
}if ( ($drafts[0] && is_array($drafts[0])))
 {$list = array(array(),false);
foreach ( $drafts[0] as $draft  )
{$url = get_edit_post_link($draft[0]->ID);
$title = _draft_or_post_title($draft[0]->ID);
$item = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<h4><a href='",$url),"' title='"),Aspis_sprintf(__(array('Edit &#8220;%s&#8221;',false)),esc_attr($title))),"'>"),esc_html($title)),"</a> <abbr title='"),get_the_time(__(array('Y/m/d g:i:s A',false)),$draft)),"'>"),get_the_time(get_option(array('date_format',false)),$draft)),'</abbr></h4>');
if ( deAspis($the_content = Aspis_preg_split(array('#\s#',false),Aspis_strip_tags($draft[0]->post_content),array(11,false),array(PREG_SPLIT_NO_EMPTY,false))))
 $item = concat($item,concat2(concat(concat1('<p>',Aspis_join(array(' ',false),Aspis_array_slice($the_content,array(0,false),array(10,false)))),(((10) < count($the_content[0])) ? array('&hellip;',false) : array('',false))),'</p>'));
arrayAssignAdd($list[0][],addTaint($item));
};
?>
	<ul>
		<li><?php echo AspisCheckPrint(Aspis_join(array("</li>\n<li>",false),$list));
;
?></li>
	</ul>
	<p class="textright"><a href="edit.php?post_status=draft" class="button"><?php _e(array('View all',false));
;
?></a></p>
<?php }else 
{{_e(array('There are no drafts at the moment',false));
}} }
function wp_dashboard_recent_comments (  ) {
global $wpdb;
if ( deAspis(current_user_can(array('edit_posts',false))))
 $allowed_states = array(array(array('0',false),array('1',false)),false);
else 
{$allowed_states = array(array(array('1',false)),false);
}$comments = array(array(),false);
$start = array(0,false);
while ( ((count($comments[0]) < (5)) && deAspis($possible = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," c LEFT JOIN "),$wpdb[0]->posts)," p ON c.comment_post_ID = p.ID WHERE p.post_status != 'trash' ORDER BY c.comment_date_gmt DESC LIMIT "),$start),", 50")))) )
{foreach ( $possible[0] as $comment  )
{if ( (count($comments[0]) >= (5)))
 break ;
if ( deAspis(Aspis_in_array($comment[0]->comment_approved,$allowed_states)))
 arrayAssignAdd($comments[0][],addTaint($comment));
}$start = array($start[0] + (50),false);
}if ( $comments[0])
 {;
?>

		<div id="the-comment-list" class="list:comment">
<?php foreach ( $comments[0] as $comment  )
_wp_dashboard_recent_comments_row($comment);
;
?>

		</div>

<?php if ( deAspis(current_user_can(array('edit_posts',false))))
 {;
?>
			<p class="textright"><a href="edit-comments.php" class="button"><?php _e(array('View all',false));
;
?></a></p>
<?php }wp_comment_reply(negate(array(1,false)),array(false,false),array('dashboard',false),array(false,false));
wp_comment_trashnotice();
}else 
{;
?>

	<p><?php _e(array('No comments yet.',false));
;
?></p>

<?php } }
function _wp_dashboard_recent_comments_row ( &$comment,$show_date = array(true,false) ) {
$GLOBALS[0][deAspis(registerTaint(array('comment',false)))] = &addTaintR($comment);
$comment_post_url = get_edit_post_link($comment[0]->comment_post_ID);
$comment_post_title = Aspis_strip_tags(get_the_title($comment[0]->comment_post_ID));
$comment_post_link = concat2(concat(concat2(concat1("<a href='",$comment_post_url),"'>"),$comment_post_title),"</a>");
$comment_link = concat2(concat1('<a class="comment-link" href="',esc_url(get_comment_link())),'">#</a>');
$actions_string = array('',false);
if ( deAspis(current_user_can(array('edit_post',false),$comment[0]->comment_post_ID)))
 {$actions = array(array('approve' => array('',false,false),'unapprove' => array('',false,false),'reply' => array('',false,false),'edit' => array('',false,false),'spam' => array('',false,false),'trash' => array('',false,false),'delete' => array('',false,false)),false);
$del_nonce = esc_html(concat1('_wpnonce=',wp_create_nonce(concat1("delete-comment_",$comment[0]->comment_ID))));
$approve_nonce = esc_html(concat1('_wpnonce=',wp_create_nonce(concat1("approve-comment_",$comment[0]->comment_ID))));
$approve_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=approvecomment&p=",$comment[0]->comment_post_ID),"&c="),$comment[0]->comment_ID),"&"),$approve_nonce));
$unapprove_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=unapprovecomment&p=",$comment[0]->comment_post_ID),"&c="),$comment[0]->comment_ID),"&"),$approve_nonce));
$spam_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=spamcomment&p=",$comment[0]->comment_post_ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
$trash_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=trashcomment&p=",$comment[0]->comment_post_ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
$delete_url = esc_url(concat(concat2(concat(concat2(concat1("comment.php?action=deletecomment&p=",$comment[0]->comment_post_ID),"&c="),$comment[0]->comment_ID),"&"),$del_nonce));
arrayAssign($actions[0],deAspis(registerTaint(array('approve',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$approve_url),"' class='dim:the-comment-list:comment-"),$comment[0]->comment_ID),":unapproved:e7e7d3:e7e7d3:new=approved vim-a' title='"),__(array('Approve this comment',false))),"'>"),__(array('Approve',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('unapprove',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$unapprove_url),"' class='dim:the-comment-list:comment-"),$comment[0]->comment_ID),":unapproved:e7e7d3:e7e7d3:new=unapproved vim-u' title='"),__(array('Unapprove this comment',false))),"'>"),__(array('Unapprove',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('edit',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a href='comment.php?action=editcomment&amp;c=",$comment[0]->comment_ID),"' title='"),__(array('Edit comment',false))),"'>"),__(array('Edit',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('reply',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<a onclick="commentReply.open(\'',$comment[0]->comment_ID),'\',\''),$comment[0]->comment_post_ID),'\');return false;" class="vim-r hide-if-no-js" title="'),__(array('Reply to this comment',false))),'" href="#">'),__(array('Reply',false))),'</a>')));
arrayAssign($actions[0],deAspis(registerTaint(array('spam',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$spam_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),"::spam=1 vim-s vim-destructive' title='"),__(array('Mark this comment as spam',false))),"'>"),_x(array('Spam',false),array('verb',false))),'</a>')));
if ( (!(EMPTY_TRASH_DAYS)))
 arrayAssign($actions[0],deAspis(registerTaint(array('delete',false))),addTaint(concat2(concat(concat2(concat(concat2(concat1("<a href='",$delete_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),"::trash=1 delete vim-d vim-destructive'>"),__(array('Delete Permanently',false))),'</a>')));
else 
{arrayAssign($actions[0],deAspis(registerTaint(array('trash',false))),addTaint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<a href='",$trash_url),"' class='delete:the-comment-list:comment-"),$comment[0]->comment_ID),"::trash=1 delete vim-d vim-destructive' title='"),__(array('Move this comment to the trash',false))),"'>"),_x(array('Trash',false),array('verb',false))),'</a>')));
}$actions = apply_filters(array('comment_row_actions',false),attAspisRC(array_filter(deAspisRC($actions))),$comment);
$i = array(0,false);
foreach ( $actions[0] as $action =>$link )
{restoreTaint($action,$link);
{preincr($i);
((((('approve') == $action[0]) || (('unapprove') == $action[0])) && ((2) === $i[0])) || ((1) === $i[0])) ? $sep = array('',false) : $sep = array(' | ',false);
if ( ((('reply') == $action[0]) || (('quickedit') == $action[0])))
 $action = concat2($action,' hide-if-no-js');
$actions_string = concat($actions_string,concat2(concat(concat(concat2(concat1("<span class='",$action),"'>"),$sep),$link),"</span>"));
}}};
?>

		<div id="comment-<?php echo AspisCheckPrint($comment[0]->comment_ID);
;
?>" <?php comment_class(array(array(array('comment-item',false),wp_get_comment_status($comment[0]->comment_ID)),false));
;
?>>
			<?php if ( ((denot_boolean($comment[0]->comment_type)) || (('comment') == $comment[0]->comment_type[0])))
 {;
?>

			<?php echo AspisCheckPrint(get_avatar($comment,array(50,false)));
;
?>

			<div class="dashboard-comment-wrap">
			<h4 class="comment-meta"><?php printf(deAspis(__(array('From %1$s on %2$s%3$s',false))),(deconcat2(concat1('<cite class="comment-author">',get_comment_author_link()),'</cite>')),(deconcat(concat2($comment_post_link,' '),$comment_link)),(deconcat2(concat1(' <span class="approve">',__(array('[Pending]',false))),'</span>')));
;
?></h4>

			<?php }else 
{switch ( $comment[0]->comment_type[0] ) {
case ('pingback'):$type = __(array('Pingback',false));
break ;
;
case ('trackback'):$type = __(array('Trackback',false));
break ;
default :$type = Aspis_ucwords($comment[0]->comment_type);
 }
$type = esc_html($type);
;
?>
			<div class="dashboard-comment-wrap">
			<?php ;
?>
			<h4 class="comment-meta"><?php printf(deAspis(_x(array('%1$s on %2$s',false),array('dashboard',false))),(deconcat2(concat1("<strong>",$type),"</strong>")),(deconcat(concat2($comment_post_link," "),$comment_link)));
;
?></h4>
			<p class="comment-author"><?php comment_author_link();
;
?></p>

			<?php };
?>
			<blockquote><p><?php comment_excerpt();
;
?></p></blockquote>
			<p class="row-actions"><?php echo AspisCheckPrint($actions_string);
;
?></p>
			</div>
		</div>
<?php  }
function wp_dashboard_incoming_links (  ) {
echo AspisCheckPrint(concat2(concat(concat2(concat1('<p class="widget-loading hide-if-no-js">',__(array('Loading&#8230;',false))),'</p><p class="describe hide-if-js">'),__(array('This widget requires JavaScript.',false))),'</p>'));
 }
function wp_dashboard_incoming_links_output (  ) {
$widgets = get_option(array('dashboard_widget_options',false));
@attAspis(extract((deAspis(@$widgets[0]['dashboard_incoming_links'])),EXTR_SKIP));
$rss = fetch_feed($url);
if ( deAspis(is_wp_error($rss)))
 {if ( (deAspis(is_admin()) || deAspis(current_user_can(array('manage_options',false)))))
 {echo AspisCheckPrint(array('<p>',false));
printf(deAspis(__(array('<strong>RSS Error</strong>: %s',false))),deAspisRC($rss[0]->get_error_message()));
echo AspisCheckPrint(array('</p>',false));
}return ;
}if ( (denot_boolean($rss[0]->get_item_quantity())))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('This dashboard widget queries <a href="http://blogsearch.google.com/">Google Blog Search</a> so that when another blog links to your site it will show up here. It has found no incoming links&hellip; yet. It&#8217;s okay &#8212; there is no rush.',false))),"</p>\n"));
$rss[0]->__destruct();
unset($rss);
return ;
}echo AspisCheckPrint(array("<ul>\n",false));
if ( (!((isset($items) && Aspis_isset( $items)))))
 $items = array(10,false);
foreach ( deAspis($rss[0]->get_items(array(0,false),$items)) as $item  )
{$publisher = array('',false);
$site_link = array('',false);
$link = array('',false);
$content = array('',false);
$date = array('',false);
$link = esc_url(Aspis_strip_tags($item[0]->get_link()));
$author = $item[0]->get_author();
if ( $author[0])
 {$site_link = esc_url(Aspis_strip_tags($author[0]->get_link()));
if ( (denot_boolean($publisher = esc_html(Aspis_strip_tags($author[0]->get_name())))))
 $publisher = __(array('Somebody',false));
}else 
{{$publisher = __(array('Somebody',false));
}}if ( $site_link[0])
 $publisher = concat2(concat(concat2(concat1("<a href='",$site_link),"'>"),$publisher),"</a>");
else 
{$publisher = concat2(concat1("<strong>",$publisher),"</strong>");
}$content = $item[0]->get_content();
$content = concat2(wp_html_excerpt($content,array(50,false)),' ...');
if ( $link[0])
 $text = __(array('%1$s linked here <a href="%2$s">saying</a>, "%3$s"',false));
else 
{$text = __(array('%1$s linked here saying, "%3$s"',false));
}if ( $show_date[0])
 {if ( ($show_author[0] || $show_summary[0]))
 $text = concat($text,concat1(' ',__(array('on %4$s',false))));
$date = esc_html(Aspis_strip_tags($item[0]->get_date()));
$date = attAspis(strtotime($date[0]));
$date = attAspis(gmdate(deAspis(get_option(array('date_format',false))),$date[0]));
}echo AspisCheckPrint(concat2(concat1("\t<li>",Aspis_sprintf($text,$publisher,$link,$content,$date)),"</li>\n"));
}echo AspisCheckPrint(array("</ul>\n",false));
$rss[0]->__destruct();
unset($rss);
 }
function wp_dashboard_incoming_links_control (  ) {
wp_dashboard_rss_control(array('dashboard_incoming_links',false),array(array('title' => array(false,false,false),'show_summary' => array(false,false,false),'show_author' => array(false,false,false)),false));
 }
function wp_dashboard_primary (  ) {
echo AspisCheckPrint(concat2(concat(concat2(concat1('<p class="widget-loading hide-if-no-js">',__(array('Loading&#8230;',false))),'</p><p class="describe hide-if-js">'),__(array('This widget requires JavaScript.',false))),'</p>'));
 }
function wp_dashboard_primary_control (  ) {
wp_dashboard_rss_control(array('dashboard_primary',false));
 }
function wp_dashboard_rss_output ( $widget_id ) {
$widgets = get_option(array('dashboard_widget_options',false));
echo AspisCheckPrint(array('<div class="rss-widget">',false));
wp_widget_rss_output(attachAspis($widgets,$widget_id[0]));
echo AspisCheckPrint(array("</div>",false));
 }
function wp_dashboard_secondary (  ) {
echo AspisCheckPrint(concat2(concat(concat2(concat1('<p class="widget-loading hide-if-no-js">',__(array('Loading&#8230;',false))),'</p><p class="describe hide-if-js">'),__(array('This widget requires JavaScript.',false))),'</p>'));
 }
function wp_dashboard_secondary_control (  ) {
wp_dashboard_rss_control(array('dashboard_secondary',false));
 }
function wp_dashboard_secondary_output (  ) {
$widgets = get_option(array('dashboard_widget_options',false));
@attAspis(extract((deAspis(@$widgets[0]['dashboard_secondary'])),EXTR_SKIP));
$rss = @fetch_feed($url);
if ( deAspis(is_wp_error($rss)))
 {if ( (deAspis(is_admin()) || deAspis(current_user_can(array('manage_options',false)))))
 {echo AspisCheckPrint(array('<div class="rss-widget"><p>',false));
printf(deAspis(__(array('<strong>RSS Error</strong>: %s',false))),deAspisRC($rss[0]->get_error_message()));
echo AspisCheckPrint(array('</p></div>',false));
}}elseif ( (denot_boolean($rss[0]->get_item_quantity())))
 {$rss[0]->__destruct();
unset($rss);
return array(false,false);
}else 
{{echo AspisCheckPrint(array('<div class="rss-widget">',false));
wp_widget_rss_output($rss,$widgets[0]['dashboard_secondary']);
echo AspisCheckPrint(array('</div>',false));
$rss[0]->__destruct();
unset($rss);
}} }
function wp_dashboard_plugins (  ) {
echo AspisCheckPrint(concat2(concat(concat2(concat1('<p class="widget-loading hide-if-no-js">',__(array('Loading&#8230;',false))),'</p><p class="describe hide-if-js">'),__(array('This widget requires JavaScript.',false))),'</p>'));
 }
function wp_dashboard_plugins_output (  ) {
$popular = fetch_feed(array('http://wordpress.org/extend/plugins/rss/browse/popular/',false));
$new = fetch_feed(array('http://wordpress.org/extend/plugins/rss/browse/new/',false));
$updated = fetch_feed(array('http://wordpress.org/extend/plugins/rss/browse/updated/',false));
if ( (false === deAspis($plugin_slugs = get_transient(array('plugin_slugs',false)))))
 {$plugin_slugs = attAspisRC(array_keys(deAspisRC(get_plugins())));
set_transient(array('plugin_slugs',false),$plugin_slugs,array(86400,false));
}foreach ( (array(deregisterTaint(array('popular',false)) => addTaint(__(array('Most Popular',false))),deregisterTaint(array('new',false)) => addTaint(__(array('Newest Plugins',false))),deregisterTaint(array('updated',false)) => addTaint(__(array('Recently Updated',false))))) as $feed =>$label )
{restoreTaint($feed,$label);
{if ( (deAspis(is_wp_error(${$feed[0]})) || (denot_boolean(${$feed[0]}[0]->get_item_quantity()))))
 continue ;
$items = ${$feed[0]}[0]->get_items(array(0,false),array(5,false));
while ( true )
{if ( ((0) == count($items[0])))
 continue (2);
$item_key = Aspis_array_rand($items);
$item = attachAspis($items,$item_key[0]);
list($link,$frag) = deAspisList(Aspis_explode(array('#',false),$item[0]->get_link()),array());
$link = esc_url($link);
if ( deAspis(Aspis_preg_match(array('|/([^/]+?)/?$|',false),$link,$matches)))
 $slug = attachAspis($matches,(1));
else 
{{unset($items[0][$item_key[0]]);
continue ;
}}Aspis_reset($plugin_slugs);
foreach ( $plugin_slugs[0] as $plugin_slug  )
{if ( ($slug[0] == deAspis(Aspis_substr($plugin_slug,array(0,false),attAspis(strlen($slug[0]))))))
 {unset($items[0][$item_key[0]]);
continue (2);
}}break ;
}while ( ((null !== deAspis($item_key = Aspis_array_rand($items))) && (false !== strpos(deAspis($items[0][$item_key[0]][0]->get_description()),'Plugin Name:'))) )
unset($items[0][$item_key[0]]);
if ( (!((isset($items[0][$item_key[0]]) && Aspis_isset( $items [0][$item_key[0]])))))
 continue ;
if ( deAspis(Aspis_preg_match(array('/&quot;(.*)&quot;/s',false),$item[0]->get_title(),$matches)))
 $title = attachAspis($matches,(1));
else 
{$title = $item[0]->get_title();
}$title = esc_html($title);
$description = esc_html(Aspis_strip_tags(@Aspis_html_entity_decode($item[0]->get_description(),array(ENT_QUOTES,false),get_option(array('blog_charset',false)))));
$ilink = concat2(wp_nonce_url(concat1('plugin-install.php?tab=plugin-information&plugin=',$slug),concat1('install-plugin_',$slug)),'&amp;TB_iframe=true&amp;width=600&amp;height=800');
echo AspisCheckPrint(concat2(concat1("<h4>",$label),"</h4>\n"));
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<h5><a href='",$link),"'>"),$title),"</a></h5>&nbsp;<span>(<a href='"),$ilink),"' class='thickbox' title='"),$title),"'>"),__(array('Install',false))),"</a>)</span>\n"));
echo AspisCheckPrint(concat2(concat1("<p>",$description),"</p>\n"));
${$feed[0]}[0]->__destruct();
unset(${$feed[0]});
}} }
function wp_dashboard_cached_rss_widget ( $widget_id,$callback,$check_urls = array(array(),false) ) {
$loading = concat2(concat1('<p class="widget-loading">',__(array('Loading&#8230;',false))),'</p>');
if ( ((empty($check_urls) || Aspis_empty( $check_urls))))
 {$widgets = get_option(array('dashboard_widget_options',false));
if ( ((empty($widgets[0][$widget_id[0]][0][('url')]) || Aspis_empty( $widgets [0][$widget_id[0]] [0][('url')]))))
 {echo AspisCheckPrint($loading);
return array(false,false);
}$check_urls = array(array($widgets[0][$widget_id[0]][0]['url']),false);
}include_once (deconcat2(concat12(ABSPATH,WPINC),'/class-feed.php'));
foreach ( $check_urls[0] as $check_url  )
{$cache = array(new WP_Feed_Cache_Transient(array('',false),attAspis(md5($check_url[0])),array('',false)),false);
if ( (denot_boolean($cache[0]->load())))
 {echo AspisCheckPrint($loading);
return array(false,false);
}}if ( ($callback[0] && is_callable(deAspisRC($callback))))
 {$args = Aspis_array_slice(array(func_get_args(),false),array(2,false));
Aspis_array_unshift($args,$widget_id);
Aspis_call_user_func_array($callback,$args);
}return array(true,false);
 }
function wp_dashboard_trigger_widget_control ( $widget_control_id = array(false,false) ) {
global $wp_dashboard_control_callbacks;
if ( (((is_scalar(deAspisRC($widget_control_id)) && $widget_control_id[0]) && ((isset($wp_dashboard_control_callbacks[0][$widget_control_id[0]]) && Aspis_isset( $wp_dashboard_control_callbacks [0][$widget_control_id[0]])))) && is_callable(deAspisRC(attachAspis($wp_dashboard_control_callbacks,$widget_control_id[0])))))
 {Aspis_call_user_func(attachAspis($wp_dashboard_control_callbacks,$widget_control_id[0]),array('',false),array(array(deregisterTaint(array('id',false)) => addTaint($widget_control_id),deregisterTaint(array('callback',false)) => addTaint(attachAspis($wp_dashboard_control_callbacks,$widget_control_id[0]))),false));
} }
function wp_dashboard_rss_control ( $widget_id,$form_inputs = array(array(),false) ) {
if ( (denot_boolean($widget_options = get_option(array('dashboard_widget_options',false)))))
 $widget_options = array(array(),false);
if ( (!((isset($widget_options[0][$widget_id[0]]) && Aspis_isset( $widget_options [0][$widget_id[0]])))))
 arrayAssign($widget_options[0],deAspis(registerTaint($widget_id)),addTaint(array(array(),false)));
$number = array(1,false);
arrayAssign($widget_options[0][$widget_id[0]][0],deAspis(registerTaint(array('number',false))),addTaint($number));
if ( ((('POST') == deAspis($_SERVER[0]['REQUEST_METHOD'])) && ((isset($_POST[0][('widget-rss')][0][$number[0]]) && Aspis_isset( $_POST [0][('widget-rss')] [0][$number[0]])))))
 {arrayAssign($_POST[0][('widget-rss')][0],deAspis(registerTaint($number)),addTaint(stripslashes_deep(attachAspis($_POST[0][('widget-rss')],$number[0]))));
arrayAssign($widget_options[0],deAspis(registerTaint($widget_id)),addTaint(wp_widget_rss_process(attachAspis($_POST[0][('widget-rss')],$number[0]))));
if ( ((denot_boolean($widget_options[0][$widget_id[0]][0]['title'])) && ((isset($_POST[0][('widget-rss')][0][$number[0]][0][('title')]) && Aspis_isset( $_POST [0][('widget-rss')] [0][$number[0]] [0][('title')])))))
 {$rss = fetch_feed($widget_options[0][$widget_id[0]][0]['url']);
if ( deAspis(is_wp_error($rss)))
 {arrayAssign($widget_options[0][$widget_id[0]][0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_htmlentities(__(array('Unknown Feed',false)))));
}else 
{{arrayAssign($widget_options[0][$widget_id[0]][0],deAspis(registerTaint(array('title',false))),addTaint(Aspis_htmlentities(Aspis_strip_tags($rss[0]->get_title()))));
$rss[0]->__destruct();
unset($rss);
}}}update_option(array('dashboard_widget_options',false),$widget_options);
}wp_widget_rss_form(attachAspis($widget_options,$widget_id[0]),$form_inputs);
 }
function wp_dashboard_empty (  ) {
 }
;
?>
<?php 