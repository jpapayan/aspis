<?php require_once('AspisMain.php'); ?><?php
function post_submit_meta_box ( $post ) {
global $action;
$post_type = $post[0]->post_type;
$can_publish = current_user_can(concat2(concat1("publish_",$post_type),"s"));
;
?>
<div class="submitbox" id="submitpost">

<div id="minor-publishing">

<?php ;
?>
<div style="display:none;">
<input type="submit" name="save" value="<?php esc_attr_e(array('Save',false));
;
?>" />
</div>

<div id="minor-publishing-actions">
<div id="save-action">
<?php if ( (((('publish') != $post[0]->post_status[0]) && (('future') != $post[0]->post_status[0])) && (('pending') != $post[0]->post_status[0])))
 {;
?>
<input <?php if ( (('private') == $post[0]->post_status[0]))
 {;
?>style="display:none"<?php };
?> type="submit" name="save" id="save-post" value="<?php esc_attr_e(array('Save Draft',false));
;
?>" tabindex="4" class="button button-highlighted" />
<?php }elseif ( ((('pending') == $post[0]->post_status[0]) && $can_publish[0]))
 {;
?>
<input type="submit" name="save" id="save-post" value="<?php esc_attr_e(array('Save as Pending',false));
;
?>" tabindex="4" class="button button-highlighted" />
<?php };
?>
</div>

<div id="preview-action">
<?php if ( (('publish') == $post[0]->post_status[0]))
 {$preview_link = esc_url(get_permalink($post[0]->ID));
$preview_button = __(array('Preview Changes',false));
}else 
{{$preview_link = esc_url(apply_filters(array('preview_post_link',false),add_query_arg(array('preview',false),array('true',false),get_permalink($post[0]->ID))));
$preview_button = __(array('Preview',false));
}};
?>
<a class="preview button" href="<?php echo AspisCheckPrint($preview_link);
;
?>" target="wp-preview" id="post-preview" tabindex="4"><?php echo AspisCheckPrint($preview_button);
;
?></a>
<input type="hidden" name="wp-preview" id="wp-preview" value="" />
</div>

<div class="clear"></div>
</div><?php ;
?>

<div id="misc-publishing-actions">

<div class="misc-pub-section<?php if ( (denot_boolean($can_publish)))
 {echo AspisCheckPrint(array(' misc-pub-section-last',false));
};
?>"><label for="post_status"><?php _e(array('Status:',false));
?></label>
<span id="post-status-display">
<?php switch ( $post[0]->post_status[0] ) {
case ('private'):_e(array('Privately Published',false));
break ;
case ('publish'):_e(array('Published',false));
break ;
case ('future'):_e(array('Scheduled',false));
break ;
case ('pending'):_e(array('Pending Review',false));
break ;
case ('draft'):_e(array('Draft',false));
break ;
 }
;
?>
</span>
<?php if ( (((('publish') == $post[0]->post_status[0]) || (('private') == $post[0]->post_status[0])) || $can_publish[0]))
 {;
?>
<a href="#post_status" <?php if ( (('private') == $post[0]->post_status[0]))
 {;
?>style="display:none;" <?php };
?>class="edit-post-status hide-if-no-js" tabindex='4'><?php _e(array('Edit',false));
?></a>

<div id="post-status-select" class="hide-if-js">
<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_status));
;
?>" />
<select name='post_status' id='post_status' tabindex='4'>
<?php if ( (('publish') == $post[0]->post_status[0]))
 {;
?>
<option<?php selected($post[0]->post_status,array('publish',false));
;
?> value='publish'><?php _e(array('Published',false));
?></option>
<?php }elseif ( (('private') == $post[0]->post_status[0]))
 {;
?>
<option<?php selected($post[0]->post_status,array('private',false));
;
?> value='publish'><?php _e(array('Privately Published',false));
?></option>
<?php }elseif ( (('future') == $post[0]->post_status[0]))
 {;
?>
<option<?php selected($post[0]->post_status,array('future',false));
;
?> value='future'><?php _e(array('Scheduled',false));
?></option>
<?php };
?>
<option<?php selected($post[0]->post_status,array('pending',false));
;
?> value='pending'><?php _e(array('Pending Review',false));
?></option>
<option<?php selected($post[0]->post_status,array('draft',false));
;
?> value='draft'><?php _e(array('Draft',false));
?></option>
</select>
 <a href="#post_status" class="save-post-status hide-if-no-js button"><?php _e(array('OK',false));
;
?></a>
 <a href="#post_status" class="cancel-post-status hide-if-no-js"><?php _e(array('Cancel',false));
;
?></a>
</div>

<?php };
?>
</div><?php ;
?>

<div class="misc-pub-section " id="visibility">
<?php _e(array('Visibility:',false));
;
?> <span id="post-visibility-display"><?php if ( (('private') == $post[0]->post_status[0]))
 {$post[0]->post_password = array('',false);
$visibility = array('private',false);
$visibility_trans = __(array('Private',false));
}elseif ( (!((empty($post[0]->post_password) || Aspis_empty( $post[0] ->post_password )))))
 {$visibility = array('password',false);
$visibility_trans = __(array('Password protected',false));
}elseif ( (($post_type[0] == ('post')) && deAspis(is_sticky($post[0]->ID))))
 {$visibility = array('public',false);
$visibility_trans = __(array('Public, Sticky',false));
}else 
{{$visibility = array('public',false);
$visibility_trans = __(array('Public',false));
}}echo AspisCheckPrint(esc_html($visibility_trans));
;
?></span>
<?php if ( $can_publish[0])
 {;
?>
<a href="#visibility" class="edit-visibility hide-if-no-js"><?php _e(array('Edit',false));
;
?></a>

<div id="post-visibility-select" class="hide-if-js">
<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_password));
;
?>" />
<?php if ( ($post_type[0] == ('post')))
 {;
?>
<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky" <?php checked(is_sticky($post[0]->ID));
;
?> />
<?php };
?>
<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="<?php echo AspisCheckPrint(esc_attr($visibility));
;
?>" />


<input type="radio" name="visibility" id="visibility-radio-public" value="public" <?php checked($visibility,array('public',false));
;
?> /> <label for="visibility-radio-public" class="selectit"><?php _e(array('Public',false));
;
?></label><br />
<?php if ( ($post_type[0] == ('post')))
 {;
?>
<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky" <?php checked(is_sticky($post[0]->ID));
;
?> tabindex="4" /> <label for="sticky" class="selectit"><?php _e(array('Stick this post to the front page',false));
?></label><br /></span>
<?php };
?>
<input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php checked($visibility,array('password',false));
;
?> /> <label for="visibility-radio-password" class="selectit"><?php _e(array('Password protected',false));
;
?></label><br />
<span id="password-span"><label for="post_password"><?php _e(array('Password:',false));
;
?></label> <input type="text" name="post_password" id="post_password" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_password));
;
?>" /><br /></span>
<input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php checked($visibility,array('private',false));
;
?> /> <label for="visibility-radio-private" class="selectit"><?php _e(array('Private',false));
;
?></label><br />

<p>
 <a href="#visibility" class="save-post-visibility hide-if-no-js button"><?php _e(array('OK',false));
;
?></a>
 <a href="#visibility" class="cancel-post-visibility hide-if-no-js"><?php _e(array('Cancel',false));
;
?></a>
</p>
</div>
<?php };
?>

</div><?php ;
?>


<?php $datef = __(array('M j, Y @ G:i',false));
if ( ((0) != $post[0]->ID[0]))
 {if ( (('future') == $post[0]->post_status[0]))
 {$stamp = __(array('Scheduled for: <b>%1$s</b>',false));
}else 
{if ( ((('publish') == $post[0]->post_status[0]) || (('private') == $post[0]->post_status[0])))
 {$stamp = __(array('Published on: <b>%1$s</b>',false));
}else 
{if ( (('0000-00-00 00:00:00') == $post[0]->post_date_gmt[0]))
 {$stamp = __(array('Publish <b>immediately</b>',false));
}else 
{if ( (time() < strtotime((deconcat2($post[0]->post_date_gmt,' +0000')))))
 {$stamp = __(array('Schedule for: <b>%1$s</b>',false));
}else 
{{$stamp = __(array('Publish on: <b>%1$s</b>',false));
}}}}}$date = date_i18n($datef,attAspis(strtotime($post[0]->post_date[0])));
}else 
{{$stamp = __(array('Publish <b>immediately</b>',false));
$date = date_i18n($datef,attAspis(strtotime(deAspis(current_time(array('mysql',false))))));
}}if ( $can_publish[0])
 {;
?>
<div class="misc-pub-section curtime misc-pub-section-last">
	<span id="timestamp">
	<?php printf($stamp[0],deAspisRC($date));
;
?></span>
	<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" tabindex='4'><?php _e(array('Edit',false));
?></a>
	<div id="timestampdiv" class="hide-if-js"><?php touch_time((array($action[0] == ('edit'),false)),array(1,false),array(4,false));
;
?></div>
</div><?php ;
?>
<?php };
?>

<?php do_action(array('post_submitbox_misc_actions',false));
;
?>
</div>
<div class="clear"></div>
</div>

<div id="major-publishing-actions">
<?php do_action(array('post_submitbox_start',false));
;
?>
<div id="delete-action">
<?php if ( deAspis(current_user_can(concat1("delete_",$post_type),$post[0]->ID)))
 {if ( (!(EMPTY_TRASH_DAYS)))
 {$delete_url = wp_nonce_url(add_query_arg(array(array('action' => array('delete',false,false),deregisterTaint(array('post',false)) => addTaint($post[0]->ID)),false)),concat(concat2(concat1("delete-",$post_type),"_"),$post[0]->ID));
$delete_text = __(array('Delete Permanently',false));
}else 
{{$delete_url = wp_nonce_url(add_query_arg(array(array('action' => array('trash',false,false),deregisterTaint(array('post',false)) => addTaint($post[0]->ID)),false)),concat(concat2(concat1("trash-",$post_type),"_"),$post[0]->ID));
$delete_text = __(array('Move to Trash',false));
}};
?>
<a class="submitdelete deletion<?php if ( (('edit') != $action[0]))
 {echo AspisCheckPrint(array(" hidden",false));
};
?>" href="<?php echo AspisCheckPrint($delete_url);
;
?>"><?php echo AspisCheckPrint($delete_text);
;
?></a><?php };
?>
</div>

<div id="publishing-action">
<img src="images/wpspin_light.gif" id="ajax-loading" style="visibility:hidden;" alt="" />
<?php if ( ((denot_boolean(Aspis_in_array($post[0]->post_status,array(array(array('publish',false),array('future',false),array('private',false)),false)))) || ((0) == $post[0]->ID[0])))
 {if ( $can_publish[0])
 {if ( ((!((empty($post[0]->post_date_gmt) || Aspis_empty( $post[0] ->post_date_gmt )))) && (time() < strtotime((deconcat2($post[0]->post_date_gmt,' +0000'))))))
 {;
?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e(array('Schedule',false));
?>" />
		<input name="publish" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="<?php esc_attr_e(array('Schedule',false));
?>" />
<?php }else 
{;
?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e(array('Publish',false));
?>" />
		<input name="publish" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="<?php esc_attr_e(array('Publish',false));
?>" />
<?php }}else 
{;
?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e(array('Submit for Review',false));
?>" />
		<input name="publish" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="<?php esc_attr_e(array('Submit for Review',false));
?>" />
<?php }}else 
{{;
?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e(array('Update',false));
?>" />
		<input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="<?php esc_attr_e(array('Update',false));
?>" />
<?php }};
?>
</div>
<div class="clear"></div>
</div>
</div>

<?php  }
function post_tags_meta_box ( $post,$box ) {
$tax_name = esc_attr(Aspis_substr($box[0]['id'],array(8,false)));
$taxonomy = get_taxonomy($tax_name);
$helps = ((isset($taxonomy[0]->helps) && Aspis_isset( $taxonomy[0] ->helps ))) ? esc_attr($taxonomy[0]->helps) : __(array('Separate tags with commas.',false));
;
?>
<div class="tagsdiv" id="<?php echo AspisCheckPrint($tax_name);
;
?>">
	<div class="jaxtag">
	<div class="nojs-tags hide-if-js">
	<p><?php _e(array('Add or remove tags',false));
;
?></p>
	<textarea name="<?php echo AspisCheckPrint(concat2(concat1("tax_input[",$tax_name),"]"));
;
?>" class="the-tags" id="tax-input[<?php echo AspisCheckPrint($tax_name);
;
?>]"><?php echo AspisCheckPrint(esc_attr(get_terms_to_edit($post[0]->ID,$tax_name)));
;
?></textarea></div>

	<div class="ajaxtag hide-if-no-js">
		<label class="screen-reader-text" for="new-tag-<?php echo AspisCheckPrint($tax_name);
;
?>"><?php echo AspisCheckPrint($box[0]['title']);
;
?></label>
		<div class="taghint"><?php _e(array('Add new tag',false));
;
?></div>
		<input type="text" id="new-tag-<?php echo AspisCheckPrint($tax_name);
;
?>" name="newtag[<?php echo AspisCheckPrint($tax_name);
;
?>]" class="newtag form-input-tip" size="16" autocomplete="off" value="" />
		<input type="button" class="button tagadd" value="<?php esc_attr_e(array('Add',false));
;
?>" tabindex="3" />
	</div></div>
	<p class="howto"><?php echo AspisCheckPrint($helps);
;
?></p>
	<div class="tagchecklist"></div>
</div>
<p class="hide-if-no-js"><a href="#titlediv" class="tagcloud-link" id="link-<?php echo AspisCheckPrint($tax_name);
;
?>"><?php printf(deAspis(__(array('Choose from the most used tags in %s',false))),deAspisRC($box[0]['title']));
;
?></a></p>
<?php  }
function post_categories_meta_box ( $post ) {
;
?>
<ul id="category-tabs">
	<li class="tabs"><a href="#categories-all" tabindex="3"><?php _e(array('All Categories',false));
;
?></a></li>
	<li class="hide-if-no-js"><a href="#categories-pop" tabindex="3"><?php _e(array('Most Used',false));
;
?></a></li>
</ul>

<div id="categories-pop" class="tabs-panel" style="display: none;">
	<ul id="categorychecklist-pop" class="categorychecklist form-no-clear" >
<?php $popular_ids = wp_popular_terms_checklist(array('category',false));
;
?>
	</ul>
</div>

<div id="categories-all" class="tabs-panel">
	<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">
<?php wp_category_checklist($post[0]->ID,array(false,false),array(false,false),$popular_ids);
?>
	</ul>
</div>

<?php if ( deAspis(current_user_can(array('manage_categories',false))))
 {;
?>
<div id="category-adder" class="wp-hidden-children">
	<h4><a id="category-add-toggle" href="#category-add" class="hide-if-no-js" tabindex="3"><?php _e(array('+ Add New Category',false));
;
?></a></h4>
	<p id="category-add" class="wp-hidden-child">
	<label class="screen-reader-text" for="newcat"><?php _e(array('Add New Category',false));
;
?></label><input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="<?php esc_attr_e(array('New category name',false));
;
?>" tabindex="3" aria-required="true"/>
	<label class="screen-reader-text" for="newcat_parent"><?php _e(array('Parent category',false));
;
?>:</label><?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('newcat_parent',false,false),'orderby' => array('name',false,false),'hierarchical' => array(1,false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('Parent category',false)))),false));
;
?>
	<input type="button" id="category-add-sumbit" class="add:categorychecklist:category-add button" value="<?php esc_attr_e(array('Add',false));
;
?>" tabindex="3" />
<?php wp_nonce_field(array('add-category',false),array('_ajax_nonce',false),array(false,false));
;
?>
	<span id="category-ajax-response"></span></p>
</div>
<?php } }
function post_excerpt_meta_box ( $post ) {
;
?>
<label class="screen-reader-text" for="excerpt"><?php _e(array('Excerpt',false));
?></label><textarea rows="1" cols="40" name="excerpt" tabindex="6" id="excerpt"><?php echo AspisCheckPrint($post[0]->post_excerpt);
?></textarea>
<p><?php _e(array('Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="http://codex.wordpress.org/Excerpt" target="_blank">Learn more about manual excerpts.</a>',false));
;
?></p>
<?php  }
function post_trackback_meta_box ( $post ) {
$form_trackback = concat2(concat1('<input type="text" name="trackback_url" id="trackback_url" class="code" tabindex="7" value="',esc_attr(Aspis_str_replace(array("\n",false),array(' ',false),$post[0]->to_ping))),'" />');
if ( (('') != $post[0]->pinged[0]))
 {$pings = concat2(concat1('<p>',__(array('Already pinged:',false))),'</p><ul>');
$already_pinged = Aspis_explode(array("\n",false),Aspis_trim($post[0]->pinged));
foreach ( $already_pinged[0] as $pinged_url  )
{$pings = concat($pings,concat2(concat1("\n\t<li>",esc_html($pinged_url)),"</li>"));
}$pings = concat2($pings,'</ul>');
};
?>
<p><label for="trackback_url"><?php _e(array('Send trackbacks to:',false));
;
?></label> <?php echo AspisCheckPrint($form_trackback);
;
?><br /> (<?php _e(array('Separate multiple URLs with spaces',false));
;
?>)</p>
<p><?php _e(array('Trackbacks are a way to notify legacy blog systems that you&#8217;ve linked to them. If you link other WordPress blogs they&#8217;ll be notified automatically using <a href="http://codex.wordpress.org/Introduction_to_Blogging#Managing_Comments" target="_blank">pingbacks</a>, no other action necessary.',false));
;
?></p>
<?php if ( (!((empty($pings) || Aspis_empty( $pings)))))
 echo AspisCheckPrint($pings);
 }
function post_custom_meta_box ( $post ) {
;
?>
<div id="postcustomstuff">
<div id="ajax-response"></div>
<?php $metadata = has_meta($post[0]->ID);
list_meta($metadata);
meta_form();
;
?>
</div>
<p><?php _e(array('Custom fields can be used to add extra metadata to a post that you can <a href="http://codex.wordpress.org/Using_Custom_Fields" target="_blank">use in your theme</a>.',false));
;
?></p>
<?php  }
function post_comment_status_meta_box ( $post ) {
;
?>
<input name="advanced_view" type="hidden" value="1" />
<p class="meta-options">
	<label for="comment_status" class="selectit"><input name="comment_status" type="checkbox" id="comment_status" value="open" <?php checked($post[0]->comment_status,array('open',false));
;
?> /><?php _e(array('Allow Comments.',false));
?></label><br />
	<label for="ping_status" class="selectit"><input name="ping_status" type="checkbox" id="ping_status" value="open" <?php checked($post[0]->ping_status,array('open',false));
;
?> /><?php printf(deAspis(__(array('Allow <a href="%s" target="_blank">trackbacks and pingbacks</a> on this page.',false))),deAspisRC(_x(array('http://codex.wordpress.org/Introduction_to_Blogging#Managing_Comments',false),array('Url to codex article on Managing Comments',false))));
;
?></label>
</p>
<?php  }
function post_comment_meta_box ( $post ) {
global $wpdb,$post_ID;
$total = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT count(1) FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = '%d' AND ( comment_approved = '0' OR comment_approved = '1')"),$post_ID));
if ( ((1) > $total[0]))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('No comments yet.',false))),'</p>'));
return ;
}wp_nonce_field(array('get-comments',false),array('add_comment_nonce',false),array(false,false));
;
?>

<table class="widefat comments-box fixed" cellspacing="0" style="display:none;">
<thead><tr>
    <th scope="col" class="column-author"><?php _e(array('Author',false));
?></th>
    <th scope="col" class="column-comment">
<?php echo AspisCheckPrint(_x(array('Comment',false),array('noun',false)));
;
?></th>
</tr></thead>
<tbody id="the-comment-list" class="list:comment"></tbody>
</table>
<p class="hide-if-no-js"><a href="#commentstatusdiv" id="show-comments" onclick="commentsBox.get(<?php echo AspisCheckPrint($total);
;
?>);return false;"><?php _e(array('Show comments',false));
;
?></a> <img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" /></p>
<?php $hidden = get_hidden_meta_boxes(array('post',false));
if ( (denot_boolean(Aspis_in_array(array('commentsdiv',false),$hidden))))
 {;
?>
		<script type="text/javascript">jQuery(document).ready(function(){commentsBox.get(<?php echo AspisCheckPrint($total);
;
?>, 10);});</script>
<?php }wp_comment_trashnotice();
 }
function post_slug_meta_box ( $post ) {
;
?>
<label class="screen-reader-text" for="post_name"><?php _e(array('Slug',false));
?></label><input name="post_name" type="text" size="13" id="post_name" value="<?php echo AspisCheckPrint(esc_attr($post[0]->post_name));
;
?>" />
<?php  }
function post_author_meta_box ( $post ) {
global $current_user,$user_ID;
$authors = get_editable_user_ids($current_user[0]->id,array(true,false),$post[0]->post_type);
if ( ($post[0]->post_author[0] && (denot_boolean(Aspis_in_array($post[0]->post_author,$authors)))))
 arrayAssignAdd($authors[0][],addTaint($post[0]->post_author));
;
?>
<label class="screen-reader-text" for="post_author_override"><?php _e(array('Author',false));
;
?></label><?php wp_dropdown_users(array(array(deregisterTaint(array('include',false)) => addTaint($authors),'name' => array('post_author_override',false,false),deregisterTaint(array('selected',false)) => addTaint(((empty($post[0]->ID) || Aspis_empty( $post[0] ->ID ))) ? $user_ID : $post[0]->post_author)),false));
;
?>
<?php  }
function post_revisions_meta_box ( $post ) {
wp_list_post_revisions();
 }
function page_attributes_meta_box ( $post ) {
;
?>
<h5><?php _e(array('Parent',false));
?></h5>
<label class="screen-reader-text" for="parent_id"><?php _e(array('Page Parent',false));
?></label>
<?php wp_dropdown_pages(array(array(deregisterTaint(array('exclude_tree',false)) => addTaint($post[0]->ID),deregisterTaint(array('selected',false)) => addTaint($post[0]->post_parent),'name' => array('parent_id',false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('Main Page (no parent)',false))),'sort_column' => array('menu_order, post_title',false,false)),false));
;
?>
<p><?php _e(array('You can arrange your pages in hierarchies. For example, you could have an &#8220;About&#8221; page that has &#8220;Life Story&#8221; and &#8220;My Dog&#8221; pages under it. There are no limits to how deeply nested you can make pages.',false));
;
?></p>
<?php if ( ((0) != count(deAspis(get_page_templates()))))
 {;
?>
<h5><?php _e(array('Template',false));
?></h5>
<label class="screen-reader-text" for="page_template"><?php _e(array('Page Template',false));
?></label><select name="page_template" id="page_template">
<option value='default'><?php _e(array('Default Template',false));
;
?></option>
<?php page_template_dropdown($post[0]->page_template);
;
?>
</select>
<p><?php _e(array('Some themes have custom templates you can use for certain pages that might have additional features or custom layouts. If so, you&#8217;ll see them above.',false));
;
?></p>
<?php };
?>
<h5><?php _e(array('Order',false));
?></h5>
<p><label class="screen-reader-text" for="menu_order"><?php _e(array('Page Order',false));
?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo AspisCheckPrint(esc_attr($post[0]->menu_order));
?>" /></p>
<p><?php _e(array('Pages are usually ordered alphabetically, but you can put a number above to change the order pages appear in.',false));
;
?></p>
<?php  }
function link_submit_meta_box ( $link ) {
;
?>
<div class="submitbox" id="submitlink">

<div id="minor-publishing">

<?php ;
?>
<div style="display:none;">
<input type="submit" name="save" value="<?php esc_attr_e(array('Save',false));
;
?>" />
</div>

<div id="minor-publishing-actions">
<div id="preview-action">
<?php if ( (!((empty($link[0]->link_id) || Aspis_empty( $link[0] ->link_id )))))
 {;
?>
	<a class="preview button" href="<?php echo AspisCheckPrint($link[0]->link_url);
;
?>" target="_blank" tabindex="4"><?php _e(array('Visit Link',false));
;
?></a>
<?php };
?>
</div>
<div class="clear"></div>
</div>

<div id="misc-publishing-actions">
<div class="misc-pub-section misc-pub-section-last">
	<label for="link_private" class="selectit"><input id="link_private" name="link_visible" type="checkbox" value="N" <?php checked($link[0]->link_visible,array('N',false));
;
?> /> <?php _e(array('Keep this link private',false));
?></label>
</div>
</div>

</div>

<div id="major-publishing-actions">
<?php do_action(array('post_submitbox_start',false));
;
?>
<div id="delete-action">
<?php if ( (((!((empty($_GET[0][('action')]) || Aspis_empty( $_GET [0][('action')])))) && (('edit') == deAspis($_GET[0]['action']))) && deAspis(current_user_can(array('manage_links',false)))))
 {;
?>
	<a class="submitdelete deletion" href="<?php echo AspisCheckPrint(wp_nonce_url(concat1("link.php?action=delete&amp;link_id=",$link[0]->link_id),concat1('delete-bookmark_',$link[0]->link_id)));
;
?>" onclick="if ( confirm('<?php echo AspisCheckPrint(esc_js(Aspis_sprintf(__(array("You are about to delete this link '%s'\n  'Cancel' to stop, 'OK' to delete.",false)),$link[0]->link_name)));
;
?>') ) {return true;}return false;"><?php _e(array('Delete',false));
;
?></a>
<?php };
?>
</div>

<div id="publishing-action">
<?php if ( (!((empty($link[0]->link_id) || Aspis_empty( $link[0] ->link_id )))))
 {;
?>
	<input name="save" type="submit" class="button-primary" id="publish" tabindex="4" accesskey="p" value="<?php esc_attr_e(array('Update Link',false));
?>" />
<?php }else 
{{;
?>
	<input name="save" type="submit" class="button-primary" id="publish" tabindex="4" accesskey="p" value="<?php esc_attr_e(array('Add Link',false));
?>" />
<?php }};
?>
</div>
<div class="clear"></div>
</div>
<?php do_action(array('submitlink_box',false));
;
?>
<div class="clear"></div>
</div>
<?php  }
function link_categories_meta_box ( $link ) {
;
?>
<ul id="category-tabs">
	<li class="tabs"><a href="#categories-all"><?php _e(array('All Categories',false));
;
?></a></li>
	<li class="hide-if-no-js"><a href="#categories-pop"><?php _e(array('Most Used',false));
;
?></a></li>
</ul>

<div id="categories-all" class="tabs-panel">
	<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">
		<?php if ( ((isset($link[0]->link_id) && Aspis_isset( $link[0] ->link_id ))))
 wp_link_category_checklist($link[0]->link_id);
else 
{wp_link_category_checklist();
};
?>
	</ul>
</div>

<div id="categories-pop" class="tabs-panel" style="display: none;">
	<ul id="categorychecklist-pop" class="categorychecklist form-no-clear">
		<?php wp_popular_terms_checklist(array('link_category',false));
;
?>
	</ul>
</div>

<div id="category-adder" class="wp-hidden-children">
	<h4><a id="category-add-toggle" href="#category-add"><?php _e(array('+ Add New Category',false));
;
?></a></h4>
	<p id="link-category-add" class="wp-hidden-child">
		<label class="screen-reader-text" for="newcat"><?php _e(array('+ Add New Category',false));
;
?></label>
		<input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="<?php esc_attr_e(array('New category name',false));
;
?>" aria-required="true" />
		<input type="button" id="category-add-submit" class="add:categorychecklist:linkcategorydiv button" value="<?php esc_attr_e(array('Add',false));
;
?>" />
		<?php wp_nonce_field(array('add-link-category',false),array('_ajax_nonce',false),array(false,false));
;
?>
		<span id="category-ajax-response"></span>
	</p>
</div>
<?php  }
function link_target_meta_box ( $link ) {
;
?>
<fieldset><legend class="screen-reader-text"><span><?php _e(array('Target',false));
?></span></legend>
<p><label for="link_target_blank" class="selectit">
<input id="link_target_blank" type="radio" name="link_target" value="_blank" <?php echo AspisCheckPrint(((((isset($link[0]->link_target) && Aspis_isset( $link[0] ->link_target ))) && ($link[0]->link_target[0] == ('_blank'))) ? array('checked="checked"',false) : array('',false)));
;
?> />
<?php _e(array('<code>_blank</code> - new window or tab.',false));
;
?></label></p>
<p><label for="link_target_top" class="selectit">
<input id="link_target_top" type="radio" name="link_target" value="_top" <?php echo AspisCheckPrint(((((isset($link[0]->link_target) && Aspis_isset( $link[0] ->link_target ))) && ($link[0]->link_target[0] == ('_top'))) ? array('checked="checked"',false) : array('',false)));
;
?> />
<?php _e(array('<code>_top</code> - current window or tab, with no frames.',false));
;
?></label></p>
<p><label for="link_target_none" class="selectit">
<input id="link_target_none" type="radio" name="link_target" value="" <?php echo AspisCheckPrint(((((isset($link[0]->link_target) && Aspis_isset( $link[0] ->link_target ))) && ($link[0]->link_target[0] == (''))) ? array('checked="checked"',false) : array('',false)));
;
?> />
<?php _e(array('<code>_none</code> - same window or tab.',false));
;
?></label></p>
</fieldset>
<p><?php _e(array('Choose the target frame for your link.',false));
;
?></p>
<?php  }
function xfn_check ( $class,$value = array('',false),$deprecated = array('',false) ) {
global $link;
$link_rel = ((isset($link[0]->link_rel) && Aspis_isset( $link[0] ->link_rel ))) ? $link[0]->link_rel : array('',false);
$rels = Aspis_preg_split(array('/\s+/',false),$link_rel);
if ( ((('') != $value[0]) && deAspis(Aspis_in_array($value,$rels))))
 {echo AspisCheckPrint(array(' checked="checked"',false));
}if ( (('') == $value[0]))
 {if ( ((((((('family') == $class[0]) && (strpos($link_rel[0],'child') === false)) && (strpos($link_rel[0],'parent') === false)) && (strpos($link_rel[0],'sibling') === false)) && (strpos($link_rel[0],'spouse') === false)) && (strpos($link_rel[0],'kin') === false)))
 echo AspisCheckPrint(array(' checked="checked"',false));
if ( ((((('friendship') == $class[0]) && (strpos($link_rel[0],'friend') === false)) && (strpos($link_rel[0],'acquaintance') === false)) && (strpos($link_rel[0],'contact') === false)))
 echo AspisCheckPrint(array(' checked="checked"',false));
if ( (((('geographical') == $class[0]) && (strpos($link_rel[0],'co-resident') === false)) && (strpos($link_rel[0],'neighbor') === false)))
 echo AspisCheckPrint(array(' checked="checked"',false));
if ( ((('identity') == $class[0]) && deAspis(Aspis_in_array(array('me',false),$rels))))
 echo AspisCheckPrint(array(' checked="checked"',false));
} }
function link_xfn_meta_box ( $link ) {
;
?>
<table class="editform" style="width: 100%;" cellspacing="2" cellpadding="5">
	<tr>
		<th style="width: 20%;" scope="row"><label for="link_rel"><?php _e(array('rel:',false));
?></label></th>
		<td style="width: 80%;"><input type="text" name="link_rel" id="link_rel" size="50" value="<?php echo AspisCheckPrint((((isset($link[0]->link_rel) && Aspis_isset( $link[0] ->link_rel ))) ? esc_attr($link[0]->link_rel) : array('',false)));
;
?>" /></td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellpadding="3" cellspacing="5" class="form-table">
				<tr>
					<th scope="row"> <?php _e(array('identity',false));
?> </th>
					<td><fieldset><legend class="screen-reader-text"><span> <?php _e(array('identity',false));
?> </span></legend>
						<label for="me">
						<input type="checkbox" name="identity" value="me" id="me" <?php xfn_check(array('identity',false),array('me',false));
;
?> />
						<?php _e(array('another web address of mine',false));
?></label>
					</fieldset></td>
				</tr>
				<tr>
					<th scope="row"> <?php _e(array('friendship',false));
?> </th>
					<td><fieldset><legend class="screen-reader-text"><span> <?php _e(array('friendship',false));
?> </span></legend>
						<label for="contact">
						<input class="valinp" type="radio" name="friendship" value="contact" id="contact" <?php xfn_check(array('friendship',false),array('contact',false),array('radio',false));
;
?> /> <?php _e(array('contact',false));
?></label>
						<label for="acquaintance">
						<input class="valinp" type="radio" name="friendship" value="acquaintance" id="acquaintance" <?php xfn_check(array('friendship',false),array('acquaintance',false),array('radio',false));
;
?> />  <?php _e(array('acquaintance',false));
?></label>
						<label for="friend">
						<input class="valinp" type="radio" name="friendship" value="friend" id="friend" <?php xfn_check(array('friendship',false),array('friend',false),array('radio',false));
;
?> /> <?php _e(array('friend',false));
?></label>
						<label for="friendship">
						<input name="friendship" type="radio" class="valinp" value="" id="friendship" <?php xfn_check(array('friendship',false),array('',false),array('radio',false));
;
?> /> <?php _e(array('none',false));
?></label>
					</fieldset></td>
				</tr>
				<tr>
					<th scope="row"> <?php _e(array('physical',false));
?> </th>
					<td><fieldset><legend class="screen-reader-text"><span> <?php _e(array('physical',false));
?> </span></legend>
						<label for="met">
						<input class="valinp" type="checkbox" name="physical" value="met" id="met" <?php xfn_check(array('physical',false),array('met',false));
;
?> />
						<?php _e(array('met',false));
?></label>
					</fieldset></td>
				</tr>
				<tr>
					<th scope="row"> <?php _e(array('professional',false));
?> </th>
					<td><fieldset><legend class="screen-reader-text"><span> <?php _e(array('professional',false));
?> </span></legend>
						<label for="co-worker">
						<input class="valinp" type="checkbox" name="professional" value="co-worker" id="co-worker" <?php xfn_check(array('professional',false),array('co-worker',false));
;
?> />
						<?php _e(array('co-worker',false));
?></label>
						<label for="colleague">
						<input class="valinp" type="checkbox" name="professional" value="colleague" id="colleague" <?php xfn_check(array('professional',false),array('colleague',false));
;
?> />
						<?php _e(array('colleague',false));
?></label>
					</fieldset></td>
				</tr>
				<tr>
					<th scope="row"> <?php _e(array('geographical',false));
?> </th>
					<td><fieldset><legend class="screen-reader-text"><span> <?php _e(array('geographical',false));
?> </span></legend>
						<label for="co-resident">
						<input class="valinp" type="radio" name="geographical" value="co-resident" id="co-resident" <?php xfn_check(array('geographical',false),array('co-resident',false),array('radio',false));
;
?> />
						<?php _e(array('co-resident',false));
?></label>
						<label for="neighbor">
						<input class="valinp" type="radio" name="geographical" value="neighbor" id="neighbor" <?php xfn_check(array('geographical',false),array('neighbor',false),array('radio',false));
;
?> />
						<?php _e(array('neighbor',false));
?></label>
						<label for="geographical">
						<input class="valinp" type="radio" name="geographical" value="" id="geographical" <?php xfn_check(array('geographical',false),array('',false),array('radio',false));
;
?> />
						<?php _e(array('none',false));
?></label>
					</fieldset></td>
				</tr>
				<tr>
					<th scope="row"> <?php _e(array('family',false));
?> </th>
					<td><fieldset><legend class="screen-reader-text"><span> <?php _e(array('family',false));
?> </span></legend>
						<label for="child">
						<input class="valinp" type="radio" name="family" value="child" id="child" <?php xfn_check(array('family',false),array('child',false),array('radio',false));
;
?>  />
						<?php _e(array('child',false));
?></label>
						<label for="kin">
						<input class="valinp" type="radio" name="family" value="kin" id="kin" <?php xfn_check(array('family',false),array('kin',false),array('radio',false));
;
?>  />
						<?php _e(array('kin',false));
?></label>
						<label for="parent">
						<input class="valinp" type="radio" name="family" value="parent" id="parent" <?php xfn_check(array('family',false),array('parent',false),array('radio',false));
;
?> />
						<?php _e(array('parent',false));
?></label>
						<label for="sibling">
						<input class="valinp" type="radio" name="family" value="sibling" id="sibling" <?php xfn_check(array('family',false),array('sibling',false),array('radio',false));
;
?> />
						<?php _e(array('sibling',false));
?></label>
						<label for="spouse">
						<input class="valinp" type="radio" name="family" value="spouse" id="spouse" <?php xfn_check(array('family',false),array('spouse',false),array('radio',false));
;
?> />
						<?php _e(array('spouse',false));
?></label>
						<label for="family">
						<input class="valinp" type="radio" name="family" value="" id="family" <?php xfn_check(array('family',false),array('',false),array('radio',false));
;
?> />
						<?php _e(array('none',false));
?></label>
					</fieldset></td>
				</tr>
				<tr>
					<th scope="row"> <?php _e(array('romantic',false));
?> </th>
					<td><fieldset><legend class="screen-reader-text"><span> <?php _e(array('romantic',false));
?> </span></legend>
						<label for="muse">
						<input class="valinp" type="checkbox" name="romantic" value="muse" id="muse" <?php xfn_check(array('romantic',false),array('muse',false));
;
?> />
						<?php _e(array('muse',false));
?></label>
						<label for="crush">
						<input class="valinp" type="checkbox" name="romantic" value="crush" id="crush" <?php xfn_check(array('romantic',false),array('crush',false));
;
?> />
						<?php _e(array('crush',false));
?></label>
						<label for="date">
						<input class="valinp" type="checkbox" name="romantic" value="date" id="date" <?php xfn_check(array('romantic',false),array('date',false));
;
?> />
						<?php _e(array('date',false));
?></label>
						<label for="romantic">
						<input class="valinp" type="checkbox" name="romantic" value="sweetheart" id="romantic" <?php xfn_check(array('romantic',false),array('sweetheart',false));
;
?> />
						<?php _e(array('sweetheart',false));
?></label>
					</fieldset></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<p><?php _e(array('If the link is to a person, you can specify your relationship with them using the above form. If you would like to learn more about the idea check out <a href="http://gmpg.org/xfn/">XFN</a>.',false));
;
?></p>
<?php  }
function link_advanced_meta_box ( $link ) {
;
?>
<table class="form-table" style="width: 100%;" cellspacing="2" cellpadding="5">
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="link_image"><?php _e(array('Image Address',false));
?></label></th>
		<td><input type="text" name="link_image" class="code" id="link_image" size="50" value="<?php echo AspisCheckPrint((((isset($link[0]->link_image) && Aspis_isset( $link[0] ->link_image ))) ? esc_attr($link[0]->link_image) : array('',false)));
;
?>" style="width: 95%" /></td>
	</tr>
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="rss_uri"><?php _e(array('RSS Address',false));
?></label></th>
		<td><input name="link_rss" class="code" type="text" id="rss_uri" value="<?php echo AspisCheckPrint((((isset($link[0]->link_rss) && Aspis_isset( $link[0] ->link_rss ))) ? esc_attr($link[0]->link_rss) : array('',false)));
;
?>" size="50" style="width: 95%" /></td>
	</tr>
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="link_notes"><?php _e(array('Notes',false));
?></label></th>
		<td><textarea name="link_notes" id="link_notes" cols="50" rows="10" style="width: 95%"><?php echo AspisCheckPrint((((isset($link[0]->link_notes) && Aspis_isset( $link[0] ->link_notes ))) ? $link[0]->link_notes : array('',false)));
;
?></textarea></td>
	</tr>
	<tr class="form-field">
		<th valign="top"  scope="row"><label for="link_rating"><?php _e(array('Rating',false));
?></label></th>
		<td><select name="link_rating" id="link_rating" size="1">
		<?php for ( $r = array(0,false) ; ($r[0] <= (10)) ; postincr($r) )
{echo AspisCheckPrint((concat2(concat1('            <option value="',esc_attr($r)),'" ')));
if ( (((isset($link[0]->link_rating) && Aspis_isset( $link[0] ->link_rating ))) && ($link[0]->link_rating[0] == $r[0])))
 echo AspisCheckPrint(array('selected="selected"',false));
echo AspisCheckPrint((concat2(concat1('>',$r),'</option>')));
};
?></select>&nbsp;<?php _e(array('(Leave at 0 for no rating.)',false));
?>
		</td>
	</tr>
</table>
<?php  }
function post_thumbnail_meta_box (  ) {
global $post;
$thumbnail_id = get_post_meta($post[0]->ID,array('_thumbnail_id',false),array(true,false));
echo AspisCheckPrint(_wp_post_thumbnail_html($thumbnail_id));
 }
